<div class="flex lg:flex-row flex-col justify-between lg:gap-20 gap-5 p-10 rounded-lg bg-gradient-to-r from-stone-300 to-gray-300 text-gray-600 mx-5">
    <div class="lg:w-1/4 w-full rounded-md overflow-hidden">
        <img src="{{ asset('assets/app/anne.png') }}" class="lg:w-[300px] lg:h-[300px] w-full" />
    </div>

    <div class="flex flex-col my-2 justify-between lg:w-1/2 w-full lg:gap-0 gap-5">
        <h5 class="text-3xl sm:text-5xl font-medium">Anne Sullivan</h5>
        <span class="text-xl">English Teacher</span>
        <p class="text-base mr-0 sm:mr-10">
            I've been working as an English teacher for 3 years now and am looking to continue my journey at another great school in the Greater Sydney area.
        </p>
        <div class="w-[50px] h-[3px] bg-gray-500"></div>

        <x-button.primary size="lg" class="!bg-orange !drop-shadow-orange lg:flex hidden w-fit text-2xl"> <x-icon name="heroicon-m-check" class="w-5 h-5 mr-2" /> Hire</x-button.primary>
    </div>

    <div class="flex lg:flex-col flex-col-reverse justify-between lg:w-1/4 w-full mb-08 lg:gap-0 gap-5">
        <x-button.primary size="lg" class="!bg-orange !drop-shadow-orange lg:hidden flex text-2x" fullWidth> <x-icon name="heroicon-m-check" class="w-5 h-5 mr-2" /> Hire</x-button.primary>
        <div class="flex lg:justify-end lg:w-fit w-full">
            <x-badge variant="success" class="mx-auto"><x-icon name="heroicon-m-check" class="w-4 h-4 mr-2" />Shortlisted</x-badge>
        </div>
        <div class="flex flex-col gap-4">
            <span class="flex items-center"><x-icon name="heroicon-m-check" class="w-4 h-4 mr-2 text-primary" /> Identify Check</span>
            <span class="flex items-center"><x-icon name="heroicon-m-check" class="w-4 h-4 mr-2 text-primary" /> Working with Children Check</span>
            <span class="flex items-center"><x-icon name="heroicon-m-check" class="w-4 h-4 mr-2 text-primary" /> Reference Check</span>
            <span class="flex items-center"><x-icon name="heroicon-m-check" class="w-4 h-4 mr-2 text-primary" /> Criminal Clearance Check</span>
            <span class="flex items-center"><x-icon name="heroicon-m-check" class="w-4 h-4 mr-2 text-primary" /> Character Check</span>
        </div>
    </div>
</div>
