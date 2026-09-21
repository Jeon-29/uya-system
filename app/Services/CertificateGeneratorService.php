<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Certificate;
use App\Models\CertificateTemplate;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CertificateGeneratorService
{
    /**
     * Generate or update a certificate for a single user for a given activity.
     */
    public function generateForUser(Activity $activity, User $user): ?Certificate
    {
        if (!$activity->certificate_template_id) {
            return null;
        }

        $template = CertificateTemplate::find($activity->certificate_template_id);
        if (!$template) {
            return null;
        }

        $issuedAt = now();
        $fileName = "cert_{$activity->id}_{$user->id}_" . time() . ".pdf";
        $pdfStoragePath = "certificates/{$fileName}";

        // Render Blade template to HTML
        $html = view('pdf.certificate_template', [
            'template' => $template,
            'activity' => $activity,
            'user'     => $user,
            'issuedAt' => $issuedAt,
        ])->render();

        // Load HTML into DomPDF with Landscape A4 dimensions
        $pdf = Pdf::loadHTML($html)
            ->setPaper('a4', 'landscape')
            ->setWarnings(false);

        // Save generated PDF to public storage
        Storage::disk('public')->put($pdfStoragePath, $pdf->output());

        // Create or update database entry
        return Certificate::updateOrCreate(
            [
                'user_id'     => $user->id,
                'activity_id' => $activity->id,
            ],
            [
                'template_id' => $template->id,
                'pdf_path'    => $pdfStoragePath,
                'issued_at'   => $issuedAt,
            ]
        );
    }

    /**
     * Batch generate certificates for eligible participants based on activity issuance rules.
     */
    public function batchGenerateForActivity(Activity $activity): int
    {
        if (!$activity->certificate_template_id) {
            return 0;
        }

        $query = $activity->participants();

        if ($activity->certificate_issuance_rule === 'all_registered') {
            $query->whereIn('status', ['registered', 'attended', 'late']);
        } else {
            // Default: 'attendance' (marked present / attended)
            $query->whereIn('status', ['attended', 'late']);
        }

        $eligibleUserIds = $query->pluck('user_id');
        $users = User::whereIn('id', $eligibleUserIds)->get();

        $generatedCount = 0;
        foreach ($users as $user) {
            if ($this->generateForUser($activity, $user)) {
                $generatedCount++;
            }
        }

        return $generatedCount;
    }
}
