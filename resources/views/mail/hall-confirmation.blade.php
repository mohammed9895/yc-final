<x-mail::message>
    # Hello {{ $user->name }},

    Your hall {{ $hall }} reservation details are as follows:

    Start Time: {{ $start_time }}

    End Time: {{ $end_time }}

    <x-mail::button :url="$link">
        Add to calender
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
