@component('mail::message')
 
Hello {{ $username }}

Your Have LOgged in Into Your Account

@component('mail::button', ['url' => 'www.facebook.com'])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
