@component('mail::message')
# Introduction
Hi {{ $user->first_name }}

Thank you for choosing to join Andela Kenya Welfare Society. We are excited to have you on our platform.
Before we proceed we will need you to activate your account in order access your account.
@component('mail::button', ['url' => route('accounts.activate', $user->activate->token)])
Activate your Account
@endcomponent

Welcome to the family

Thanks,<br>
{{ config('app.name') }}
@endcomponent
