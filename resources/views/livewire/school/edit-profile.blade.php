<div>
    <div class="grid grid-cols-5 max-w-8xl mx-auto relative">
        <div class="col-span-3 col-start-2 flex flex-col items-center">
            <x-text.heading variant="h1" class="my-14">School <span class="text-school_primary">Profile</span></x-text.heading>

            {{-- logo --}}
{{--            <div class="absolute top-0 left-20 -translate-y-20">--}}
{{--                <div class="flex flex-col gap-6">--}}
{{--                    <x-input.upload preview="{{ $profile->getMedia( \App\Enums\MediaCollections::CAMPUS_LOGO->value )->first() }}" id="logo_upload_field" class="w-56 h-56 max-w-56" accept="image/*" wire:model.live="logo_upload_file" />--}}
{{--                </div>--}}
{{--                @error('logo_upload_file') <p class="text-red-500">{{ $message }}</p> @enderror--}}
{{--            </div>--}}

            {{-- School Profile --}}
            <div class="w-full mb-20 px-20 flex flex-col gap-20">

                <div>
                    <p class="text-3xl text-gray-500">What is the name of your school.</p>
                    <div class="mt-10 w-full">
                        <x-input.outline class="w-full" wire:model.live.debounce.200ms="name" id="name" name="name" class="!text-2xl !font-light pb-2" />
                    </div>
                </div>

                <div>
                    <p class="text-3xl text-gray-500">What is the address of your school.</p>
                    <div class="mt-10">
                        <x-app.dashboard.location-search wire:model.live.debounce.200ms="address_search" :user_address_results="$address_results" id="location-search" name="location-search" placeholder="Search for an address, or enter manually below." />
                    </div>
                    <div class="w-full mt-10">
                        <x-input.outline class="w-full" label="Address" wire:model.live.debounce.200ms="address" id="address" name="address"  />
                    </div>
                    <div class="mt-10 w-full grid grid-cols-1 xl:grid-cols-4 gap-4">
                        <x-input.outline class="w-full" label="City" wire:model.live.debounce.200ms="city" id="city" name="city"  />
                        <x-input.outline class="w-full" label="State" wire:model.live.debounce.200ms="state" id="state" name="state"  />
                        <x-input.outline class="w-full" label="Country" wire:model.live.debounce.200ms="country" id="country" name="country"  />
                        <x-input.outline class="w-full" label="Postcode" wire:model.live.debounce.200ms="zipcode" id="zipcode" name="zipcode"  />
                    </div>
                </div>

                {{-- Upload logo --}}
                <div>
                    <p class="text-3xl text-gray-500">Upload your school logo</p>
                    <div class="w-full mt-8 flex gap-10 items-center">
                        <x-input.upload class="w-44 aspect-square flex items-center justify-center" :media="$profile->getFirstMedia( \App\Enums\MediaCollections::CAMPUS_LOGO->value )" id="logo_upload_file" accept="image/*" wire:model.live="logo_upload_file" />
                        <p class="text-gray-500 flex-grow">
                            <strong>Recommended size is 450 x 450</strong><br />
                            This should be a square image, and no more than 1MB.
                        </p>
                    </div>
                    @error('logo_upload_file') <p class="text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Upload photo --}}
                <div>
                    <p class="text-3xl text-gray-500">Upload a banner image of your school campus</p>
                    <div class="w-full mt-8 flex flex-col gap-10">
                        <x-input.upload class="w-full flex justify-center" :media="$profile->getFirstMedia( \App\Enums\MediaCollections::CAMPUS_BANNER->value )" id="banner_upload" accept="image/*" wire:model.live="banner_upload" />
                        <p class="text-gray-500 flex-grow">
                            <strong>Recommended size is 1600 x 1200</strong><br />
                            This should be a picture of your school grounds or building. Please do not upload pictures of people.
                        </p>
                    </div>
                    @error('banner_upload') <p class="text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Gallery Images --}}
                <div>
                    <p class="text-3xl text-gray-500">Upload images for your school gallery</p>
                    <div class="w-full mt-8 flex gap-10 items-center">
                        <x-input.upload class="min-w-44 w-44 aspect-square flex items-center justify-center" id="gallery_upload_file" accept="image/*" wire:model.live="gallery_upload" />
                        <p class="text-gray-500 flex-grow">
                            We suggest you upload a minimum of 2 photos or upload up to 9 photos. They display best when they are all landscape or all portrait and have a consistent aspect ratio.
                        </p>
                    </div>
                    @error('gallery_upload') <p class="text-red-500">{{ $message }}</p> @enderror

                    <div>
                        <div class="grid grid-cols-3 gap-5 pt-4" wire:loading.class="opacity-20">
                            @foreach( $profile->getMedia( \App\Enums\MediaCollections::CAMPUS_GALLERY->value ) as $media )
                                <div class="relative border border-gray-400 rounded-lg overflow-hidden" wire:key="image_{{ $media->id }}">
                                    {{ $media }}
                                    <span wire:click="deleteGalleryImage({{ $media->id }})" class="absolute top-0 right-0 bg-red-500/80 text-white p-1 text-xs stroke-2 cursor-pointer">
                                        <x-heroicon-o-x-mark class="h-4 w-4"/>
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                {{-- Branding Colors--}}
                <div>
                    <p class="text-3xl text-gray-500">What are the brand colours for your school?</p>
                    <div class="w-full mt-8 flex gap-10 items-center">
                        <x-input.outline variant="row" type="color" label="Primary Color" wire:model.live="branding_primary_color" class="!border-none min-h-10" />
                    </div>

