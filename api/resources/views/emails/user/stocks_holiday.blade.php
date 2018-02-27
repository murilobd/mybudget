@component('mail::message')
# Daily Stocks E-mail

Today ({{ $date }}) there weren't trades. Reason: {{ $holiday->description }}.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
