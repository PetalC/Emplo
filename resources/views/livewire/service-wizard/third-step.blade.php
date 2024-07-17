<div class="text-app flex items-center flex-col gap-10">
    <p class="text-3xl">What aspects of recruitment interest you?</p>
    <p class="text-2xl">(Choose as many as you like ...)</p>
    <div class="flex flex-col items-center gap-5 max-h-[20rem] overflow-auto">
        <ul class="w-fit pr-5 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <x-app.service-wizard.select-item id="select-all" header="Select All" label="It all matters to me." name="recruitment-aspect" variant="checkbox" />
            <x-app.service-wizard.select-item id="free-advertising" header="Free Advertising" label="Who doesn't like something that's free?" name="recruitment-aspect" variant="checkbox" />
            <x-app.service-wizard.select-item id="borader-advertising-reach" header="Broader Advertising Reach" label="Go places no job has been before." name="recruitment-aspect" variant="checkbox" />
            <x-app.service-wizard.select-item id="candidate-engagement" header="Candidate Engagement" label="A positive process makes for positive outcomes." name="recruitment-aspect" variant="checkbox" />
            <x-app.service-wizard.select-item id="sift-shortlist-select" header="Sifting, Shortlisting and Selecting" label="Our expectations are high." name="recruitment-aspect" variant="checkbox" />
            <x-app.service-wizard.select-item id="compliance-safeguard-childprotection" header="Compilance, Safeguarding & Child Protection" label="It's non-negotiable." name="recruitment-aspect" variant="checkbox" />
            <x-app.service-wizard.select-item id="collaborative-decision" header="Collaborative Decision making" label="The best type of work is teamwork." name="recruitment-aspect" variant="checkbox" />
            <x-app.service-wizard.select-item id="proactivity" header="Proactivity" label="I want to stay ahead of the game." name="recruitment-aspect" variant="checkbox" />
            <x-app.service-wizard.select-item id="employment-branding" header="Employment Branding" label="If people only knew how good it is to work here." name="recruitment-aspect" variant="checkbox" />
            <x-app.service-wizard.select-item id="Onboarding" header="Onboarding" label="I like everything in one place." name="recruitment-aspect" variant="checkbox" />
            <x-app.service-wizard.select-item id="Reporting and analytics" header="Reporting and analytics" label="Who doesn't need data?" name="recruitment-aspect" variant="checkbox" />
        </ul>
    </div>
    <x-button.primary wire:click="updateParentValue(4)">Next</x-button.primary>
</div>