{{--                    <div class="w-full mt-16 flex gap-10 items-center">--}}
{{--                        <x-input.outline variant="row" type="color" label="Secondary Color" wire:model.live="branding_secondary_color" class="!border-none" />--}}
{{--                    </div>--}}

{{--                    <div class="w-full mt-16 flex gap-10 items-center">--}}
{{--                        <x-input.outline variant="row" type="color" label="Tertiary Color" wire:model.live="branding_tertiary_color" class="!border-none" />--}}
{{--                    </div>--}}
                </div>

                {{-- Some information about school --}}
                <div>
                    <p class="text-3xl text-gray-500"> Let's give job seekers some information about your school </p>
                    <div class="mt-8 flex flex-col gap-5">
                        <x-input.outline variant="row" wire:model.live.debounce.200ms="student_enrollments" label="How many student enrolments?" id="student_enrolments" name="student_enrolments" placeholder="Number of students" />
                        <x-input.outline variant="row" wire:model.live.debounce.200ms="staff_size" label="What's your schools staff size?" id="staff_size" name="staff_size" placeholder="Number of staff" />
                        <x-input.outline variant="row" wire:model.live.debounce.200ms="teacher_size" label="How many are teachers?" id="teacher_size" name="teacher_size" placeholder="Number of teaching staff" />

                        <livewire:forms.multi-select
                            wire:model.live="school_types"
                            variant="row"
                            :model="App\Models\SchoolType::class"
                            :options="App\Models\SchoolType::all()->pluck( 'name', 'id' )->toArray()"
                            :with_search="true"
                            label="What is your school type?"
                        />

                        <livewire:forms.multi-select
                            wire:model.live="school_genders"
                            variant="row"
                            :model="App\Models\SchoolGender::class"
                            :options="App\Models\SchoolGender::all()->pluck( 'name', 'id' )->toArray()"
                            :with_search="true"
                            label="Confirm school gender"
                        />

                        <livewire:forms.multi-select
                            wire:model.live="school_sectors"
                            variant="row"
                            :model="App\Models\Sector::class"
                            :options="App\Models\Sector::all()->pluck( 'name', 'id' )->toArray()"
                            :with_search="true"
                            label="What is your school sector?"
                        />

                        <livewire:forms.multi-select
                            wire:model.live="school_religions"
                            variant="row"
                            :model="App\Models\Religion::class"
                            :options="App\Models\Religion::all()->pluck( 'name', 'id' )->toArray()"
                            :with_search="true"
                            label="What is your school religion?"
                        />

                        <livewire:forms.multi-select
                            wire:model.live="school_curricula"
                            variant="row"
                            :model="App\Models\Curriculum::class"
                            :options="App\Models\Curriculum::all()->pluck( 'name', 'id' )->toArray()"
                            :with_search="true"
                            label="What is your school curriculum?"
                        />

                        <livewire:forms.multi-select
                            wire:model.live="school_location_types"
                            variant="row"
                            :model="App\Models\LocationType::class"
                            :options="App\Models\LocationType::all()->pluck( 'name', 'id' )->toArray()"
                            :with_search="true"
                            label="What area is your school in?"
                        />

                    </div>
                </div>

                {{-- About your School --}}
                <div>
                    <p class="text-3xl text-gray-500">Tell us about your school.</p>
                    <div class="mt-10 w-full">
                        <x-input.textarea characterLimit="500" wire:model.live.debounce.200ms="description" id="about_school" name="about_school" placeholder="Write a short profile about your school. You can make it general. The sections ahead will focus on employment at your school." rows="10" />
                    </div>
                </div>

                {{-- stand-out quote about your school --}}
                <div>
                    <p class="text-3xl text-gray-500">Write a stand-out quote about your school</p>
                    <div class="mt-10 w-full">
                        <x-input.outline wire:model.live.debounce.200ms="quote" id="stand_out_quote" name="stand_out_quote" placeholder="Write a single sentence about your school to stand out to candidates." />
                    </div>
                </div>

