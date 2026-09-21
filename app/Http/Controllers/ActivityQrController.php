<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityParticipant;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ActivityQrController extends Controller
{
    /**
     * Generate dynamic, single-use QR check-in payload for Admin/Officer view.
     */
    public function generatePayload(Request $request, Activity $activity)
    {
        if (!$activity->is_attendance_open) {
            return response()->json(['error' => 'Attendance check-in is currently closed for this activity.'], 422);
        }

        // Get selected display interval from request (5s, 10s, 30s), defaulting to 10s
        $ttl = (int) $request->query('ttl', 10);

        // Add a small 3-second network buffer (e.g. 10s interval = 13s max valid window)
        $cacheLifetime = $ttl > 0 ? ($ttl + 3) : 300; // If set to manual (0), keep token valid for 5 mins

        // Generate a unique single-use token and cache it with dynamic TTL
        $nonce = Str::random(32);
        $cacheKey = "qr_nonce_{$activity->id}_{$nonce}";

        Cache::put($cacheKey, [
            'activity_id'  => $activity->id,
            'generated_at' => now()->timestamp,
            'max_age'      => $cacheLifetime,
        ], $cacheLifetime);

        return response()->json([
            'activity_id' => $activity->id,
            'token'       => $nonce,
            'qr_url'      => 'https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=' . urlencode($nonce),
        ]);
    }

    /**
     * Process member QR scan submission and calculate Late status.
     */
    public function processScan(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $token = $request->token;

        $cachedData = null;
        $foundKey = null;

        // Direct token search across active activities
        $activities = Activity::where('is_attendance_open', true)->get();
        foreach ($activities as $act) {
            $key = "qr_nonce_{$act->id}_{$token}";
            if (Cache::has($key)) {
                $cachedData = Cache::get($key);
                $foundKey = $key;
                break;
            }
        }

        if (!$cachedData) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired QR code. Please scan the newly displayed QR code on screen.'
            ], 400);
        }

        // Strictly enforce expiration against token generation timestamp
        $tokenAge = now()->timestamp - ($cachedData['generated_at'] ?? 0);
        $allowedAge = $cachedData['max_age'] ?? 15;

        if ($tokenAge > $allowedAge) {
            Cache::forget($foundKey);
            return response()->json([
                'success' => false,
                'message' => 'This QR code has expired! Please scan the current code on screen.'
            ], 400);
        }

        // Burn single-use token immediately to prevent duplicate scans
        Cache::forget($foundKey);

        $activity = Activity::find($cachedData['activity_id']);

        if (!$activity || !$activity->is_attendance_open) {
            return response()->json([
                'success' => false,
                'message' => 'Attendance check-in is closed for this activity.'
            ], 422);
        }

        $user = auth()->user();
        $participant = ActivityParticipant::where('activity_id', $activity->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$participant || !in_array($participant->status, ['registered', 'attended', 'late'])) {
            return response()->json([
                'success' => false,
                'message' => 'You must be registered for this activity to check in.'
            ], 403);
        }

        if (in_array($participant->status, ['attended', 'late'])) {
            return response()->json([
                'success' => true,
                'state'   => $participant->status,
                'message' => "Attendance already verified! Marked as " . ucfirst($participant->status) . "."
            ]);
        }

        // Calculate if member is late (e.g., scanned > 15 mins after event start time)
        $lateThreshold = $activity->date->copy()->addMinutes(15);
        $finalStatus = now()->greaterThan($lateThreshold) ? 'late' : 'attended';

        $participant->update([
            'status'        => $finalStatus,
            'check_in_time' => now(),
        ]);

        ActivityLog::record('QR Check-In', "Member {$user->name} checked in via single-use QR scan for \"{$activity->title}\" (Status: {$finalStatus}).");

        $statusText = $finalStatus === 'late' ? 'Late' : 'On Time';

        return response()->json([
            'success' => true,
            'state'   => $finalStatus,
            'message' => "Successfully Verified Attendance! You are marked as {$statusText}.",
        ]);
    }
}
