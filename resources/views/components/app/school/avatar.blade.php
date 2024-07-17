@props([
    'school' => false,
    'campus' => false,
    'class',
    'img_class',
    'url' => false
])

@php
    $object = $school ?: ( ( $campus && $campus->primary_profile ) ? $campus->primary_profile : false );
@endphp

{{--Please stop editing this file. Any classes needed can be passed in, in the class attribute. If you need to change the image size, please pass in a class for the image in the img_class attribute.--}}
<div class="bg-white px-5 py-5 border rounded-lg flex justify-center {{ $class ?? '' }}">
    @if( $url )
        <a href="{{ $url }}">
    @endif

        @if( $object && $object->hasMedia( \App\Enums\MediaCollections::CAMPUS_LOGO->value ) )
            @if( env( 'APP_ENV' ) === 'local' )
                <img class="{{ $img_class ?? '' }}" src="{{ $object->getFirstMedia( \App\Enums\MediaCollections::CAMPUS_LOGO->value )->getUrl() }}" />
            @else
                <img class="{{ $img_class ?? '' }}" src="{{ $object->getFirstMedia( \App\Enums\MediaCollections::CAMPUS_LOGO->value )->getTemporaryUrl( \Carbon\Carbon::now()->addMinutes( 5 ) ) }}" />
            @endif
        @else
            <x-icon name="heroicon-o-building-library" class="text-gray-300 w-20 max-w-full h-auto" />
        @endif

    @if( $url )
        </a>
    @endif
</div>
