<div class="flex lg:flex-row flex-col justify-between lg:gap-0 gap-20 p-10 rounded-lg bg-gradient-to-r from-[#d6cbc7] to-[#dedede] text-gray-600">
    <div class="lg:w-[300px] lg:h-[300px] w-full rounded-md overflow-hidden">
        <img src="{{ asset('assets/app/anne.png') }}" class="lg:w-fit w-full fit-content" />
    </div>

    <div class="lg:w-1/2 flex lg:flex-col flex-col my-8 justify-between gap-5 lg:gap-0 w-[1/3]">
        <h5 class="text-5xl font-medium">Anne Sullivan</h5>

        <span class="text-2xl">English Teacher</span>

        <p class="text-2xl mr-10">
            I've been working as an English teacher for 3 years now and am looking to continue my journey at another great school in the Greater Sydney area.
        </p>

        <div class="w-[50px] h-[3px] bg-gray-500"></div>
    </div>

    <div class="lg:w-1/4 flex flex-col justify-between w-full mb-8 lg:gap-0 gap-5">
        <div class="lg:flex hidden justify-end">
            <x-badge variant="success"><x-icon name="heroicon-m-check" class="w-4 h-4 mr-2" />Shortlisted</x-badge>
        </div>

        <div class="flex flex-col gap-4">
            <span class="flex items-center"><x-icon name="heroicon-m-check" class="w-4 h-4 mr-2 text-primary" /> Identify Check</span>
            <span class="flex items-center"><x-icon name="heroicon-m-check" class="w-4 h-4 mr-2 text-primary" /> Working with Children Check</span>
            <span class="flex items-center"><x-icon name="heroicon-m-check" class="w-4 h-4 mr-2 text-primary" /> Reference Check</span>
        </div>
        <div class="lg:hidden flex justify-center">
            <x-badge variant="success"><x-icon name="heroicon-m-check" class="w-6 h-6 mr-2" />Shortlisted</x-badge>
        </div>
    </div>
</div>
