@props([
    'icon',
    'disabled' => false
])
<div class="mt-10 lg:px-10 lg:py-5 lg:border rounded-lg border-gray-500 flex items-center lg:flex-row flex-col lg:gap-0 gap-5">
    <div class="flex lg:flex-row flex-col items-center lg:gap-0 gap-5">
        <x-icon name="heroicon-c-calendar" class="text-blue-700 w-12 h-12" />
        <div class="text-app ml-5">
            <div class="flex gap-1 items-center lg:justify-start justify-center">
                <p class="lg:text-xl text-3xl">Jane Manor</p>
                <x-icon name="heroicon-o-information-circle" class="w-5 h-5"/>
            </div>
            <p class="lg:text-base text-2xl text-nowrap">Director of People and Culture</p>
        </div>
        <p class="lg:text-2xl text-3xl ml-5 text-theme_blue font-bold text-nowrap">Tomorrow at 3pm</p>
    </div>

    <div class="w-[1px] border-l -my-5 ml-20 border-gray-500 h-[100px] lg:block hidden"></div>

    <div class="flex lg:flex-grow w-full lg:flex-row flex-col lg:justify-between items-center lg:ml-10 lg:gap-0 gap-10">
        <div class="flex gap-2 flex-wrap lg:justify-left justify-start">
            <x-app.job-center.candidate-name-card label="Liam Evans"/>
            <x-app.job-center.candidate-name-card label="Trent Iron"/>
            <x-app.job-center.candidate-name-card label="Suz Ravers"/>
        </div>
        <div class="w-full lg:w-fit">
            <x-button.outline class="lg:w-fit w-full"> Manage Candidate </x-button.outline>
        </div>
    </div>
</div>
