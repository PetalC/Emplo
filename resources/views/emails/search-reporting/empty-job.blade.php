<x-mail::message>
## Job Search resulted in no results. Here are the filters:

<x-email.check-list>
@foreach($taxonomy_filters as $filterType => $filterValue)
<x-email.check-list-item>{{ $filterType }}: {{ join(', ', $filterValue) }}</x-email.check-list-item>
@endforeach
</x-email.check-list>
</x-mail::message>
