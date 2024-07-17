@props([
    'campus_profile'
])
<div>
    <div id="school_map" class="w-full h-[430px]"></div>

    <div class="hidden" id="map_markers">
        <div id="map_marker" class="text-app bg-none rounded flex flex-col gap-0 items-center cursor-pointer">
            <x-icon name="heroicon-s-academic-cap" class="w-6 h-6" />
            <x-icon name="heroicon-s-chevron-double-down" class="w-4 h-4 mt-[-6px] mx-auto" />
        </div>
    </div>


    <script>
        mapboxgl.accessToken = '{{ config('mapbox.access_token') }}';
        const map = new mapboxgl.Map({
            container: 'school_map', // container ID
            center: [{{ $campus_profile->longitude ?? 100 }}, {{ $campus_profile->latitude ?? 100 }}], // starting position [lng, lat]
            zoom: 9 // starting zoom
        });

        const el = document.getElementById('map_marker').cloneNode(true);
        document.getElementById('map_markers').append( el );
        el.id = 'marker_{{ $campus_profile->id }}';

        let marker = new mapboxgl.Marker( {
            'element' : el,
            'anchor': 'bottom'
        } )
            .setLngLat([{{ $campus_profile->longitude ?? 100 }}, {{ $campus_profile->latitude ?? 100 }}])
            .addTo(map);
    </script>

</div>
