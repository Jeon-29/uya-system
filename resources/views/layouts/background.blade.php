<style>
    /* Soft pastel base tint matching logo colors */
    html body {
        background-color: #dbe4e8;
    }

    .uya-bg {
        --R: clamp(140px, 22vmin, 280px);   /* radius of bottom-left ring */
        --R2: calc(var(--R) * 0.6);         /* radius of top-right ring */
        position: fixed;
        inset: 0;
        z-index: -1;
        overflow: hidden;
        pointer-events: none;
        background: linear-gradient(135deg, #f2e291 0%, #b4d2d9 45%, #7677bd 100%);
    }

    /* Diagonal translucent pastel panels */
    .uya-band {
        position: absolute;
        left: -45vmax;
        width: 190vmax;
        transform: rotate(34deg);
        background: rgba(255, 255, 255, 0.45);
        box-shadow: 0 0 70px rgba(34, 77, 91, 0.05);
    }
    .uya-band-1 { top: -35vmax; height: 18vmax; background: rgba(255, 255, 255, 0.25); }
    .uya-band-2 { top: -22vmax; height: 30vmax; }
    .uya-band-3 { top: -2vmax;  height: 16vmax; background: rgba(131, 182, 190, 0.12); }
    .uya-band-4 { top: 22vmax;  height: 22vmax; background: rgba(216, 230, 234, 0.3); }
    .uya-band-5 { top: 44vmax;  height: 12vmax; background: rgba(255, 255, 255, 0.35); }
    .uya-band-6 { top: 58vmax;  height: 14vmax; background: rgba(131, 182, 190, 0.12); }
    .uya-band-7 { top: 75vmax;  height: 20vmax; background: rgba(255, 255, 255, 0.2); }

    /* Gold-to-indigo gradient rings (calmed opacity for text clarity) */
    .uya-ring {
        --hole: 76%;
        position: absolute;
        border-radius: 50%;
        background: linear-gradient(135deg, #e9cb5f 0%, #b9a35a 28%, #7568b8 62%, #4a3fc4 100%);
        -webkit-mask: radial-gradient(farthest-side, transparent var(--hole), #000 calc(var(--hole) + 0.5px));
                mask: radial-gradient(farthest-side, transparent var(--hole), #000 calc(var(--hole) + 0.5px));
        opacity: 0.55;
    }

    /* Bottom-left cluster */
    .uya-ring-bl {
        width: calc(var(--R) * 2);
        height: calc(var(--R) * 2);
        left: calc(var(--R) * -1);
        bottom: calc(var(--R) * -1);
    }
    .uya-ring-bl-md {
        --hole: 62%;
        width: calc(var(--R) * 0.44);
        height: calc(var(--R) * 0.44);
        left: calc(var(--R) * 1.18);
        bottom: calc(var(--R) * 0.34);
    }
    .uya-ring-bl-sm {
        --hole: 55%;
        width: calc(var(--R) * 0.2);
        height: calc(var(--R) * 0.2);
        left: calc(var(--R) * 0.96);
        bottom: calc(var(--R) * 0.82);
    }

    /* Top-right cluster */
    .uya-ring-tr {
        width: calc(var(--R2) * 2);
        height: calc(var(--R2) * 2);
        right: calc(var(--R2) * -0.35);
        top: calc(var(--R2) * -0.75);
    }
    .uya-ring-tr-md {
        --hole: 58%;
        width: calc(var(--R2) * 0.67);
        height: calc(var(--R2) * 0.67);
        right: calc(var(--R2) * 0.155);
        top: calc(var(--R2) * 2);
    }
    .uya-ring-tr-sm {
        --hole: 55%;
        width: calc(var(--R2) * 0.29);
        height: calc(var(--R2) * 0.29);
        right: calc(var(--R2) * 1.07);
        top: calc(var(--R2) * 1.82);
    }

    .uya-seal {
        position: absolute;
        right: -14vmin;
        top: -8vmin;
        width: clamp(320px, 62vmin, 760px);
        height: auto;
        opacity: 0.08;
    }

    @media (max-width: 767px) {
        .uya-bg { --R: clamp(110px, 26vw, 170px); }
        .uya-ring { opacity: 0.4; }
        .uya-seal { opacity: 0.05; }
    }

    @media print {
        .uya-bg { display: none; }
    }
</style>

<div class="uya-bg" aria-hidden="true">
    <span class="uya-band uya-band-1"></span>
    <span class="uya-band uya-band-2"></span>
    <span class="uya-band uya-band-3"></span>
    <span class="uya-band uya-band-4"></span>
    <span class="uya-band uya-band-5"></span>
    <span class="uya-band uya-band-6"></span>
    <span class="uya-band uya-band-7"></span>

    @if (file_exists(public_path('images/logo.jpg')))
        <img class="uya-seal" src="{{ asset('images/logo.jpg') }}" alt="">
    @endif

    <span class="uya-ring uya-ring-bl"></span>
    <span class="uya-ring uya-ring-bl-md"></span>
    <span class="uya-ring uya-ring-bl-sm"></span>

    <span class="uya-ring uya-ring-tr"></span>
    <span class="uya-ring uya-ring-tr-md"></span>
    <span class="uya-ring uya-ring-tr-sm"></span>
</div>
