@component('mail::message')
Hello! {{ $student->user->name }}

We already created an account for you, to access your account in our Web Monitoring system
Please use these login credintials:

@component('mail::panel')
Email: {{ $student->user->email }}
@endcomponent
@component('mail::panel')
Password: {{ $password }}
@endcomponent

Please change your password right after you login
@component('mail::button', ['url' => route('home')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
