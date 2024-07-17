@props([
    'campus'
])
<div class="flex flex-col rounded-lg overflow-hidden border shadow-md bg-white snap-start school-card min-w-[286px]" id="result_{{ $campus->id }}">
    <div class="px-8 py-8 bg-cover bg-center" style="background-image: url( {{ $campus->banner_image }})">
        <x-app.school.avatar url="{{ route( 'schools.view', $campus ) }}" img_class="" class="w-[80px] mx-auto" :campus="$campus" />
    </div>

    <div class="flex flex-col px-8 py-5 text-center">
        <h5 class="text-xl line-clamp-2"><a href="{{ route( 'schools.view', $campus ) }}">{{ $campus->primary_profile->name }}</a></h5>
        <span class="line-clamp-2 mt-6">{{ $campus->primary_profile->short_address }}</span>
        <div class="flex flex-col items-center mt-8 gap-4 mb-4 mx-4">
            <x-buttons.secondary elem_type="link" href="{{ route( 'schools.view', $campus ) }}">More Details</x-buttons.secondary>
            <livewire:components.campus.follow-campus-button :key="'follow_campus_btn' . $campus->id" button_class="!text-md !px-3 !py-2 mt-2 whitespace-nowrap" :shadow="true" button_variant="primary" alt_button_variant="secondary" :campus="$campus" />
        </div>
    </div>
</div>
