<a href="/">
    <div class="flex items-center justify-center" x-data="{ mode: 'light' }" x-on:dark-mode-toggled.window="mode = $event.detail">
        <img x-show="mode === 'light'" src="{{ asset('/images/YC-logo.png') }}" alt="Logo" class="w-44">
        <img x-show="mode === 'dark'" src="{{ asset('/images/yc-logo-white.svg') }}" class="w-44" alt="Logo">
    </div>

</a>
