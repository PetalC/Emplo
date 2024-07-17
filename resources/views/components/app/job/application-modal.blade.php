<x-modal x-show="openJobApplicationModal" x-on:click.outside="openJobApplicationModal = false" onClose="openJobApplicationModal = false">
    <div class="flex flex-col gap-10 items-center">
        <h5 class="text-2xl">Job Application</h5>

        {{-- <x-stepper> --}}
        Step 1
        {{--</x-stepper>--}}


        <div class="grid grid-cols-2 gap-x-5 gap-y-10 w-full mb-20">
            {{-- Personal Information --}}
            <x-input.outline id="first_name" name="first_name" label="First name" placeholder="Your first name" />
            <x-input.outline id="last_name" name="last_name" label="Last name" placeholder="Your last name" />
            <x-input.outline id="phone_number" name="phone_number" label="Phone number" placeholder="Your phone number" />
            <x-input.outline id="email" name="email" label="Email address" placeholder="Your email address" />

            <div class="col-span-2 grid grid-cols-3 gap-x-5 items-end">
                <x-input.select id="city" name="city" label="Current location" :options="['Choose option', 'Lake lllawarra']" />
                <x-input.select id="state" name="state" label="" :options="['Choose option', 'NSW']" />
                <x-input.select id="country" name="country" label="" :options="['Choose option', 'Australia', 'New Zealand']" />
            </div>

            <div class="col-span-2">
                <x-input.outline id="specialists" name="specialists" label="Speciality areas" placeholder="eg. Frensh, Mathematics, Support Staff, Cleaner, Principal" />
            </div>

            <x-input.select id="right_to_work_in_au" name="right_to_work_in_au" label="Do you have right to work in Australia?" :options="['Yes', 'No']" />
            <x-input.select id="is_au_citizen" name="is_au_citizen" label="I am currently" :options="['An Australian Citizen']" />

            <div class="col-span-2 grid grid-cols-3 gap-x-5">
                <x-input.select id="licensing" name="licensing" label="Registration/Licensing" :options="\App\Enums\LicencingAuthorityTypes::cases()" />
                <x-input.outline id="registration_number" name="registration_number" label="Registration number" placeholder="eg. 1002 91487" />
                <x-input.outline id="registration_expiry" name="registration_expiry" label="Registration expiry" placeholder="eg. 05/28" />
            </div>

            <x-input.select id="preferred_job_type" name="preferred_job_type" label="Preferred job type" :options="['Teacher']" />
            <x-input.select id="how_did_you_learn" name="how_did_you_learn" label="How did you learn about this opportunity?" :options="['Seek']" />

            <div class="col-span-2 flex flex-col gap-2">
                <div class="flex items-center">
                    <label for="" class="block text-sm font-bold text-secondary">Salary Range</label>

                    <div class="flex items-center gap-5 ml-5">
                        <x-input.radio id="salary" name="salary" label="Salary" value="salary" />
                        <x-input.radio id="salary" name="salary" label="Salary" value="daily" />
                        <x-input.radio id="salary" name="salary" label="Salary" value="hourly" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-x-5">
                    <x-input.select id="salary_from" name="salary_from" label="" :options="['100,000', '110,000']" />
                    <x-input.select id="salary_to" name="salary_to" label="" :options="['120,000', '130,000']" />
                </div>
            </div>

            <div class="col-span-2">
                <x-input.outline id="i_am_currently" name="i_am_currently" label="I am currently" placeholder="eg. Taxonomies" />
            </div>

            <div class="col-span-2">
                <x-input.outline id="i_am_currently_working_in" name="i_am_currently_working_in" label="I am currently working in/as" placeholder="eg. Taxonomies" />
            </div>

            <div class="col-span-2">
                <x-input.outline id="i_am_seeking_a_role_as" name="i_am_seeking_a_role_as" label="I am seeking a role as/or in" placeholder="eg. Taxonomies" />
            </div>

            <div class="col-span-2">
                <x-input.outline id="my_preferred_job_types" name="my_preferred_job_types" label="My preferred job types are" placeholder="eg. Taxonomies" />
            </div>

            <div class="col-span-2">
                <x-input.outline id="my_preferred_job_length" name="my_preferred_job_length" label="My preferred job length is" placeholder="eg. Taxonomies" />
            </div>

            <div class="col-span-2">
                <x-input.outline id="my_preferred_school_types" name="my_preferred_school_types" label="My preferred school types are" placeholder="eg. Taxonomies" />
            </div>

            <div class="col-span-2">
                <x-input.select id="can_you_supply_fairth_reference" name="can_you_supply_fairth_reference" label="Can you supply a faith reference?" :options="['Yes', 'No']" />
            </div>

            <div class="col-span-2">
                <x-input.textarea id="statement" name="statement" label="Statement" rows="5" />
            </div>

            {{-- Experience --}}
            <div class="col-span-2 flex flex-col gap-10">
                <h5 class="font-bold text-lg">Experience</h5>

                <div class="flex flex-col gap-10">
                    <x-input.outline id="company" name="company" label="Company" placeholder="Company name" />
                    <x-input.outline id="position" name="position" label="Position" placeholder="Position" />

                    <div class="grid grid-cols-2 gap-x-5">
                        <x-input.select id="exp_from_date" name="exp_from_date" label="From" :options="['August 2022', 'Sep 2022']" />
                        <x-input.select id="exp_to_date" name="exp_to_date" label="To" :options="['August 2023', 'Present']" />
                    </div>

                    <x-input.textarea id="exp_description" name="exp_description" label="Description" rows="5" />
                </div>

                <x-button.outline class="font-bold">Add another</x-button.outline>
            </div>

            {{-- Education --}}
            <div class="col-span-2 flex flex-col gap-10">
                <h5 class="font-bold text-lg">Education</h5>

                <div class="flex flex-col gap-10">
                    <x-input.outline id="edu_institution" name="edu_institution" label="Institution" placeholder="Institution" />
                    <x-input.outline id="edu_certification" name="edu_certification" label="Certification" placeholder="Certification" />

                    <div class="grid grid-cols-2 gap-x-5">
                        <x-input.select id="edu_from_date" name="edu_from_date" label="From" :options="['August 2022', 'Sep 2022']" />
                        <x-input.select id="edu_to_date" name="edu_to_date" label="To" :options="['August 2023', 'Present']" />
                    </div>

                    <x-input.textarea id="edu_description" name="edu_description" label="Description" rows="5" />
                </div>

                <x-button.outline class="font-bold">Add another</x-button.outline>
            </div>

            {{-- Certification --}}
            <div class="col-span-2 flex flex-col gap-10">
                <h5 class="font-bold text-lg">Certifications</h5>

                <div class="flex flex-col gap-10">
                    <x-input.outline id="cert_institution" name="cert_institution" label="Institution" placeholder="Institution" />
                    <x-input.outline id="cert_certification" name="cert_certification" label="Certification" placeholder="Certification" />

                    <div class="grid grid-cols-2 gap-x-5">
                        <x-input.select id="cert_from_date" name="cert_from_date" label="From" :options="['August 2022', 'Sep 2022']" />
                        <x-input.select id="cert_to_date" name="cert_to_date" label="To" :options="['August 2023', 'Present']" />
                    </div>

                    <x-input.textarea id="cert_description" name="cert_description" label="Description" rows="5" />
                </div>

                <x-button.outline class="font-bold">Add another</x-button.outline>
            </div>

            <div class="col-span-2 flex flex-col gap-5">
                <h5 class="block mb-2 text-sm font-bold text-secondary">School employment suitability declaration</h5>

                <ol class="list-decimal font-semibold text-sm ml-4">
                    <li>I declare the above is accurate and true and was completed in good faith to secure a job in a school; and</li>
                    <li>I understand the role and responsibilities of an employee working within a school setting where staff are directly or indirectly working with children and young people; and</li>
                    <li>I have undertaken child protection and reportable conduct training in the last twelve months; and</li>
                    <li>I am capable of carrying out the activities and upholiding the responsibilities required to safeguard for child protection purposes; and</li>
                    <li>I have not been suspended from or had any registration with a teacher liscensing authority cancelled due to child protection or conduct deemed reportable for child protection purposes; and</li>
                    <li>I have no criminal convictions in the past ten years. I understand that "conviction" is defined in the Criminal Records Act 1991 and includes a conviction, whether summary or an indictment for an offense, and includes a finding or order that an offence has been proved, or that a person is guilty of an offence, without proceeding to a conviction; and</li>
                    <li>I am not subject to any pending court proceedings relating to a criminal matter in Australia or overseas; and</li>
                    <li>
                        <p>I have no convictions that cannot become spent within the meaning of the Criminal Records Act 1991 including but not limited to:</p>
                        <div class="flex flex-col">
                            <p>a. convictions for which a prison sentence of more than six months has been imposed: or</p>
                            <p>b. convictions of sexual offences</p>
                        </div>
                    </li>
                </ol>
            </div>

            <div class="col-span-2">
                <x-input.checkbox id="confirm_suitability_declartion_read" name="confirm_suitability_declartion_read" label="I have read the Suitability Declaration and declare myself suitable for this role." />
            </div>

            <x-button.primary>Done</x-button.primary>
        </div>
</x-modal>
