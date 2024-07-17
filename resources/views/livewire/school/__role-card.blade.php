<div class="lg:p-5 rounded-lg lg:border border-gray-500 flex lg:flex-row flex-col items-center lg:gap-0 gap-10">
    <input type="checkbox" class="w-8 h-8 rounded-lg">
    <div class="lg:ml-10 lg:w-1/3 gap-2 flex flex-col">
        <p class="text-3xl text-app lg:text-left text-center">Director of People and Culture</p>
        <p class="text-primary text-3xl lg:text-left text-center">$143,000</p>
    </div>
    <div class="lg:ml-5 lg:flex-grow w-full">
        <div class="flex lg:flex-row flex-col items-center gap-5 justify-between">
            <div class="flex lg:flex-row flex-col lg:w-6/12 w-full items-center lg:gap-0 gap-5">
                <x-app.job-center.progress-bar val="50" class="lg:w-4/5 w-full"/> 
                <p class="text-app ml-5">Advertised</p>
            </div>
            <x-button.outline class="lg:w-fit w-full lg:block hidden">View Job Ad</x-button.outline>
            @if(!$this->closed)
                <x-button.primary class="lg:w-fit w-full lg:block hidden">Manage Candidates</x-button.primary>
            @endif
        </div>
        <div class="text-app flex lg:flex-row flex-col items-center lg:gap-20 gap-5 mt-5">
            <div class="flex">
                <div class="flex">
                    <x-icon name="heroicon-o-clock" class="w-6 h-6 text-gray-300" />
                    <span class="ml-2">3 days ago,</span>
                </div>
                {{-- <x-app.job.posted-date :job=$job /> --}}
                <span class="ml-2">Commencing March 2024</span>
            </div>
            @if(!$this->closed)
                <div class="flex gap-2 text-app">
                    <x-icon name="heroicon-o-user" class="w-5 h-5"/>
                    <p><span class="text-primary font-bold">8</span> shortlisted, </p>
                    <p><span>45</span> Applied</p>
                </div>
                <div class="flex gap-2 text-app">
                    <x-icons.speech />
                    <p><span class="text-primary font-bold">3</span> Upcoming interviews</p>
                </div>
            @endif

            <x-button.outline class="lg:w-fit w-full lg:hidden block">View Job Ad</x-button.outline>
            @if(!$this->closed)
                <x-button.primary class="lg:w-fit w-full lg:hidden block">Manage Candidates</x-button.primary>
            @endif
        </div>
    </div>
</div>