{{--                 You Tube link --}}
                <div>
                    <p class="text-3xl text-gray-500">YouTube link</p>
                    <p class="text-gray-500 mt-10">Please enter a youtube video URL to display to potential candidates.</p>
                    @if( $profile->youtube_embed_url )
                        <iframe class="w-full h-96 mt-10" src="{{ $profile->youtube_embed_url }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    @endif
                    <div class="w-full mt-8 flex gap-10 items-center">
                        <x-input.outline id="youtube"
                            wire:model.live.debounce.200ms="video_url"
                            name="youtube"
                            type="text"
                            placeholder="Paste YouTube link"
                            class="w-full"
                        />
                    </div>
                </div>

                {{-- Employment Value Proposition --}}
                <div>
                    <p class="text-3xl text-gray-500">Tell us about your Employment Value Proposition</p>
                    <div class="mt-10 w-full">
                        <x-input.textarea characterLimit="1000" wire:model.live.debounce.200ms="proposition" id="employment_value" name="employment_value" placeholder="Write a profile statement about your school that appeals to staff who may want to work with you.  Employment Value Propositions are becoming an important part of the attraction of staff.  This doesn't need to be complicated. If you have a statement already, simply insert it into this space.  If you don't, simply list all of the benefits which you offer to staff. " rows="10" />
                    </div>
{{--                    <p class="float-right mt-3 text-gray-500">500 characters remaining</p>--}}
                </div>

                {{-- Staff --}}
{{--                <div>--}}
{{--                    <p class="text-3xl text-gray-500">Your staff are your most important asset</p>--}}
{{--                    <p class="mt-10 text-gray-500"> Let them tell anyone looking at your career page how good it is working at your school. Remember, Employo isn’t just about teaching staff. Once testimonials are completed by staff, they are approved by you before publishing.  </p>--}}

