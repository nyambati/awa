@component('mail::message')
# Introduction

Welcome to Andela Welfare Society portal, your account has been Successfully activated.

@component('mail::button', ['url' => ''])
Login to Awa
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
