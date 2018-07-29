@component('mail::message')
# Introduction
Hi {{ $user->first_name }}

Thank you for choosing to join Andela Kenya Welfare Society.
Activate your account to be able to access your account.
@component('mail::button', ['url' => $url])
Activate Account
@endcomponent

Welcome to the family

Thanks,<br>
{{ config('app.name') }}
@endcomponent
