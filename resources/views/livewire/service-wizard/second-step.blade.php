<div class="text-app flex items-center flex-col gap-10" x-data="{ s_step:'first' }">
    <div x-show="s_step=='first'">
        <p class="text-3xl">What is your school/s type?</p>
        <div class="flex flex-col items-center gap-5 mt-10">
            <ul class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <x-app.service-wizard.select-item id="independent" name="school-type" label="Independent" />
                <x-app.service-wizard.select-item id="catholic" name="school-type" label="Catholic" />
                <x-app.service-wizard.select-item id="christian" name="school-type" label="Christian" />
                <x-app.service-wizard.select-item id="government" name="school-type" label="Government" />
                <x-app.service-wizard.select-item id="international" name="school-type" label="International" />
            </ul>
            
            <x-button.primary x-on:click="s_step='second'">Next</x-button.primary>
        </div>
    </div>

    <div x-show="s_step=='second'">
        <p class="text-3xl">Do you manage 4 or more schools?</p>
        <div class="flex flex-col items-center gap-5 mt-10">
            <ul class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <x-app.service-wizard.select-item id="school_count_yes" name="school-count" label="Yes" />
                <x-app.service-wizard.select-item id="school_count_no" name="school-count" label="No" />
            </ul>
            <x-button.primary wire:click="updateParentValue(3)">Next</x-button.primary>
        </div>
    </div>


</div>