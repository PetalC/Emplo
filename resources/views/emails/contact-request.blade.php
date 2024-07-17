<x-mail::message>
## A Contact Request has been received. Here are the details:

<x-email.check-list>
<x-email.check-list-item>Name: {{ $contact['name'] }}</x-email.check-list-item>
<x-email.check-list-item>Email: {{ $contact['email'] }}</x-email.check-list-item>
<x-email.check-list-item>Phone: {{ $contact['phone'] }}</x-email.check-list-item>
<x-email.check-list-item>School: {{ $contact['school'] }}</x-email.check-list-item>
</x-email.check-list>

<x-mail::panel>
{{ $contact['message'] }}
</x-mail::panel>
</x-mail::message>
