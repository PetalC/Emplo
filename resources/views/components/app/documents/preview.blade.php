@props( ['document'] )
<div>

    <a href="{{ env( 'APP_ENV' ) === 'production' ? $document->getTemporaryUrl( \Carbon\Carbon::now()->addMinutes( 5 ) ) : $document->getFullUrl() }}" target="_blank" class="text-primary p-4 bg-white border border-gray-200 flex justify-center items-center">
        <x-icon name="heroicon-o-arrow-down-tray" class="w-6 h-6" />
    </a>

{{--    @switch( $document->mime_type )--}}
{{--        @case( 'application/pdf' )--}}
{{--            <iframe src="{{ $document->url }}" class="w-full h-96"></iframe>--}}
{{--            @break--}}
{{--        @case( 'image/jpeg' )--}}
{{--            <img src="{{ $document->url }}" class="w-full h-96" />--}}
{{--            @break--}}
{{--        @case( 'image/png' )--}}
{{--            <img src="{{ $document->url }}" class="w-full h-96" />--}}
{{--            @break--}}
{{--        @default--}}
{{--            <span>Document type not supported</span>--}}
{{--    @endswitch--}}

</div>
