@if ($job->start_date !== null)
    @php
    $offers_options = [];
    if ($job->offers_relocation) {
        $offers_options[] = 'Relocation';
    }
    if ($job->offers_housing) {
        $offers_options[] = 'Housing';
    }
    $offers_text = !empty($offers_options) ? 'Offers ' . implode(' and ', $offers_options) : 'Does not offer Relocation or Housing';
    @endphp
    <span class="mt-4 text-gray-500">Commencing {{ Carbon\Carbon::parse($job->start_date)->format('F Y') }}, {{ $offers_text }}</span>
@endif
