<div>

    <div class="flex lg:flex-row flex-col mx-6 lg:gap-0 gap-5 items-center justify-between mb-10 max-w-full overflow-hidden">
        <x-text.heading variant="h1" class="text-center">
            Search <span class="text-primary">by school</span>
        </x-text.heading>
{{--        Livewire not playing nice with swiping libraries--}}
{{--        <div>--}}
{{--            <x-input.text--}}
{{--                wire:model.live.debounce.400ms="search_value"--}}
{{--                id="search-school"--}}
{{--                name="search-school"--}}
{{--                type="text"--}}
{{--                placeholder="Search by school, postcode, city or school type"--}}
{{--                rightIcon="heroicon-o-magnifying-glass"--}}
{{--                class="md:min-w-[400px]"--}}
{{--            />--}}
{{--        </div>--}}
    </div>

    <div id="splide_wrapper" class="splide" role="group">
        <div class="splide__track">
            <ul class="splide__list">
                @foreach( $campuses as $campus )
                    <li class="splide__slide">
                        <x-search.school-card :campus="$campus" />
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="flex flex-col items-center p-5">
        <x-text.heading variant="h1" class="text-center mr-[80px] p-5">
            Can't find the school <span class="text-primary">you're looking for</span>?
        </x-text.heading>

        <x-buttons.primary elem_type="link" class="content-center" href="{{ route( 'search', ['schools' => true] ) }}" size="lg">Search now</x-buttons.primary>
    </div>


</div>

@script
<script>
    const initSlider = function(){

        let slider = null;
        slider = new window.Splide( document.getElementById('splide_wrapper'), {
            type: 'loop',
            gap: '2rem',
            perPage: 4,
            perMove: 1,
            padding: '70px',
            pagination: false,
            breakpoints: {
                640: {
                    perPage: 1,
                },
                1280: {
                    perPage: 2,
                },
            }
        } );
        slider.mount();

    };

    // Livewire not playing nicely with swiper libraries
    // document.addEventListener('livewire:update', function () {
    //     if (slider) {
    //         slider.destroy();
    //         slider = null;
    //     }
    //     initSlider();
    // });

    document.addEventListener('livewire:initialized', () => {
        initSlider();
    });

</script>
@endscript
