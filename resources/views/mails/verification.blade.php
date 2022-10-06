@php
/** @var \App\Models\User $user */
@endphp

@component('mail::message')
# Email Verification

Hi {{ $user->name }},
Please verify your account by clicking on the link below.

@component('mail::button', ['url' => route('verification.verify', ['id' => $user->getId(), 'hash' => $user->getVerificationToken()])])
	Click Here
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
