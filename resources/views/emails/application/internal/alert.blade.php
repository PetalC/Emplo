<x-mail::message>
# {{ $subject }}

{{ $message }}

{{--@include('emails.application.internal.partials.applicant-details');--}}
{{--{{ $message }}--}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
