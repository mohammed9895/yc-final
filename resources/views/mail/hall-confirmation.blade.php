<x-mail::message>
# Hello {{ $user->name }},

Your hall {{ $hall }} reservation details are as follows:

Start Time: {{ $start_time }}

End Time: {{ $end_time }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
