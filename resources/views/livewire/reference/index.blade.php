<div class="mx-auto max-w-8x">
    <x-app.common.page_header>
        <x-slot:column_left>
            <x-app.school.avatar :campus="$job->campus" />
        </x-slot:column_left>

        <x-text.heading class="text-center text-gray-700" variant="h1">Reference Request</x-text.heading>
        <x-text.subheading class="mt-6">{{ $job->campus->primary_profile->name }}</x-text.subheading>
    </x-app.common.page_header>
{{--    @dump($referee_details ?? [], $details)--}}
    <div class="grid grid-cols-12">
        <div class="col-span-6 col-start-4 rounded-lg border mt-20 text-app px-20 py-10 flex flex-col gap-14">
            {{-- Applicant --}}
            <div>
                <x-text.subheading class="mt-6">Applicant</x-text.subheading>
                <div class="mt-8">
                    <div class="flex">
                        <div class="w-1/3 font-bold"> Name </div>
                        <div > {{ $candidate->first_name . ' ' .     $candidate->last_name}} </div>
                    </div>
                    <div class="flex mt-2">
                        <div class="w-1/3 font-bold"> Vacancy/Job Role </div>
                        <div > {{ $job->title}} </div>
                    </div>
                </div>
            </div>

            {{-- Previous employment details --}}
            <div class="bg-red-50">
                <x-text.subheading class="mt-6">Previous employment details</x-text.subheading>
                <div class="mt-8">
                    <div class="flex">
                        <div class="w-1/3 font-bold"> Name </div>
                        <div > Tyson Wood </div>
                    </div>
                    <div class="flex mt-2">
                        <div class="w-1/3 font-bold"> Position and subject </div>
                        <div > Teacher, English, French </div>
                    </div>
                    <div class="flex mt-2">
                        <div class="w-1/3 font-bold"> Place of employment </div>
                        <div > The Sydney College </div>
                    </div>
                    <div class="flex mt-2">
                        <div class="w-1/3 font-bold"> Dates of employment </div>
                        <div > March 2020, March 2023 </div>
                    </div>
                    <div class="flex mt-2">
                        <div class="w-1/3 font-bold"> Reason for leaving </div>
                        <div > End of Contract </div>
                    </div>
                </div>
            </div>

            {{-- Referee details --}}
            <div class="flex flex-col gap-10">
                <x-text.subheading class="mt-6">Referee details</x-text.subheading>
                <x-input.outline id="full_name" name="full_name" label="Full name" placeholder="Your full name" wire:model.blur="details.full_name" />
                <x-input.outline id="position" name="position" label="Position and subject" placeholder="Your position while working with candidate" wire:model.blur="details.position" />
                <x-input.outline id="place_of_emp" name="place_of_emp" label="Place of employment" placeholder="Your place of employment while working with candidate" wire:model.blur="details.place_emp" />

                <div>
                    <p class="font-bold">Dates you worked with candidate</p>
                    <div class="mt-5 grid grid-cols-2 gap-10">
                        <x-datepicker id="from_date" name="from_date" label="From" wire:model.blur="details.work_with_date_start"/>
                        <x-datepicker id="to_date" name="to_date" label="To" wire:model.blur="details.work_with_date_end"/>
                    </div>
                </div>

                <x-input.outline id="preferred_contact" name="preferred_contact" label="Preferred contact and details" placeholder="Your preferred contact details" wire:model.blur="details.preferred_contact" />
            </div>

            {{--Child protection or reportable conduct--}}
            <div>
                <x-text.subheading class="mt-6">Child protection or reportable conduct</x-text.subheading>
                <div class="mt-8 flex flex-col gap-14">
                    <div>
                        <p>Are you aware of any child protection or reportable conduct disciplinary proceedings in relation to this candidate?</p>
                        <div class="mt-5 flex flex-col gap-5">
                            <x-input.radiobox id="child_protection_no" name="child_protection" label="No" wire:model.blur="details.child_protection"/>
                            <x-input.radiobox id="child_protection_yes" name="child_protection" label="Yes, if yes please provide details" wire:model.blur="details.child_protection" />
                            <x-input.outline id="child_protection_detail" name="child_protection_detail" placeholder="Provide details" wire:model.blur="details.child_protection_details"/>
                        </div>
                    </div>
                    <div>
                        <p>Are you aware of this candidate being subject to performance related diciplinary proceedings?</p>
                        <div class="mt-5 flex flex-col gap-5">
                            <x-input.radiobox id="performance_related_no" name="perfermance_related" label="No" wire:model.blur="details.performance_related" />
                            <x-input.radiobox id="performance_related_yes" name="perfermance_related" label="Yes, if yes please provide details" wire:model.blur="details.performance_related" />
                            <x-input.outline id="perfoermance_related_detail" name="performance_related_detail" placeholder="Provide details" wire:model.blur="details.performance_related_details"/>
                        </div>
                    </div>
                    <div>
                        <p>Are you aware of any reasons why this person should not be working with children? </p>
                        <div class="mt-5 flex flex-col gap-5">
                            <x-input.radiobox id="reason_not_with_children_no" name="reason_not_with_children" label="No" wire:model.blur="details.reason_not_with_children" />
                            <x-input.radiobox id="reason_not_with_children_yes" name="reason_not_with_children" label="Yes, if yes please provide details" wire:model.blur="details.reason_not_with_children" />
                            <x-input.outline id="reason_not_with_children_detail" name="reason_not_with_children_detail" placeholder="Provide details" wire:model.blur="details.reason_not_with_children_details"/>
                        </div>
                    </div>
                    <div>
                        <p>To your knowledge, has this candidate completed recent child protection and mandatory reporting training? </p>
                        <div class="mt-5 flex flex-col gap-5">
                            <x-input.radiobox id="recent_child_protection" label="Yes" value="1" wire:model.blur="details.recent_child_protection" />
                            <x-input.radiobox id="recent_child_protection_no" label="No"  value="0" wire:model.blur="details.recent_child_protection" />
                            <x-input.radiobox id="recent_child_protection_unsure" label="Unsure" value="2" wire:model.blur="details.recent_child_protection" />
                        </div>
                    </div>

                    {{-- May make sense as a serialised list of data, not too sure how often this rating scheme changes --}}
                    {{-- Rate Candidate --}}
                    <div>
                        <p>Please rate this candidate in accordance with the below Australian Professional teaching standards. Please evaluate this candidate at the level expected based on their experience. </p>
                        <div class="flex flex-col gap-14 mt-14 font-bold">
                            <div>
                                <p>Knows students and how they learn</p>
                                <div class="flex gap-5 mt-5">
                                    <x-input.radiobox id="know_student_inadequate" wire:model.blur="details.know_student" value="0" label="Inadequate" />
                                    <x-input.radiobox id="know_student_competent" wire:model.blur="details.know_student" value="1" label="Competent" />
                                    <x-input.radiobox id="know_student_effective" wire:model.blur="details.know_student" value="2" label="Effective" />
                                    <x-input.radiobox id="know_student_proficient" wire:model.blur="details.know_student" value="3" label="Highly Proficient" />
                                </div>
                            </div>
                            <div>
                                <p>Knows the content and how to teach it</p>
                                <div class="flex gap-5 mt-5">
                                    <x-input.radiobox id="know_content_inadequate" wire:model.blur="details.know_content" value="0" label="Inadequate" />
                                    <x-input.radiobox id="know_content_competent" wire:model.blur="details.know_content" value="1" label="Competent" />
                                    <x-input.radiobox id="know_content_effective" wire:model.blur="details.know_content" value="2" label="Effective" />
                                    <x-input.radiobox id="know_content_proficient" namewire:model.blur="details.know_content" value="3" label="Highly Proficient" />
                                </div>
                            </div>
                            <div>
                                <p>Plans for and implements effective teaching and learning</p>
                                <div class="flex gap-5 mt-5">
                                    <x-input.radiobox id="plan_for_teaching_inadequate" wire:model.blur="details.plan_for_teaching" value="0" label="Inadequate" />
                                    <x-input.radiobox id="plan_for_teaching_competent" wire:model.blur="details.plan_for_teaching" value="1" label="Competent" />
                                    <x-input.radiobox id="plan_for_teaching_effective" wire:model.blur="details.plan_for_teaching" value="2" label="Effective" />
                                    <x-input.radiobox id="plan_for_teaching_proficient" wire:model.blur="details.plan_for_teaching" value="3" label="Highly Proficient" />
                                </div>
                            </div>
                            <div>
                                <p>Creates and maintains supportive and safe learning environments</p>
                                <div class="flex gap-5 mt-5">
                                    <x-input.radiobox id="create_maintain_learning_inadequate" wire:model.blur="details.create_learning" value="0" label="Inadequate" />
                                    <x-input.radiobox id="create_maintain_learning_competent" wire:model.blur="details.create_learning" value="1" label="Competent" />
                                    <x-input.radiobox id="create_maintain_learning_effective" wire:model.blur="details.create_learning" value="2" label="Effective" />
                                    <x-input.radiobox id="create_maintain_learning_proficient" wire:model.blur="details.create_learning" value="3" label="Highly Proficient" />
                                </div>
                            </div>
                            <div>
                                <p>Assesses, provides feedback and reports on student learning</p>
                                <div class="flex gap-5 mt-5">
                                    <x-input.radiobox id="asses_provide_student_learning_inadequate" wire:model.blur="details.assess_learning" value="0" label="Inadequate" />
                                    <x-input.radiobox id="asses_provide_student_learning_competent" wire:model.blur="details.assess_learning" value="1" label="Competent" />
                                    <x-input.radiobox id="asses_provide_student_learning_effective" wire:model.blur="details.assess_learning" value="2" label="Effective" />
                                    <x-input.radiobox id="asses_provide_student_learning_proficient" wire:model.blur="details.assess_learning" value="3" label="Highly Proficient" />
                                </div>
                            </div>
                            <div>
                                <p>Engages in professional learning</p>
                                <div class="flex gap-5 mt-5">
                                    <x-input.radiobox id="engage_in_professional_inadequate" wire:model.blur="details.professionalism" value="0" label="Inadequate" />
                                    <x-input.radiobox id="engage_in_professional_competent" wire:model.blur="details.professionalism" value="1" label="Competent" />
                                    <x-input.radiobox id="engage_in_professional_effective" wire:model.blur="details.professionalism" value="2" label="Effective" />
                                    <x-input.radiobox id="engage_in_professional_proficient" wire:model.blur="details.professionalism" value="3" label="Highly Proficient" />
                                </div>
                            </div>
                            <div>
                                <p>Engages professionally with colleagues, parents/carers and community</p>
                                <div class="flex gap-5 mt-5">
                                    <x-input.radiobox id="engage_with_colleague_inadequate" wire:model.blur="details.colleague_engagement" value="0" label="Inadequate" />
                                    <x-input.radiobox id="engage_with_colleague_competent" wire:model.blur="details.colleague_engagement" value="1" label="Competent" />
                                    <x-input.radiobox id="engage_with_colleague_effective" wire:model.blur="details.colleague_engagement" value="2" label="Effective" />
                                    <x-input.radiobox id="engage_with_colleague_proficient" wire:model.blur="details.colleague_engagement" value="3" label="Highly Proficient" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Performance --}}
            <div class="flex flex-col gap-10">
                <x-text.subheading class="mt-6">Performance</x-text.subheading>
                <div class="flex flex-col gap-3">
                    <p class="font-bold"> Would you recommend this candidate?</p>
                    <x-input.outline id="recommend_candidate_yes" name="recommend_candidate_yes" placeholder="Yes, and reasons why?" wire:model.blur="details.recommended_yes_details"/>
                    <x-input.outline id="recommend_candidate_no" name="recommend_candidate_no" placeholder="No, and reasons why?" wire:model.blur="details.recommended_no_details"/>
                </div>
                <div class="flex flex-col gap-3">
                    <p class="font-bold"> Would you rehire this candidate?</p>
                    <x-input.outline id="rehire_candidate_yes" name="rehire_candidate_yes" placeholder="Yes, and reasons why?" wire:model.blur="details.rehire_yes_details" />
                    <x-input.outline id="rehire_candidate_no" name="rehire_candidate_no" placeholder="No, and reasons why?" wire:model.blur="details.rehire_no_details" />
                </div>
            </div>

            <x-buttons.primary type="submit" size="lg" wire:click="submit" wire:loading.attr="disabled" class="mt-5 w-1/6">
                <span wire:loading wire:target="nextComponent">Wait...</span>
                <span wire:loading.remove wire:target="nextComponent">Submit</span>
            </x-buttons.primary>
        </div>
    </div>
</div>
