@php use App\Enums\JobBoardTypes;use App\Enums\JobType;use App\Enums\SalaryTypes;use App\Models\Campus;use App\Models\PositionType;use App\Models\Subject; @endphp
<div class="px-20 pb-14 max-w-8xl mx-auto" x-data="{ submitted: @entangle( 'form_submitted' ).live, has_errors : @entangle( 'has_errors' ), display_share: @entangle( 'display_share' ) }">

    <x-app.common.page_header>
        <x-slot name="column_left">
            <div class="flex flex-col gap-4 items-center">
                <x-app.school.avatar :campus="$job->campus" class="max-w-56"/>
                <x-buttons.secondary elem_type="link" href="{{ route( 'school.jobcenter.index' ) }}" class="w-full max-w-56 mb-4 mt-6 flex justify-center py-3 !font-light !text-md">Return to JobCenter</x-buttons.secondary>
                @switch( $job->status )
                    @case( \App\Enums\JobStatus::DRAFT )
                        <x-buttons.primary :shadow="false" wire:click="save_open" class="w-56">Publish this job</x-buttons.primary>
                        @break
                    @case( \App\Enums\JobStatus::OPEN )
                        <x-buttons.danger :shadow="false" wire:click="save_closed" class="w-56">Close Job</x-buttons.danger>
                        @break
                    @default
                @endswitch
                {{--                <x-buttons.secondary wire:click="save_draft" class="" fullWidth>Save as draft</x-buttons.secondary>--}}
            </div>
        </x-slot>

        <x-text.heading variant="h1" class="mb-4 text-app text-center">{{ $job->school->name }}</x-text.heading>

        <x-text.heading variant="h5" class="my-0 mb-20 text-app text-center w-full">
            {{ $job->title }}
        </x-text.heading>

    </x-app.common.page_header>

    <div class="flex flex-col gap-14 lg:px-64">

        <x-input.outline id="job_title" wire:model.live.debounce.1000="fields.title" name="job_title" label="Job Title" fontSize="text-2xl" placeholder="Job Title"></x-input.outline>

        <div class="grid grid-cols-2 gap-5">
            <x-input.select label="Campus" wire:model.live="fields.campus_id" :options="$available_campuses" placeholder="Choose option"></x-input.select>
            <x-input.select label="Position type" wire:model.live="fields.position_type_id" :options="PositionType::all()->pluck( 'name', 'id' )->toArray()" placeholder="Choose option"></x-input.select>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <x-input.select wire:model.live="fields.job_type" :associative="false" :options="[JobType::FULLTIME->value, JobType::PARTTIME->value]" placeholder="Choose option"></x-input.select>
            <x-input.select wire:model.live="fields.job_length_id" :options="\App\Models\JobLength::all()->pluck( 'name', 'id' )->toArray()" placeholder="Choose option"></x-input.select>
        </div>

        <x-input.select wire:model.live="fields.vacancy_reason" label="Reason for Vacancy <span class='font-normal'>(this will not be advertised and is for your analytics dashboard)</span>" :associative="false" :options="\App\Enums\VacancyReasons::cases()" placeholder="Choose option"></x-input.select>

        <div class="flex gap-5 text-app">
            <p class="font-bold"> Salary Range</p>
            <x-input.radiobox :value="SalaryTypes::SALARY" id="salary" wire:model.live="fields.salary_type" name="salary_type" label="Salary"></x-input.radiobox>
            <x-input.radiobox :value="SalaryTypes::DAILY" id="salary_daily" wire:model.live="fields.salary_type" name="salary_type" label="Daily"></x-input.radiobox>
            <x-input.radiobox :value="SalaryTypes::HOURLY" id="salary_hourly" wire:model.live="fields.salary_type" name="salary_type" label="Hourly"></x-input.radiobox>
        </div>

        <div class="grid grid-cols-2 gap-5 -mt-10 text-primary text-lg">
            <x-input.outline id="min_salary" class="text-primary text-xl" wire:model.live.debounce.500="fields.salary_min"></x-input.outline>
            <x-input.outline id="max_salary" class="text-primary text-xl" wire:model.live.debounce.500="fields.salary_max"></x-input.outline>
        </div>

        <div>
            <livewire:forms.multi-select label="Specialisation Subjects" wire:model.live="fields.subjects" class="w-full" :error_message="$errors->first( 'fields.subjects' )" model="{{ Subject::class }}" :with_search="true" :options="Subject::take( 10 )->get()->pluck( 'name', 'id' )->toArray()"/>
        </div>

        <div class="grid grid-cols-2 gap-5">
            <x-input.datepicker id="fields.start_date" wire:model.live="fields.start_date" name="start_date" label="Start date" placeholder="Start date"></x-input.datepicker>
            {{--            <x-input.select id="fields.start_date" wire:model="" name="start_date" label="Start date" :options="['Today', 'Tomorrow', 'Whenever' ]" placeholder="Choose option"></x-input.select>--}}
            <x-input.select id="fields.licensing_authority" wire:model.live="fields.licencing_authority" name="licensing_authority" label="Licensing authority" :associative="false" :options="\App\Enums\LicencingAuthorityTypes::cases()" placeholder="Choose option"></x-input.select>
        </div>

        <x-input.textarea id="job_selling_points" wire:model.live.debounce.200ms="fields.selling_points" name="selling_points" label="3 Selling Points" rows="12" placeholder="Please enter 3 selling points for this position.." characterLimit="3000"></x-input.textarea>

        <x-input.textarea id="job_statement" wire:model.live.debounce.200ms="fields.description" name="job_statement" label="Statement" rows="12" placeholder="Write a brief statement selling the job role here." characterLimit="1000"></x-input.textarea>

        <div>
            <livewire:forms.richtextarea id="job_description" wire:model.live.debounce.200ms="fields.responsibilities" label="Description" placeholder="Write or paste your full job description here"></livewire:forms.richtextarea>
        </div>

        <x-input.select label="Applicant routing preference" wire:model.live="fields.routing_preference" :associative="false" :options="\App\Enums\ApplicationRoutingPreferenceTypes::cases()" placeholder="Choose option"></x-input.select>

        @if( $fields['routing_preference'] === 'External Application' )
            <x-input.outline id="external_application_url" wire:model.live="fields.external_application_url" label="External Application URL" placeholder="External Application URL"></x-input.outline>
        @endif

        <div class="flex flex-col gap-5 text-app">

            <p class="font-bold">Upload documents required to complete</p>

            <div>
                <x-input.upload class="border-none" label="Supporting Documents" id="upload_file" accept="*" wire:model.live="uploadFile">
                    <x-button.outline>Upload documents</x-button.outline>
                </x-input.upload>
            </div>

