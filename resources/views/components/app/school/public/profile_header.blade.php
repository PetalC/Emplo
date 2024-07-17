@props([
    'campus_profile',
    'with_header' => true
])
<div class="py-10 px-10 xl:px-0">
    @if( $with_header)
        <div class="max-w-8xl py-6 mx-10 2xl:mx-auto flex lg:flex-row flex-col items-center gap-5 text-center">
            <x-app.school.avatar :campus="$campus_profile" />
            <p class="text-3xl text-gray-500">{!! \App\Helpers\Strings::wrapLastWord( $campus_profile->name ) !!}</p>
        </div>
    @endif
    <div class="max-w-7xl mx-auto mt-10">
        <div class="shadow-xl relative z-20">
            @if( $campus_profile->banner_image )
                <img src="{{ $campus_profile->banner_image }}" class="w-full"/>
            @else
{{--                <img src="{{ asset('assets/app/school-6-bg.png') }}" class="w-full"/>--}}
            @endif
        </div>
    </div>
    {{--  bg-gradient-to-r from-school_primary 2xl:to-white 2xl:via-school_primary 2xl:to-90% 2xl:via-90%--}}
        @if( $campus_profile->banner_quote )
   `     <div class="bg-school_primary_alt pt-16 pb-12 -mt-6">
            <div class="max-w-8xl mx-auto flex px-0 lg:px-10">
                <p class="text-9xl text-school_primary">"</p>
                <p class="text-4xl ml-3 pr-[150px] text-school_primary font-light leading-relaxed">{{ $campus_profile->quote }}</p>
            </div>
        </div>`
        @endif
</div>
