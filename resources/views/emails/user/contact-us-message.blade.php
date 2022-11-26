@component('mail::message')
Hello Admin!

{{ $user->name }} Send a message : {{ $message }}



Thanks,<br>
{{ config('app.name') }}
@endcomponent
