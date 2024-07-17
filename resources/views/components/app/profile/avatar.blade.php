@props([
    'user' => \Illuminate\Support\Facades\Auth::user(),
    'img_class' => '',
    'url' => false,
])


{{--Please stop editing this file. Any classes needed can be passed in, in the class attribute. If you need to change the image size, please pass in a class for the image in the img_class attribute.--}}
<div {{ $attributes->merge( [ 'class' => 'bg-white px-10 py-10 border rounded-lg overflow-hidden' ] ) }}>

    @if( $user )

        @if( $url )
            <a class="flex justify-center" href="{{ $url }}">
        @endif

        @if( $user->profile?->hasMedia( \App\Enums\MediaCollections::USER_PROFILE->value ) )
            @if( env( 'APP_ENV' ) === 'local' )
                <img class="{{ $img_class ?? '' }} block h-auto max-w-full" src="{{ $user->profile->getFirstMedia( \App\Enums\MediaCollections::USER_PROFILE->value )->getUrl() }}" />
            @else
                <img class="{{ $img_class ?? '' }} block h-auto max-w-full" src="{{ $user->profile->getFirstMedia( \App\Enums\MediaCollections::USER_PROFILE->value )->getTemporaryUrl( \Carbon\Carbon::now()->addMinutes( 5 ) ) }}" />
            @endif
        @else
            <x-icon name="heroicon-s-user" class="h-auto max-w-full text-gray-300 w-20 h-20" />
        @endif

        @if( $url )
            </a>
        @endif

    @endif

{{--    <div class="relative pt-[100%]">--}}
{{--        <div class="absolute inset-0">--}}
{{--            <div class="w-full h-full rounded-lg overflow-hidden bg-white border border-gray-300 flex items-center justify-center">--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
