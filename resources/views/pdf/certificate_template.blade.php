<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate</title>
    <style>
        @page {
            margin: 0px;
        }
        body {
            margin: 0px;
            padding: 0px;
            font-family: 'Helvetica', 'Arial', sans-serif;
            width: 100%;
            height: 100%;
        }
        .cert-container {
            position: relative;
            width: 100%;
            height: 100vh;
        }
        .bg-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .overlay-text {
            position: absolute;
            transform: translate(-50%, -50%);
            white-space: nowrap;
            font-weight: bold;
            text-align: center;
        }
        .signatory-block {
            position: absolute;
            transform: translate(-50%, -50%);
            text-align: center;
        }
        .signature-img {
            max-height: 60px;
            width: auto;
            display: block;
            margin: 0 auto 4px auto;
        }
    </style>
</head>
<body>
    @php
        // Convert background image to Base64 for guaranteed DomPDF rendering
        $bgFullPath = storage_path('app/public/' . $template->background_image_path);
        $bgBase64 = '';
        if (file_exists($bgFullPath)) {
            $bgData = file_get_contents($bgFullPath);
            $bgType = pathinfo($bgFullPath, PATHINFO_EXTENSION);
            $bgBase64 = 'data:image/' . $bgType . ';base64,' . base64_encode($bgData);
        }

        // Convert Signature image to Base64
        $sigBase64 = '';
        if ($template->signature_image_path) {
            $sigFullPath = storage_path('app/public/' . $template->signature_image_path);
            if (file_exists($sigFullPath)) {
                $sigData = file_get_contents($sigFullPath);
                $sigType = pathinfo($sigFullPath, PATHINFO_EXTENSION);
                $sigBase64 = 'data:image/' . $sigType . ';base64,' . base64_encode($sigData);
            }
        }

        $settings = $template->layout_settings ?? [];

        $nameX = $settings['recipient_name']['x'] ?? 50;
        $nameY = $settings['recipient_name']['y'] ?? 30;
        $nameSize = $settings['recipient_name']['font_size'] ?? 28;
        $nameColor = $settings['recipient_name']['color'] ?? '#1e293b';

        $titleX = $settings['activity_title']['x'] ?? 50;
        $titleY = $settings['activity_title']['y'] ?? 50;
        $titleSize = $settings['activity_title']['font_size'] ?? 20;
        $titleColor = $settings['activity_title']['color'] ?? '#334155';

        $dateX = $settings['issue_date']['x'] ?? 50;
        $dateY = $settings['issue_date']['y'] ?? 70;
        $dateSize = $settings['issue_date']['font_size'] ?? 14;
        $dateColor = $settings['issue_date']['color'] ?? '#64748b';

        $sigX = $settings['signatory']['x'] ?? 50;
        $sigY = $settings['signatory']['y'] ?? 82;
    @endphp

    <div class="cert-container">
        @if($bgBase64)
            <img src="{{ $bgBase64 }}" class="bg-img" alt="Certificate Background">
        @endif

        <!-- Recipient Name -->
        <div class="overlay-text" style="left: {{ $nameX }}%; top: {{ $nameY }}%; font-size: {{ $nameSize }}pt; color: {{ $nameColor }};">
            {{ $user->name }}
        </div>

        <!-- Activity Title -->
        <div class="overlay-text" style="left: {{ $titleX }}%; top: {{ $titleY }}%; font-size: {{ $titleSize }}pt; color: {{ $titleColor }};">
            {{ $activity->title }}
        </div>

        <!-- Issue Date -->
        <div class="overlay-text" style="left: {{ $dateX }}%; top: {{ $dateY }}%; font-size: {{ $dateSize }}pt; color: {{ $dateColor }};">
            Issued on {{ $issuedAt->format('F j, Y') }}
        </div>

        <!-- Signatory Block (PNG Signature + Name + Title) -->
        @if($template->signatory_name || $sigBase64)
            <div class="signatory-block" style="left: {{ $sigX }}%; top: {{ $sigY }}%;">
                @if($sigBase64)
                    <img src="{{ $sigBase64 }}" class="signature-img" alt="Signature">
                @endif
                @if($template->signatory_name)
                    <div style="font-size: 13pt; font-weight: bold; color: #1e293b; border-top: 1px solid #1e293b; padding-top: 3px;">
                        {{ $template->signatory_name }}
                    </div>
                @endif
                @if($template->signatory_title)
                    <div style="font-size: 10pt; color: #64748b;">
                        {{ $template->signatory_title }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</body>
</html>