{{--                    <div class="w-full flex mt-10 gap-10 justify-between">--}}
{{--                        <div class="w-1/3">--}}
{{--                            <x-input.outline id="full_name_01" name="full_name_01" placeholder="Full name" />--}}
{{--                        </div>--}}
{{--                        <div class="w-1/3">--}}
{{--                            <x-input.outline id="email_01" name="email_01" placeholder="Email address" />--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <x-button.secondary>Send tesimonial link</x-button.secondary>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="w-full flex mt-10 gap-10 justify-between">--}}
{{--                        <div class="w-1/3">--}}
{{--                            <x-input.outline id="full_name_02" name="full_name_02" placeholder="Full name" />--}}
{{--                        </div>--}}
{{--                        <div class="w-1/3">--}}
{{--                            <x-input.outline id="email_02" name="email_02" placeholder="Email address" />--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <x-button.secondary>Send tesimonial link</x-button.secondary>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="w-full flex mt-10 gap-10 justify-between">--}}
{{--                        <div class="w-1/3">--}}
{{--                            <x-input.outline id="full_name_03" name="full_name_03" placeholder="Full name" />--}}
{{--                        </div>--}}
{{--                        <div class="w-1/3">--}}
{{--                            <x-input.outline id="email_03" name="email_03" placeholder="Email address" />--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <x-button.secondary>Send tesimonial link</x-button.secondary>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

                {{-- Add user privileges --}}
{{--                <div>--}}
{{--                    <p class="text-3xl text-gray-500">Your staff are your most important asset</p>--}}
{{--                    <div class="mt-10">--}}
{{--                        <div class="w-full flex gap-10">--}}
{{--                            <div class="w-1/2">--}}
{{--                                <x-input.outline id="privilege_full_name" name="privilege_full_name" placeholder="Full name" />--}}
{{--                            </div>--}}
{{--                            <div class="w-1/2">--}}
{{--                                <x-input.outline id="position_title" name="position_title" placeholder="Position title" />--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="w-full flex gap-10 mt-10">--}}
{{--                            <div class="w-1/2">--}}
{{--                                <x-input.outline id="privilege_email" name="privilege_email" placeholder="Full name" />--}}
{{--                            </div>--}}
{{--                            <div class="w-1/2">--}}
{{--                                <x-input.select id="school_type" name="school_type" :options="['A', 'B']" placeholder="Choose access" />--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="mt-10">--}}
{{--                        <x-button.outline>Add users</x-button.outline>--}}
{{--                    </div>--}}
{{--                </div>--}}

                {{-- School social links --}}
{{--                <div>--}}
{{--                    <p class="text-3xl text-gray-500">Configure job boards and school socials</p>--}}
{{--                    <div class="mt-10 flex flex-col gap-5">--}}
{{--                        <x-input.outline variant="row" wire:model.live.debounce.200ms="job_boards.seek" label="Seek" id="seek_account_number" name="seek_account_number" placeholder="Account number" />--}}
{{--                        <x-input.outline variant="row" wire:model.live.debounce.200ms="social_profiles.facebook" label="Facebook" id="facebook_url" name="facebook_url" placeholder="URL" />--}}
{{--                        <x-input.outline variant="row" wire:model.live.debounce.200ms="social_profiles.instagram" label="Instagram" id="instagram_url" name="instagram_url" placeholder="URL" />--}}
{{--                        <x-input.outline variant="row" wire:model.live.debounce.200ms="social_profiles.linkedin" label="Linkedin" id="linkedin_url" name="linkedin_url" placeholder="URL" />--}}
{{--                    </div>--}}
{{--                </div>--}}

                {{-- Additional campuses --}}
{{--                <div>--}}
{{--                    <p class="text-3xl text-gray-500">Additional campuses</p>--}}
{{--                    <p class="mt-10 text-gray-500">If you have less than three campuses in different locations, enter in the addresses of the additional campuses.  Your main campus is already set up.  If you govern more than three schools please contact <span class="underline">groups@employo.com.au</span>. If not, simply select next below.</p>--}}
{{--                    <div class="mt-10">--}}
{{--                        <div class="w-full flex gap-10">--}}
{{--                            <div class="w-1/2">--}}
{{--                                <x-input.outline id="campus_name" name="campus_name" placeholder="Name of Campus" />--}}
{{--                            </div>--}}
{{--                            <div class="w-1/2">--}}
{{--                                <x-input.outline id="campus_address" name="campus_address" placeholder="Address" />--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="w-full flex gap-10 mt-10">--}}
{{--                            <div class="w-1/2">--}}
{{--                                <x-input.outline id="campus_city" name="campus_city" placeholder="City" />--}}
{{--                            </div>--}}
{{--                            <div class="w-1/2">--}}
{{--                                <x-input.outline id="campus_postcode" name="campus_postcode" placeholder="Postcode" />--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="mt-10">--}}
{{--                            <x-button.outline>Add campus</x-button.outline>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>

            <div class="flex flex-col items-center">

                <p class="text-lg font-light mb-6">This form is saved as you type. There is no need to save anything, you are already done!</p>

                <x-buttons.primary class="mb-6" elem_type="link" target="_blank" href="{{ route('schools.view', $profile->campus ) }}">View Your Updated Profile</x-buttons.primary>

            </div>

            {{-- save --}}
{{--            <div class="absolute top-20 right-20">--}}
{{--                <x-button.primary>Save</x-button.primary>--}}
{{--            </div>--}}
        </div>
    </div>
</div>
