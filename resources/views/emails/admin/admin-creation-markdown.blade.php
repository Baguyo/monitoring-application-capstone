@component('mail::message')
Hello Admin! {{ $user->name }}

We already created an account for you, to access your account in our Web Monitoring system
Please use these login credintials:

@component('mail::panel')
Email: {{ $user->email }}
@endcomponent
@component('mail::panel')
Password: {{ $password }}
@endcomponent

Please change your password right after you login
@component('mail::button', ['url' => route('login')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
