@props([
    'campus_profile'
])
<div class="2xl:px-0 px-10 py-16 text-app leading-7 flex flex-col gap-10 max-w-6xl mx-auto">
    <div>
        {!! nl2br( $campus_profile->description ) !!}
    </div>
    @if( $campus_profile->youtube_embed_url )
        <div class="lg:mx-0">
            <iframe class="w-full lg:h-[40rem] h-[30rem]" src="{{ $campus_profile->youtube_embed_url }}">
            </iframe>
        </div>
    @endif
    <div>
        <p class="text-3xl font-light mb-6">Our Employee Value Proposition</p>
        <div>
            {!! nl2br( $campus_profile->proposition ) !!}
        </div>
    </div>

</div>
