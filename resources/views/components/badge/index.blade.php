@props([
    'variant' => 'info'
])

@switch($variant)
    @case('error')
        @php ($colors = 'bg-red-100 text-red-500')
        @break
    @case('success')
        @php ($colors = 'bg-green-50 text-primary')
        @break
    @case('warning')
        @php ($colors = 'bg-amber-100 text-amber-500')
        @break
    @case('info')
        @php ($colors = 'bg-sky-100 text-sky-500')
        @break
@endswitch

<span {{ $attributes->merge(['class' => 'inline-flex w-fit items-center px-2.5 py-1.5 rounded-md text-xs '.$colors]) }}>
    {{$slot}}
</span>
