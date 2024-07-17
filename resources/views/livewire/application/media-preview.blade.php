
<div class="w-full">
    <p class="text-4xl text-gray-500">Media List </p>
    <div class="mt-10 flex flex-col gap-5">
        <div class="flex flex-col lg:items-center lg:gap-5 gap-5 text-2xl text-gray-500 w-fulllg:h-16">
            <div class="flex lg:flex-row flex-col w-full flex-wrap lg:gap-0 gap-5 lg:my-0 mx-10 lg:mx-0">
                @foreach ($mediaItems as $mediaItem)
                    <div class="w-1/3 flex items-center gap-2 lg:py-3 lg:border-b-2 lg:border-gray-300">
                        <p class="text-xl">{{ $loop->iteration }}.</p>
                        @if ($mediaItem['type'] === 'image')
                            <img src="{{ asset($mediaItem['path']) }}" class="rounded-full w-12 h-12 object-cover" />
                        @elseif ($mediaItem['type'] === 'pdf')
                            <x-icons.pdf class="w-10 h-10"/>
                        @elseif ($mediaItem['type'] === 'doc')
                            <x-icons.doc class="w-10 h-10"/>
                        @else
                            <x-icon name="heroicon-s-no-symbol" class="w-10 h-10 text-[#000]" />
                        @endif
                        <p class="p-0 m-0 text-gray-800 text-lg">{{ $mediaItem['filename'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>