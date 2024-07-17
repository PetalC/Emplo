<x-mail::message>

{{ $message }}

<x-mail::button :url="$nominate_reference_url">
Button Text Link to nominate references form for candidate
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
