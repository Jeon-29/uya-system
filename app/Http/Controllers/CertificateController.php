<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    /**
     * Display a listing of the member's certificates.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $tab = $request->query('tab', 'active');

        if ($tab === 'archived') {
            $query = Certificate::onlyTrashed();
        } else {
            $query = Certificate::query();
        }

        $query->with(['activity', 'template'])->where('user_id', auth()->id());

        if ($search) {
            $query->whereHas('activity', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $certificates = $query->orderBy('issued_at', 'desc')->paginate(9)->withQueryString();

        $activeCount = Certificate::where('user_id', auth()->id())->count();
        $archivedCount = Certificate::onlyTrashed()->where('user_id', auth()->id())->count();

        return view('certificates', compact('certificates', 'search', 'tab', 'activeCount', 'archivedCount'));
    }

    /**
     * Single-click download endpoint for the member's PDF certificate.
     */
    public function download(Certificate $certificate)
    {
        if ($certificate->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access to this certificate.');
        }

        if (!Storage::disk('public')->exists($certificate->pdf_path)) {
            return back()->with('error', 'Certificate file not found on server.');
        }

        $activityTitle = Str::slug($certificate->activity->title ?? 'activity');
        $fileName = "Certificate_{$activityTitle}.pdf";

        return Storage::disk('public')->download($certificate->pdf_path, $fileName);
    }

    /**
     * Archive (Soft Delete) a certificate for the member.
     */
    public function archive(Certificate $certificate)
    {
        if ($certificate->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $certificate->delete();

        return back()->with('success', 'Certificate moved to archive.');
    }

    /**
     * Restore an archived certificate.
     */
    public function restore($id)
    {
        $certificate = Certificate::onlyTrashed()
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        $certificate->restore();

        return back()->with('success', 'Certificate restored successfully.');
    }

    /**
     * Permanently delete a certificate record and its storage file.
     */
    public function destroy($id)
    {
        $certificate = Certificate::onlyTrashed()
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        if (Storage::disk('public')->exists($certificate->pdf_path)) {
            Storage::disk('public')->delete($certificate->pdf_path);
        }

        $certificate->forceDelete();

        return back()->with('success', 'Certificate permanently deleted.');
    }
}
