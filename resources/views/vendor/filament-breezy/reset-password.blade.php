 @if($isResetting)
 @push('stylesss')
 <style>
        body {
            font-family: IBM Plex Sans Arabic, sans-serif;
        }
        
        .w-44 {
            width: 11rem;
        }

        .dark .filament-login-page {
            background-image: radial-gradient(circle at top, #6b21a8, #1f2937, #111827 100%) !important;
        }

        .dark .filament-login-page form:before {
            --tw-gradient-from: #374151;
            --tw-gradient-to: rgba(55, 65, 81, 0);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
            --tw-gradient-to: rgba(251, 191, 36, 0);
            --tw-gradient-stops: var(--tw-gradient-from), #c084fc, var(--tw-gradient-to);
            --tw-gradient-to: #374151;
        }
        
        .filament-login-page {
            position: relative;
            background-repeat: no-repeat;
            background-image: radial-gradient(circle at top,#f3e8ff,#fff 50%);
        }

        .dark .filament-login-page form:before {
            --tw-gradient-from: #374151;
            --tw-gradient-to: rgba(55, 65, 81, 0);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
            --tw-gradient-to: rgba(251, 191, 36, 0);
            --tw-gradient-stops: var(--tw-gradient-from), #c084fc, var(--tw-gradient-to);
            --tw-gradient-to: #374151;
        }
        
        .filament-login-page form:before{
                position: absolute;
                left: 0px;
                right: 0px;
                margin-left: auto;
                margin-right: auto;
                height: 1px;
                width: 66.666667%;
                background-image: linear-gradient(to right,var(--tw-gradient-stops));
                --tw-gradient-from: #e5e7eb;
                --tw-gradient-to: rgb(229 231 235 / 0);
                --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
                --tw-gradient-to: rgb(192 132 252 / 0);
                --tw-gradient-stops: var(--tw-gradient-from), #c084fc, var(--tw-gradient-to);
                --tw-gradient-to: #e5e7eb;
        }

        .bg-primary-600 {
            background: #6b21a8 !important;
        }

        .text-primary-600 {
            color: #7b2bc4;
        }
        
        .border-gray-300 {
            border-color: rgb(209 213 219 / var(--tw-border-opacity));
        }
        
        [type="password"] {
            border-color: #e5e7eb !important;
        }

        .dark label span {
            color: white !important;
        }

        input {
            color: #222;
        }
        .focus\:ring-primary-500:focus {
            --tw-ring-opacity: 1;
            --tw-ring-color: #7b2bc4;
        }
    </style>
    @endpush
 @endif
<x-filament-breezy::auth-card action="submit">
    <div class="w-full flex justify-center">
        <x-filament::brand />
    </div>

    <div>
        <h2 class="font-bold tracking-tight text-center text-2xl">
            {{ __('filament-breezy::default.reset_password.heading') }}
        </h2>
        <p class="mt-2 text-sm text-center">
            {{ __('filament-breezy::default.or') }}
            <a class="text-primary-600" href="{{route('filament.auth.login')}}">
                {{ strtolower(__('filament::login.heading')) }}
            </a>
        </p>
    </div>

    @unless($hasBeenSent)
    {{ $this->form }}

    <x-filament::button type="submit" class="w-full">
        {{ __('filament-breezy::default.reset_password.submit.label') }}
    </x-filament::button>
    @else
    <span class="block text-center text-success-600 font-semibold">{{ __('filament-breezy::default.reset_password.notification_success') }}</span>
    @endunless
</x-filament-breezy::auth-card>
