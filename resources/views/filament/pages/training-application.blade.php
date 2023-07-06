<x-filament::page>
    <h1 class="font-bold">
        {{ __('Youth Center announces the provision of 11 training opportunities in the following governorates') }}
    </h1>
    <ul>
        <li>
            {{ __(' 4 Trainees in Dhofar Governorate') }}
        </li>
        <li>
            {{ __('2 Trainees in Sharqiyah North Governorate') }}
        </li>
        <li>
            {{ __('3 Trainees in Muscat Governorate') }}
        </li>
        <li>
            {{ __('2 Trainees in Dakhiliyah Governorate') }}
        </li>
    </ul>

    <h3 class="font-bold">{{ __('According to the following conditions:') }}</h3>
    <ul>
        <li>{{ __('Priority for jobseekers.') }}</li>
        <li>{{ __('The applicant must be a resident of the required province.') }}</li>
        <li>{{ __('The applicant must be between 20-29 years old.') }}</li>
        <li>{{ __('The training period will be for two months (July 15th to September 15th).') }}</li>
        <li>{{ __('The monthly allowance is 200 Omani Rials.') }}</li>
        <li>{{ __('A training certificate will be provided to the trainees from the center.') }}</li>
        <li>{{ __('') }}</li>
        <li>{{ __('') }}</li>
    </ul>

    <h3 class="font-bold">{{ __('Required Skills:') }}</h3>
    <ul>
        <li>{{ __('Good communication skills') }}</li>
        <li>{{ __('Negotiation') }}</li>
        <li>{{ __('Dealing with computers') }}</li>
        <li>{{ __('Speed and intuitiveness in work') }}</li>
    </ul>
    <form wire:submit.prevent="register">
        {{ $this->form }}
        <button
            class="filament-button mt-4 filament-button-size-sm inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2rem] px-3 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700">{{ __('Register') }}</button>
    </form>
</x-filament::page>
