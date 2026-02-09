@php
    $getLogoBase64 = function($filename) {
        $path = public_path("images/$filename");
        if (!file_exists($path)) return null;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    };

    $lightLogo = $getLogoBase64('logo-light.png');
    $darkLogo = $getLogoBase64('logo-dark.png');
@endphp

<div class="flex items-center justify-start w-full" style="margin-top: -50px !important; margin-inline-start: -18px !important;">
    <div class="fi-logo flex shrink-0 items-center justify-start">
        @if($lightLogo && $darkLogo)
            <picture class="flex items-center">
                <source media="(prefers-color-scheme: dark)" srcset="{{ $lightLogo }}">
                <img src="{{ $darkLogo }}" 
                     alt="Infinity Dental Lab" 
                     class="h-12 w-auto object-contain antialiased"
                     style="max-width: 150px;">
            </picture>
        @else
            <span class="text-xl font-bold tracking-tight text-primary-600 ps-4">
                INFINITY
            </span>
        @endif
    </div>
</div>