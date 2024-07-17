<x-mail::message>
{{ $message }}
<x-mail::button url="https://login.trb.wa.gov.au/Register-of-Teachers">WA Register</x-mail::button>
Thank You,<br>
{{ config('app.name') }}
</x-mail::message>