{{--            This will be replaced when we have a standard upload list component--}}
            @if( ! empty( $supporting_documents ) )
                <div class="mb-20 bg-gray-100 border-y border-y-gray-300 py-5 px-5">
                    @foreach($supporting_documents as $document)
                        <div class="flex gap-6 items-center py-4">
                            <x-icon name="heroicon-o-document" class="w-5 h-5 text-primary"/>
                            <p><a class="underline" href="{{ $document->getUrl() }}" download>{{ $document->name  }}</a></p>
                            <x-button.outline
                                class="bg-red-200 rounded flex items-center justify-center text-gray-800 cursor-pointer mx-4 px-4 py-2"
                                wire:click="removeDocument({{ $document->id }})">
                                <x-icon name="heroicon-o-trash" class="w-4 h-4"/>
                            </x-button.outline>
                        </div>

                    @endforeach
                </div>
            @endif

            <x-input.checkbox id="included_relocation" wire:model.live="fields.offers_relocation" name="included_relocation" label="Does this job include relocation?"/>
            <x-input.checkbox id="included_housing" wire:model.live="fields.offers_housing" name="included_housing" label="Does this job include housing?"/>
        </div>

    </div>

    <hr class="my-20"/>

    {{--         Auto-post to job boards--}}
    <div class="flex lg:pl-64 lg:-mr-20 lg:justify-between lg:flex-row flex-col-reverse text-app">
        <div class="w-full">
            <x-text.heading variant="h5" class="my-0 mb-20 text-gray-500 w-full">
                Auto-post to job boards
            </x-text.heading>

            @if( $errors->has( 'fields.job_boards' ) )
                <div class="bg-red-50 p-6 text-app text-lg font-light -mt-14 mb-6">
                    Please select at least one job board to post to.
                </div>
            @endif

            <div class="w-full" x-data="{ showDetail:true }">
                <div class="flex justify-between items-center cursor-pointer" x-on:click="showDetail=!showDetail">
                    <p class="font-bold">Complete School Branding</p>
                    <x-icon x-show="showDetail" name="heroicon-o-chevron-up" class="w-4 h-4"/>
                    <x-icon x-show="!showDetail" name="heroicon-o-chevron-down" class="w-4 h-4"/>
                </div>
                <div x-show="showDetail">
                    <p class="mt-10">Select any of the below job boards to advertise with full school branding. Configure any job board that requires your own account to auto post. Job boards marked free are already set up to be fully branded for you school thanks to our partnerships. Job boards listing Credits are also set up. Save time and pay less than you would on the open market. Receive a monthly advertising account and a single tax invoice, simplifying your accounts payable and more.</p>
                    <div class="mt-20 grid grid-cols-2 gap-y-5">
                        <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::COMPLETE_EMPLOYO->value" id="csb_employo" icon="employ">
                            <p>Employo <span class="font-bold">Free</span></p>
                        </x-app.job-center.job-board-item>
                        <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::COMPLETE_SEEK->value" id="csb_seek" icon="seek">
                            <div>
                                <p>Seek <!-- <span class="font-bold">(Account 123456)</span>--> </p>
                                {{--                                    <p class="text-primary underline"> Configured </p>--}}
                            </div>
                        </x-app.job-center.job-board-item>
                        <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::COMPLETE_EDUCATIONAL_HQ->value" id="csb_edhq" icon="edhq">
                            <p>EducationalHQ <span class="font-bold">Free</span></p>
                        </x-app.job-center.job-board-item>
                        <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::COMPLETE_CAREERONE->value" disabled id="csb_careerone" icon="careerone">
                            <div>
                                <p>Careerone</p>
                                {{--                                    <p class="text-primary underline"> Configured </p>--}}
                            </div>
                        </x-app.job-center.job-board-item>
                        <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::COMPLETE_SPORTSPEOPLE->value" disabled id="csb_sports_people" icon="sports-people">
                            <div>
                                <p>SportsPeople</p>
                                {{--                                    <p class="text-primary underline"> Configured </p>--}}
                            </div>
                        </x-app.job-center.job-board-item>
                        <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::COMPLETE_CHRISTIAN_JOBS->value" disabled id="csb_christian" icon="christian-job">
                            <div>
                                <p>Christian Jobs</p>
                                {{--                                    <p class="text-primary underline"> Configured </p>--}}
                            </div>
                        </x-app.job-center.job-board-item>
                        <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::COMPLETE_ETHICAL_JOB_JOARD->value" disabled id="csb_ethical_job" icon="ethical-job-board">
                            <div>
                                <p>Ethical Job Board</p>
                                {{--                                    <p class="text-primary underline"> Configured </p>--}}
                            </div>
                        </x-app.job-center.job-board-item>
                        <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::COMPLETE_INDEED->value" id="csb_indeed" icon="indeed">
                            <div>
                                <p>indeed</p>
                                {{--                                    <p class="text-primary underline"> Configured </p>--}}
                            </div>
                        </x-app.job-center.job-board-item>
                        <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::COMPLETE_STATE_WIDE->value" id="csb_state_wide" icon="state-wide">
                            <p>State Wide</p>
                        </x-app.job-center.job-board-item>
                        <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::COMPLETE_NATION_WIDE->value" id="csb_nation_wide" icon="nation-wide">
                            <p>Nation Wide</p>
                        </x-app.job-center.job-board-item>
                        <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::COMPLETE_LINKEDIN->value" disabled id="csb_linkedin" icon="linkedin">
                            <div>
                                <p>Linkedin <span class="font-bold">Free</span></p>
                                {{--                                    <p class="text-primary underline"> Configured </p>--}}
                            </div>
                        </x-app.job-center.job-board-item>
                        <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::COMPLETE_TEACHER_ON_NET->value" id="csb_teacher_on_net" icon="teachers-on-net">
                            <p>Teachers on Net</p>
                        </x-app.job-center.job-board-item>
                    </div>
                </div>
            </div>

            <div class="w-full mt-20" x-data="{ showDetail:true }">
                <div class="flex justify-between items-center cursor-pointer" x-on:click="showDetail=!showDetail">
                    <p class="font-bold">School Branding with Employo Co-Branding</p>
                    <x-icon x-show="showDetail" name="heroicon-o-chevron-up" class="w-4 h-4"/>
                    <x-icon x-show="!showDetail" name="heroicon-o-chevron-down" class="w-4 h-4"/>
                </div>
                <div x-show="showDetail">
                    <p class="mt-10">Brand your school with a touch of Employo co-branding. Pay less than you will on the open market. Save time configuring. Avoid managing multiple accounts. Benefit from our priority positioning and trusted brand. Receive complimentary light-touch human support when required. </p>
                    <div class="mt-20 grid grid-cols-2 gap-y-5">
                        <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::COBRAND_SEEK->value" disabled id="cbec_seek" icon="seek">
                            <p>Seek</p>
                        </x-app.job-center.job-board-item>
                        <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::COBRAND_LINKEDIN->value" disabled id="cbec_linkedin" icon="linkedin">
                            <p>Linkedin <span class="font-bold">Free</span></p>
                        </x-app.job-center.job-board-item>
                        <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::COBRAND_SPORTSPEOPLE->value" disabled id="cbec_sports_people" icon="sports-people">
                            <p>SportsPeople</p>
                        </x-app.job-center.job-board-item>
                        <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::COBRAND_JORA->value" disabled id="cbec_jora" icon="jora">
                            <p>Jora</p>
                        </x-app.job-center.job-board-item>
                        <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::COBRAND_CHRISTIAN_JOBS->value" disabled id="cbec_christian" icon="christian-job">
                            <p>Christian Jobs</p>
                        </x-app.job-center.job-board-item>
                        <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::COBRAND_INDEED->value" disabled id="cbec_indeed" icon="indeed">
                            <p>indeed</p>
                        </x-app.job-center.job-board-item>
                        <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::COBRAND_ETHICAL_JOB_JOARD->value" disabled id="cbec_ethical" icon="ethical-job-board">
                            <p>Ethical Job Board</p>
                        </x-app.job-center.job-board-item>
                        <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::COBRAND_ADZUNA->value" disabled id="cbec_azdzuna" icon="adzuna">
                            <p>Adzuna</p>
                        </x-app.job-center.job-board-item>
                    </div>
                </div>
            </div>

