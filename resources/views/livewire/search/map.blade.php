<div>
    <div class="transition-all duration-500 px-5">

        {{-- advanced search by location --}}
        <div class="grid xl:grid-cols-12 w-full items-center gap-4 mb-6">
            <x-app.dashboard.location-search wire:model.live.debounce.400ms="user_address_search" class="col-span-8" :user_address_results="$user_address_results" id="location-search" name="location-search" placeholder="Search for a location" />
            <x-buttons.primary :shadow="false" class="col-span-4 py-3.5" x-on:click="showMapUserLocation">Use My Current Location</x-buttons.primary>
        </div>

        {{-- map --}}
        <div id="map" class="w-full h-[500px]" wire:ignore></div>

        <div id="map_markers" class="hidden" wire:ignore>
            <div id="map_marker" class="text-app bg-none rounded flex flex-col gap-0 items-center cursor-pointer">
                <x-icon name="heroicon-s-academic-cap" class="w-6 h-6" />
                <x-icon name="heroicon-s-chevron-double-down" class="w-4 h-4 mt-[-6px] mx-auto" />
            </div>
        </div>

    </div>

</div>

@script
<script>

    mapboxgl.accessToken = '{{ config('mapbox.access_token') }}';

    let center = [134.648438, -25.498819];
    let map;
    const centerDotSize = 50;
    let zoom = 3;
    let existing_markers = Array();

    //
    const createGeoJSONCircle = function(center, radiusInKm, points) {
        if(!points) points = 64;

        const coords = {
            latitude: center[1],
            longitude: center[0]
        };

        const km = radiusInKm;

        let ret = [];
        const distanceX = km/(111.320*Math.cos(coords.latitude*Math.PI/180));
        const distanceY = km/110.574;

        let theta, x, y;
        for(let i=0; i<points; i++) {
            theta = (i/points)*(2*Math.PI);
            x = distanceX*Math.cos(theta);
            y = distanceY*Math.sin(theta);

            ret.push([coords.longitude+x, coords.latitude+y]);
        }
        ret.push(ret[0]);

        return {
            "type": "geojson",
            "data": {
                "type": "FeatureCollection",
                "features": [{
                    "type": "Feature",
                    "geometry": {
                        "type": "Polygon",
                        "coordinates": [ret]
                    }
                }]
            }
        };
    };

    const centerDot = {
        width: centerDotSize,
        height: centerDotSize,
        data: new Uint8Array(centerDotSize * centerDotSize * 4),

        // When the layer is added to the map,
        // get the rendering context for the map canvas.
        onAdd: function () {
            const canvas = document.createElement('canvas');
            canvas.width = this.width;
            canvas.height = this.height;
            this.context = canvas.getContext('2d');
        },

        // Call once before every frame where the icon will be used.
        render: function () {
            const duration = 1000;
            const t = (performance.now() % duration) / duration;
            //
            const radius = (centerDotSize / 2) * 0.3;
            // const outerRadius = (centerDotSize / 2) * 0.7 * t + radius;
            const context = this.context;
            //
            // // Draw the outer circle.
            // context.clearRect(0, 0, this.width, this.height);
            // context.beginPath();
            // context.arc(
            //     this.width / 2,
            //     this.height / 2,
            //     outerRadius,
            //     0,
            //     Math.PI * 2
            // );
            // context.fillStyle = `#4d8c27`;
            // context.fill();

            // Draw the inner circle.
            context.beginPath();
            context.arc(
                this.width / 2,
                this.height / 2,
                radius,
                0,
                Math.PI * 2
            );
            context.fillStyle = '#4d8c27';
            context.strokeStyle = 'white';
            context.lineWidth = 2;
            context.fill();
            context.stroke();

            // Update this image's data with data from the canvas.
            this.data = context.getImageData(
                0,
                0,
                this.width,
                this.height
            ).data;
            //
            // // Continuously repaint the map, resulting
            // // in the smooth animation of the dot.
            // map.triggerRepaint();

            // Return `true` to let the map know that the image was updated.
            return true;
        },

        // draggable: true,
        //
        // onDrag: function() {
        //     console.log('dragging');
        // }
    };

    window.showMapUserLocation = function(){
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                showMapLocation( position.coords.longitude, position.coords.latitude );
            });
        } else {
            console.log('Geolocation is not supported by this browser.');
        }
    }

    window.showMapLocation = function( longitude, latitude ) {
        if( map ){
            map.flyTo( {
                center: [
                    longitude,
                    latitude
                ],
                zoom: 9,
                essential: true
            } );
            $wire.set( 'user_address_results', null )
        }
    }

    let initMap = function(){

        //Init the map object
        map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v12',
            center: [center[0], center[1]],
            zoom: zoom
        });

        // Handle change of map location.
        map.on('moveend', () => {
            $wire.set( 'map_bounds', map.getBounds(), true );
            $wire.set( 'map_center', [map.getCenter().lng, map.getCenter().lat] );
        });

        map.on('load', function () {
            map.addImage('pulsing-dot', centerDot, { pixelRatio: 2 });

            map.addSource('dot-point', {
                'type': 'geojson',
                'data': {
                    'type': 'FeatureCollection',
                    'features': [
                        {
                            'type': 'Feature',
                            'geometry': {
                                'type': 'Point',
                                'coordinates': [center[0], center[1]] // icon position [lng, lat]
                            }
                        }
                    ]
                }
            });

            map.addLayer({
                'id': 'layer-with-pulsing-dot',
                'type': 'symbol',
                'source': 'dot-point',
                'layout': {
                    'icon-image': 'pulsing-dot'
                }
            });

            $wire.$watch('map_center', function(center) {

                map.getSource('dot-point').setData({
                    'type': 'FeatureCollection',
                    'features': [
                        {
                            'type': 'Feature',
                            'geometry': {
                                'type': 'Point',
                                'coordinates': [center[0], center[1]] // icon position [lng, lat]
                            }
                        }
                    ]
                });

                // If the center has been set not by a map moving we can set the center. This is driven by the user address search.
                const {lng, lat} = map.getCenter();

                if( center[0] !== lng || center[1] !== lat ){
                    showMapLocation( center[0], center[1] );
                }

            });

        } );

        const addMarker = function( longitude, latitude, id ) {

            const el = document.getElementById('map_marker').cloneNode(true);
            document.getElementById('map_markers').append( el );
            el.id = 'marker_' + id;

            el.addEventListener('click', function() {
                let jobElem = document.getElementById('result_' + id);
                // console.log(jobElem.offsetTop - 150);
                smoothScrollTo( jobElem.offsetTop - 150, 1000 );
                // window.focus();
                // window.scrollTo({ top: jobElem.offsetTop - 150, left:0, behavior: 'smooth' })
                jobElem.classList.add('!border-green-500');
                setTimeout( function(){
                    jobElem.classList.remove('!border-green-500');
                }, 1500 );
            } );

            let marker = new mapboxgl.Marker( {
                'element' : el,
                'anchor': 'bottom'
            } )
                // .setPopup(new mapboxgl.Popup().setHTML("<h1>Hello World!</h1>"))
                .setLngLat([longitude, latitude])
                .addTo(map)

            existing_markers.push( marker );

        }

        $wire.markers.forEach( function( marker ) {
            addMarker( marker.longitude, marker.latitude, marker.id );
        } );

        $wire.$watch('markers', function( markers ) {

            if (existing_markers.length > 0){
                for ( _marker of existing_markers ) {
                    _marker.remove();
                }
            }

            for( i = 0; i < markers.length ; i++ ) {
                addMarker( markers[i].longitude, markers[i].latitude, markers[i].id );
            }

        });

    };

    initMap();

    showMapUserLocation();

</script>
@endscript
