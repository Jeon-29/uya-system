@extends('layouts.admin')

@section('title', 'Create Certificate Template - Admin Dashboard')

@push('styles')
<style>
    .preview-canvas {
        position: relative;
        width: 100%;
        max-width: 720px;
        aspect-ratio: 1.414 / 1;
        background-color: #1e293b;
        border: 2px dashed #334155;
        border-radius: 12px;
        overflow: hidden;
        margin: 0 auto;
    }
    .preview-canvas img.bg-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .preview-text {
        position: absolute;
        transform: translate(-50%, -50%);
        white-space: nowrap;
        font-weight: bold;
        pointer-events: none;
    }
    .preview-sig-block {
        position: absolute;
        transform: translate(-50%, -50%);
        text-align: center;
        pointer-events: none;
    }
    .preview-sig-img {
        max-height: 40px;
        width: auto;
        display: block;
        margin: 0 auto;
    }
    .compact-label {
        font-size: 0.72rem;
        font-weight: 600;
        margin-bottom: 2px;
        color: var(--admin-text-subtle, #94a3b8);
    }
    .compact-input {
        font-size: 0.78rem !important;
        padding: 4px 8px !important;
    }
    .section-header {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--admin-accent-purple, #818cf8);
        margin-bottom: 6px;
    }
    .overlay-group {
        background-color: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        padding: 8px 10px;
        margin-bottom: 8px;
    }
</style>
@endpush

@section('content')
    <div class="container-fluid p-0">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h4 class="fw-bold text-white mb-0">Create Certificate Template</h4>
                <p class="text-subtle small mb-0" style="font-size: 0.78rem;">Upload background image and configure overlay coordinates.</p>
            </div>
            <a href="{{ route('admin.certificates.templates.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> Back to Templates
            </a>
        </div>

        <form method="POST" action="{{ route('admin.certificates.templates.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <!-- Left: Bigger Live Preview Canvas (60% width) -->
                <div class="col-lg-7">
                    <div class="card p-3 border-0 h-100" style="background-color: var(--admin-card-bg); border-radius: 14px;">
                        <h6 class="fw-bold text-white mb-3" style="font-size: 0.9rem;"><i class="fa-regular fa-eye text-primary me-1.5"></i>Live Layout Preview</h6>

                        <div class="preview-canvas" id="previewCanvas">
                            <img id="bgPreviewImg" src="" alt="Background Preview" class="bg-img d-none">
                            <div id="noImgNotice" class="d-flex align-items-center justify-content-center h-100 text-muted small" style="font-size: 0.78rem;">
                                Upload a background image to view preview
                            </div>

                            <div id="prevName" class="preview-text" style="left: 50%; top: 23%; font-size: 24px; color: #1e293b;">[Recipient Name]</div>
                            <div id="prevTitle" class="preview-text" style="left: 50%; top: 49%; font-size: 21px; color: #334155;">[Activity Title]</div>
                            <div id="prevDate" class="preview-text" style="left: 50%; top: 75%; font-size: 14px; color: #64748b;">[Issue Date]</div>

                            <!-- Signatory Live Preview -->
                            <div id="prevSigBlock" class="preview-sig-block" style="left: 50%; top: 85%;">
                                <img id="sigPreviewImg" src="" class="preview-sig-img d-none">
                                <div id="prevSigName" class="text-white fw-bold mt-1" style="font-size: 0.75rem; border-top: 1px solid rgba(255,255,255,0.4);">[Signatory Name]</div>
                                <div id="prevSigTitle" class="text-subtle" style="font-size: 0.65rem;">[Signatory Title]</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Compact Form Controls (40% width) -->
                <div class="col-lg-5">
                    <div class="card p-3 border-0" style="background-color: var(--admin-card-bg); border-radius: 14px;">
                        <h6 class="fw-bold text-white mb-2" style="font-size: 0.88rem;"><i class="fa-solid fa-sliders text-primary me-1.5"></i>Template Configuration</h6>

                        <!-- Header Details -->
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="compact-label">Template Title *</label>
                                <input type="text" name="title" class="form-control compact-input bg-dark text-white border-secondary rounded-3" placeholder="CleanUp Activity" required>
                            </div>
                            <div class="col-6">
                                <label class="compact-label">Background Image *</label>
                                <input type="file" id="bgImageInput" name="background_image" class="form-control compact-input bg-dark text-white border-secondary rounded-3" accept="image/*" required>
                            </div>
                        </div>

                        <!-- Signatory Details -->
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="compact-label">Signatory Name</label>
                                <input type="text" id="inputSigName" name="signatory_name" class="form-control compact-input bg-dark text-white border-secondary rounded-3" placeholder="Anjelo Masibay">
                            </div>
                            <div class="col-6">
                                <label class="compact-label">Signatory Title</label>
                                <input type="text" id="inputSigTitle" name="signatory_title" class="form-control compact-input bg-dark text-white border-secondary rounded-3" placeholder="Organizer">
                            </div>
                            <div class="col-12 mt-1">
                                <label class="compact-label">Signature PNG File</label>
                                <input type="file" id="sigImageInput" name="signature_image" class="form-control compact-input bg-dark text-white border-secondary rounded-3" accept="image/png">
                            </div>
                        </div>

                        <hr class="border-secondary opacity-25 my-2">

                        <!-- 1. Recipient Name Overlay -->
                        <div class="overlay-group">
                            <div class="section-header">1. Recipient Name Overlay</div>
                            <div class="row g-1.5 align-items-center">
                                <div class="col-3">
                                    <label class="compact-label">Horiz X (%)</label>
                                    <input type="number" id="inputNameX" name="name_x" value="50" min="0" max="100" class="form-control compact-input bg-dark text-white border-secondary rounded-3" required>
                                </div>
                                <div class="col-3">
                                    <label class="compact-label">Vert Y (%)</label>
                                    <input type="number" id="inputNameY" name="name_y" value="23" min="0" max="100" class="form-control compact-input bg-dark text-white border-secondary rounded-3" required>
                                </div>
                                <div class="col-3">
                                    <label class="compact-label">Size (px)</label>
                                    <input type="number" id="inputNameSize" name="name_font_size" value="24" min="10" max="72" class="form-control compact-input bg-dark text-white border-secondary rounded-3" required>
                                </div>
                                <div class="col-3">
                                    <label class="compact-label">Text Color</label>
                                    <input type="color" id="inputNameColor" name="name_color" value="#1e293b" class="form-control form-control-color bg-dark border-secondary w-100 rounded-3 p-0" style="height: 28px;" required>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Activity Title Overlay -->
                        <div class="overlay-group">
                            <div class="section-header">2. Activity Title Overlay</div>
                            <div class="row g-1.5 align-items-center">
                                <div class="col-3">
                                    <label class="compact-label">Horiz X (%)</label>
                                    <input type="number" id="inputTitleX" name="title_x" value="50" min="0" max="100" class="form-control compact-input bg-dark text-white border-secondary rounded-3" required>
                                </div>
                                <div class="col-3">
                                    <label class="compact-label">Vert Y (%)</label>
                                    <input type="number" id="inputTitleY" name="title_y" value="49" min="0" max="100" class="form-control compact-input bg-dark text-white border-secondary rounded-3" required>
                                </div>
                                <div class="col-3">
                                    <label class="compact-label">Size (px)</label>
                                    <input type="number" id="inputTitleSize" name="title_font_size" value="21" min="10" max="72" class="form-control compact-input bg-dark text-white border-secondary rounded-3" required>
                                </div>
                                <div class="col-3">
                                    <label class="compact-label">Text Color</label>
                                    <input type="color" id="inputTitleColor" name="title_color" value="#334155" class="form-control form-control-color bg-dark border-secondary w-100 rounded-3 p-0" style="height: 28px;" required>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Issue Date Overlay -->
                        <div class="overlay-group">
                            <div class="section-header">3. Issue Date Overlay</div>
                            <div class="row g-1.5 align-items-center">
                                <div class="col-3">
                                    <label class="compact-label">Horiz X (%)</label>
                                    <input type="number" id="inputDateX" name="date_x" value="50" min="0" max="100" class="form-control compact-input bg-dark text-white border-secondary rounded-3" required>
                                </div>
                                <div class="col-3">
                                    <label class="compact-label">Vert Y (%)</label>
                                    <input type="number" id="inputDateY" name="date_y" value="75" min="0" max="100" class="form-control compact-input bg-dark text-white border-secondary rounded-3" required>
                                </div>
                                <div class="col-3">
                                    <label class="compact-label">Size (px)</label>
                                    <input type="number" id="inputDateSize" name="date_font_size" value="14" min="10" max="72" class="form-control compact-input bg-dark text-white border-secondary rounded-3" required>
                                </div>
                                <div class="col-3">
                                    <label class="compact-label">Text Color</label>
                                    <input type="color" id="inputDateColor" name="date_color" value="#64748b" class="form-control form-control-color bg-dark border-secondary w-100 rounded-3 p-0" style="height: 28px;" required>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Signatory Block Position -->
                        <div class="overlay-group mb-2">
                            <div class="section-header">4. Signatory Block Position</div>
                            <div class="row g-1.5 align-items-center">
                                <div class="col-6">
                                    <label class="compact-label">Horiz X (%)</label>
                                    <input type="number" id="inputSigX" name="sig_x" value="50" min="0" max="100" class="form-control compact-input bg-dark text-white border-secondary rounded-3" required>
                                </div>
                                <div class="col-6">
                                    <label class="compact-label">Vert Y (%)</label>
                                    <input type="number" id="inputSigY" name="sig_y" value="85" min="0" max="100" class="form-control compact-input bg-dark text-white border-secondary rounded-3" required>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-2 border-top border-white border-opacity-10">
                            <a href="{{ route('admin.certificates.templates.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Cancel</a>
                            <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4 fw-bold">Save Template</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('bgImageInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                const img = document.getElementById('bgPreviewImg');
                img.src = evt.target.result;
                img.classList.remove('d-none');
                document.getElementById('noImgNotice').classList.add('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('sigImageInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                const img = document.getElementById('sigPreviewImg');
                img.src = evt.target.result;
                img.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    function syncTextOverlay(xId, yId, sizeId, colorId, targetId) {
        const xVal = document.getElementById(xId).value;
        const yVal = document.getElementById(yId).value;
        const sizeVal = document.getElementById(sizeId).value;
        const colorVal = document.getElementById(colorId).value;

        const target = document.getElementById(targetId);
        target.style.left = xVal + '%';
        target.style.top = yVal + '%';
        target.style.fontSize = sizeVal + 'px';
        target.style.color = colorVal;
    }

    function syncSigBlock() {
        const xVal = document.getElementById('inputSigX').value;
        const yVal = document.getElementById('inputSigY').value;
        const nameVal = document.getElementById('inputSigName').value;
        const titleVal = document.getElementById('inputSigTitle').value;

        const target = document.getElementById('prevSigBlock');
        target.style.left = xVal + '%';
        target.style.top = yVal + '%';

        document.getElementById('prevSigName').innerText = nameVal || '[Signatory Name]';
        document.getElementById('prevSigTitle').innerText = titleVal || '[Signatory Title]';
    }

    ['inputNameX', 'inputNameY', 'inputNameSize', 'inputNameColor'].forEach(id => {
        document.getElementById(id).addEventListener('input', () => syncTextOverlay('inputNameX', 'inputNameY', 'inputNameSize', 'inputNameColor', 'prevName'));
    });
    ['inputTitleX', 'inputTitleY', 'inputTitleSize', 'inputTitleColor'].forEach(id => {
        document.getElementById(id).addEventListener('input', () => syncTextOverlay('inputTitleX', 'inputTitleY', 'inputTitleSize', 'inputTitleColor', 'prevTitle'));
    });
    ['inputDateX', 'inputDateY', 'inputDateSize', 'inputDateColor'].forEach(id => {
        document.getElementById(id).addEventListener('input', () => syncTextOverlay('inputDateX', 'inputDateY', 'inputDateSize', 'inputDateColor', 'prevDate'));
    });
    ['inputSigX', 'inputSigY', 'inputSigName', 'inputSigTitle'].forEach(id => {
        document.getElementById(id).addEventListener('input', syncSigBlock);
    });
</script>
@endpush