{{--            <x-text.heading variant="h5" class="mb-20 text-gray-500 w-full my-20">--}}
{{--                Social Media--}}
{{--            </x-text.heading>--}}
{{--            <div class="mt-20 grid grid-cols-2 gap-y-5">--}}
{{--                <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::SOCIAL_FACEBOOK->value" disabled id="sm_facebook" icon="facebook">--}}
{{--                    <p>Facebook Post</p>--}}
{{--                </x-app.job-center.job-board-item>--}}
{{--                <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::SOCIAL_LINKEDIN->value" disabled id="sm_linkedin" icon="linkedin">--}}
{{--                    <p>Linkedin Post</p>--}}
{{--                </x-app.job-center.job-board-item>--}}
{{--                <x-app.job-center.job-board-item wire:model.live="fields.job_boards" :value="JobBoardTypes::SOCIAL_INSTAGRAM->value" disabled id="sm_instagram" icon="instagram">--}}
{{--                    <p>Instagram Post</p>--}}
{{--                </x-app.job-center.job-board-item>--}}
{{--            </div>--}}
        </div>
        {{--        <div class="lg:pl-10 mb-20 lg:mb-0">--}}
        {{--            <x-dialog class="p-5 lg:w-64 w-full text-app flex-col gap-3">--}}
        {{--                <div class="flex w-full items-center">--}}
        {{--                    <p class="font-bold w-2/3">Credit required</p>--}}
        {{--                    <div class="rounded-lg border flex-grow flex items-center justify-center py-4">0</div>--}}
        {{--                </div>--}}
        {{--                <div class="flex w-full items-center">--}}
        {{--                    <p class="font-bold w-2/3">Current Credits</p>--}}
        {{--                    <div class="rounded-lg border flex-grow flex items-center justify-center py-4">200</div>--}}
        {{--                </div>--}}
        {{--                <div class="flex w-full items-center">--}}
        {{--                    <p class="font-bold w-2/3">Cost</p>--}}
        {{--                    <div class="rounded-lg border flex-grow flex items-center justify-center py-4 text-white bg-tertiary">$0.00</div>--}}
        {{--                </div>--}}
        {{--            </x-dialog>--}}
        {{--        </div>--}}
    </div>

    <hr class="my-20"/>

    <div class="lg:px-64">
        <x-text.heading variant="h5" class="my-0 mb-20 text-gray-500 text-left w-full">
            Assign Panel Members
        </x-text.heading>
        <div class="mt-10">
            <livewire:forms.multi-select label="Panel Members" :error_message="$errors->first( 'panel_members' )" wire:model.live="panel_members" :with_search="false" class="w-full" :options="$panel_member_options"/>
        </div>
        {{--        <x-buttons.secondary elem_type="link" target="_blank" href="{{ route( 'school.settings' ) }}" class="mt-10 font-bold">Add panel member</x-buttons.secondary>--}}
    </div>

    <hr class="my-20"/>

    <div class="lg:px-64 text-app flex flex-col gap-10">
        <x-input.checkbox
            wire:model.live="fields.terms_conditions"
            id="tac"
            name="tac"
            label="I have read and accept the <a target='_blank' href='{{ route( 'terms_policy') }}' class='cursor-pointer underline'>Terms & Conditions</a>"
        />
        <x-input.checkbox
            wire:model.live="fields.billing_policy"
            id="billing_policy"
            name="billing_policy"
            label="I agree with the <a target='_blank' href='{{ route( 'billing_policy') }}' class='cursor-pointer underline'>billing policy</a>"
        />
{{--        wire:click="saveForm"--}}
        <x-button.primary wire:loading.class="disabled opacity-50 cursor-not-allowed" @click="$wire.submitForm();">Submit</x-button.primary>
    </div>

    <x-modal x-show="has_errors" onClose="has_errors = false; smoothScrollTo( 0 );">

        <div class="sm:flex sm:items-start">
            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                <x-icon name="heroicon-o-x-mark" class="h-6 w-6 text-danger"/>
            </div>
            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Uh Oh!</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500">The following errors must be corrected before submitting this job.</p>
                    <ul class="mt-2 text-sm text-gray-500">
                        @foreach( $errors->all() as $error )
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </x-modal>

    <x-modal x-show="submitted" onClose="submitted = false;  smoothScrollTo( 0 );">

        <div class="sm:flex sm:items-start">
            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                <x-icon name="heroicon-o-check" class="h-6 w-6 text-green-600"/>
            </div>
            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Job Updated</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500">You have successfully updated this job.</p>
                </div>
            </div>
        </div>

    </x-modal>

    <x-modal x-show="display_share" onClose="display_share = false">

        <div class="sm:flex sm:items-start">
            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                <x-icon name="heroicon-o-share" class="h-6 w-6 text-green-600"/>
            </div>
            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Share this job</h3>
                <span x-clipboard class="bg-gray-50 px-2 py-2 cursor-pointer rounded-sm block w-80 whitespace-nowrap overflow-hidden mt-2">{{ route( 'job', $job ) }}</span>

                <div class="mt-4">
                    <p class="text-sm text-gray-500 text-center">Copy the link above and share it with your network.</p>
                    <div class="flex gap-6 mt-4 justify-center">
                        <a href="https://facebook.com/" target="_blank" class="inline-block bg-[#1877F2] p-2 rounded-lg"><x-icon name="iconoir-facebook" class="w-10 h-10 text-white" /></a>
                        <a href="https://x.com/" target="_blank" class="inline-block bg-white p-2 rounded-lg"><x-icon name="iconoir-x" class="w-10 h-10 fill-black text-black" /></a>
                        <a href="https://linkedin.com/" target="_blank" class="inline-block bg-[#0077B5] p-2 rounded-lg"><x-icon name="iconoir-linkedin" class="w-10 h-10 text-white" /></a>
                    </div>
                </div>
            </div>
        </div>

    </x-modal>

</div>
