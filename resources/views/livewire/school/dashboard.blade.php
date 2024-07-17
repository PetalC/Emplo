<div class="max-w-8xl mx-auto lg:px-0 px-20">

    <x-app.common.page_header>
        <x-slot name="column_left">
            <x-app.school.avatar class="max-w-56" :campus="$campus" />
            <x-buttons.secondary elem_type="link" href="{{ route( 'school.campus_profile' ) }}" class="w-full max-w-56 mb-4 mt-6 flex justify-center py-3 !font-light !text-xl">Update Profile</x-buttons.secondary>
        </x-slot>
        <x-slot name="column_right">
            <div class="mt-16 gap-5 items-center text-gray-500 flex justify-end">
                <div class="lg:w-full">
{{--                    @if(auth()->user()->hasRole('School Account Manager'))--}}
{{--                        <a class="text-center" href="{{route('school.select_school')}}">Back</a>--}}
{{--                    @endif--}}
                    <div class="flex flex-col justify-end w-full opacity-80 cursor-not-allowed">
                        <x-button.outline class="w-full mb-4 opacity-80 cursor-not-allowed">Download Report</x-button.outline>
                        <x-input.selectbox prefix="Time period" id="time_period" name="time_period" :options="['All time', 'This week']" />
                    </div>
                </div>
            </div>
        </x-slot>

        <x-text.heading variant="h1" class="mb-4  text-gray-500 text-center w-full">{{ $campus->primary_profile?->name ?? $campus->school->name }}</x-text.heading>
        <x-text.heading variant="h5" class="lg:block hidden my-0 mb-20 text-gray-500 text-center w-full">
            Dashboard Analytics
        </x-text.heading>
    </x-app.common.page_header>



    {{-- Right button and component --}}


    <div class="flex flex-col justify-between gap-20">
        {{--OverView--}}
        <div class="w-full lg:mt-0  mt-20">
            <p class="text-4xl text-gray-500"> Overview </p>
            <div class="grid lg:grid-cols-3 grid-cols-1 mt-10 gap-5">
                <x-app.school.dashboard.text-pan link="{{ route( 'school.staffroom.candidates' ) }}" :number="$stats['applicant_count']" label="Candidates"/>
                <x-app.school.dashboard.text-pan link="{{ route( 'school.staffroom.candidates' ) }}" :number="$stats['follower_count']" label="Followers"/>
                <x-app.school.dashboard.text-pan link="{{ route( 'school.jobcenter.index' ) }}" :number="$stats['applicant_count']" label="Applicants"/>
                <x-app.school.dashboard.text-pan link="{{ route( 'school.jobcenter.index' ) }}" :number="$stats['hired_count']" label="Hired Applicants"/>
                <x-app.school.dashboard.text-pan link="{{ route( 'school.jobcenter.index' ) }}" :number="$stats['job_count']" label="Jobs"/>
                <x-app.school.dashboard.text-pan :number="0" label="Employer Profile Views"/>
            </div>
        </div>

        {{--Jobs--}}
        <div class="w-full">
            <p class="text-4xl text-gray-500"> Jobs </p>
            <div class="grid lg:grid-cols-3 grid-cols-1 mt-10 gap-5">
{{--                //icon="heroicon-s-pencil"--}}
                <x-app.school.dashboard.text-pan link="{{ route( 'school.jobcenter.index' ) }}" color="green" :number="$stats['total_vacancies']" label="Total Vacancies" />
                <x-app.school.dashboard.text-pan link="{{ route( 'school.campus_profile' ) }}" color="green" :number="$stats['total_staff']" label="Total Staff"/>
                <x-app.school.dashboard.text-pan color="green" number="{{ $stats['staff_req_total_percentage'] }}%" label="Staff Requirements"/>
                <x-app.school.dashboard.text-pan color="green" number="{{ $stats['teaching_vacancies'] }}" label="Teaching Vacancies"/>
                <x-app.school.dashboard.text-pan link="{{ route( 'school.campus_profile' ) }}" color="green" number="{{ $stats['teaching_staff'] }}" label="Teaching staff"/>
                <x-app.school.dashboard.text-pan color="green" number="{{ $stats['staff_req_teacher_percentage'] }}%" label="Teachers"/>
                <x-app.school.dashboard.text-pan color="green" number="{{ $stats['non_teaching_vacancies'] }}" label="Non-Teaching Vacancies"/>
                <x-app.school.dashboard.text-pan link="{{ route( 'school.campus_profile' ) }}" color="green" number="{{ $stats['non_teaching_staff'] }}" label="Non-Teaching"/>
                <x-app.school.dashboard.text-pan color="green" number="{{ $stats['staff_req_non_teacher_percentage'] }}%" label="Non-Teaching Staff"/>
            </div>
            <div class="mt-10 grid lg:grid-cols-5 grid-cols-1 gap-5">
                <x-chart.pie-chart title="Reasons for Vacancies" id="job_chart_1" theme="green" chart_data="[27.8, 11.1, 16.7, 5.6, 38.9]" label_data='["Enrollment","Retirement","Relocation","Termination", "Promotion"]' />
                <x-chart.pie-chart title="Jobs by Area" id="job_chart_2" theme="green" chart_data="[45.5, 18.2, 27.3, 9.1]" label_data='["Teaching", "Non Teaching", " Middle Management", "Senior Leadership"]' />
                <x-chart.pie-chart title="Jobs by FTE" id="job_chart_3" theme="green" chart_data="[88.2, 11.8]" label_data='["Full Time", "Part Time"]' />
                <x-chart.pie-chart title="Teaching Jobs by Subject" id="job_chart_4" theme="green" chart_data="[29.4, 11.8, 17.6, 5.9, 11.8, 17.6, 5.9]" label_data='["Mathematics", "Science", "English", "Humanities", "Arts", "Design", "IT"]' />
                <x-chart.pie-chart title="Jobs by Type" id="job_chart_5" theme="green" chart_data="[31.3, 12.5, 18.8, 12.5, 25]" label_data='["Permanent", "12 Month Contract", "Term Contract", "Semester Contract", "3 Term Contract"]' />
            </div>
        </div>

        {{--Applicants--}}
        <div>
            <p class="text-4xl text-gray-500"> Applicants </p>
            <div class="mt-5 flex flex-col gap-5">
                <div class="flex lg:flex-row flex-col lg:items-center text-2xl text-gray-500 w-full border-b-2 border-gray-300 lg:h-16">
                    <p class="lg:w-1/3 w-full">Top job boards by usage</p>
                    <div class="flex lg:flex-row flex-col lg:w-2/3 w-full lg:gap-0 gap-3 lg:my-0 my-5">
                        <div class="w-1/3 flex items-center gap-2">1.<img src="{{ asset('assets/app/sites/seek-icon.svg') }}" class="w-12 h-12 object-contain" />Seek</div>
                        <div class="w-1/3 flex items-center gap-2">2.<img src="{{ asset('assets/app/sites/employ-icon.svg') }}" class="w-12 h-12 object-contain" />Employo</div>
                        <div class="w-1/3 flex items-center gap-2">3.<img src="{{ asset('assets/app/sites/indeed-icon.svg') }}" class="w-12 h-12 object-contain" />indeed</div>
                    </div>
                </div>
                <div class="flex lg:flex-row flex-col lg:items-center text-2xl text-gray-500 w-full border-b-2 border-gray-300 lg:h-16">
                    <p class="lg:w-1/3 w-full">Top jobboards by usage (Teaching)</p>
                    <div class="flex lg:flex-row flex-col lg:w-2/3 w-full lg:gap-0 gap-3 lg:my-0 my-5">
                        <div class="w-1/3 flex items-center gap-2">1.<img src="{{ asset('assets/app/sites/seek-icon.svg') }}" class="w-12 h-12 object-contain" />Seek</div>
                        <div class="w-1/3 flex items-center gap-2">2.<img src="{{ asset('assets/app/sites/employ-icon.svg') }}" class="w-12 h-12 object-contain" />Employo</div>
                        <div class="w-1/3 flex items-center gap-2">3.<img src="{{ asset('assets/app/sites/teachers-on-net-icon.svg') }}" class="w-12 h-12 object-contain" />Teachers on Net</div>
                    </div>
                </div>
                <div class="flex lg:flex-row flex-col lg:items-center text-2xl text-gray-500 w-full border-b-2 border-gray-300 lg:h-16">
                    <p class="lg:w-1/3 w-full">Top job boards by usage(Non-Teaching)</p>
                    <div class="flex lg:flex-row flex-col lg:w-2/3 w-full lg:gap-0 gap-3 lg:my-0 my-5">
                        <div class="w-1/3 flex items-center gap-2">1.<img src="{{ asset('assets/app/sites/indeed-icon.svg') }}" class="w-12 h-12 object-contain" />Indeed</div>
                        <div class="w-1/3 flex items-center gap-2">2.<img src="{{ asset('assets/app/sites/employ-icon.svg') }}" class="w-12 h-12 object-contain" />Employo</div>
                        <div class="w-1/3 flex items-center gap-2">3.<img src="{{ asset('assets/app/sites/seek-icon.svg') }}" class="w-12 h-12 object-contain" />Seek</div>
                    </div>
                </div>
                <div class="flex lg:flex-row flex-col lg:items-center text-2xl text-gray-500 w-full border-b-2 border-gray-300 lg:h-16">
                    <p class="lg:w-1/3 w-full">Top job boards by applicants</p>
                    <div class="flex lg:flex-row flex-col lg:w-2/3 w-full lg:gap-0 gap-3 lg:my-0 my-5">
                        <div class="w-1/3 flex items-center gap-2">1.<img src="{{ asset('assets/app/sites/employ-icon.svg') }}" class="w-12 h-12 object-contain" />Employo</div>
                        <div class="w-1/3 flex items-center gap-2">2.<img src="{{ asset('assets/app/sites/seek-icon.svg') }}" class="w-12 h-12 object-contain" />Seek</div>
                        <div class="w-1/3 flex items-center gap-2">3.<img src="{{ asset('assets/app/sites/linkedin-icon.svg') }}" class="w-12 h-12 object-contain" />LinkedIn</div>
                    </div>
                </div>
                <div class="flex lg:flex-row flex-col lg:items-center text-2xl text-gray-500 w-full border-b-2 border-gray-300 lg:h-16">
                    <p class="lg:w-1/3 w-full">Top job boards by applicants(Teaching)</p>
                    <div class="flex lg:flex-row flex-col lg:w-2/3 w-full lg:gap-0 gap-3 lg:my-0 my-5">
                        <div class="w-1/3 flex items-center gap-2">1.<img src="{{ asset('assets/app/sites/employ-icon.svg') }}" class="w-12 h-12 object-contain" />Employo</div>
                        <div class="w-1/3 flex items-center gap-2">2.<img src="{{ asset('assets/app/sites/seek-icon.svg') }}" class="w-12 h-12 object-contain" />Seek</div>
                        <div class="w-1/3 flex items-center gap-2">3.<img src="{{ asset('assets/app/sites/edhq-icon.svg') }}" class="w-12 h-12 object-contain" />EdHQ</div>
                    </div>
                </div>
                <div class="flex lg:flex-row flex-col lg:items-center text-2xl text-gray-500 w-full border-b-2 border-gray-300 lg:h-16">
                    <p class="lg:w-1/3 w-full">Top job boards by applicants(Non-Teaching)</p>
                    <div class="flex lg:flex-row flex-col lg:w-2/3 w-full lg:gap-0 gap-3 lg:my-0 my-5">
                        <div class="w-1/3 flex items-center gap-2">1.<img src="{{ asset('assets/app/sites/indeed-icon.svg') }}" class="w-12 h-12 object-contain" />indeed</div>
                        <div class="w-1/3 flex items-center gap-2">2.<img src="{{ asset('assets/app/sites/seek-icon.svg') }}" class="w-12 h-12 object-contain" />Seek</div>
                        <div class="w-1/3 flex items-center gap-2">3.<img src="{{ asset('assets/app/sites/sports-people-icon.svg') }}" class="w-12 h-12 object-contain" />SportsPeople</div>
                    </div>
                </div>
            </div>
            <div class="mt-10 grid lg:grid-cols-5 grid-cols-1 gap-5">
                <x-chart.pie-chart title="Job Board by Usage" id="applicant_chart_1" theme="blue" chart_data="[18.8, 26.6, 4.7, 15.6, 3.1, 4.7, 26.6]" label_data='["Seek", "SchoolHouse", "TON", "Indeed", "University-State", "University-National", "EducationHQ"]' />
                <x-chart.pie-chart title="Job Board by Cost" id="applicant_chart_2" theme="blue" chart_data="[18.8, 26.6, 4.7, 15.6, 3.1, 4.7, 26.6]" label_data='["Seek", "SchoolHouse", "TON", "Indeed", "University-State", "University-National", "EducationHQ"]' />
                <x-chart.pie-chart title="Job Board by Applicant" id="applicant_chart_3" theme="blue" chart_data="[18.8, 26.6, 4.7, 15.6, 3.1, 4.7, 26.6]" label_data='["Seek", "SchoolHouse", "TON", "Indeed", "University-State", "University-National", "EducationHQ"]' />
                <x-chart.pie-chart title="Job Board by Interview" id="applicant_chart_4" theme="blue" chart_data="[20.7, 34.5, 10.3, 13.8, 3.4, 6.9, 10.3]" label_data='["Seek", "SchoolHouse", "TON", "Indeed", "University-State", "University-National", "EducationHQ"]' />
                <x-chart.pie-chart title="Job Board by Hire" id="applicant_chart_5" theme="blue" chart_data="[47.1, 35.3, 11.8, 5.9]" label_data='["Seek", "SchoolHouse", "Indeed", "EducationalHQ"]' />
            </div>
        </div>

        {{-- Financials --}}
        <div>
            <p class="text-4xl text-gray-500"> Financials </p>
            <div class="mt-10 grid lg:grid-cols-3 grid-cols-1 lg:gap-y-5 gap-y-2 gap-x-2 text-2xl">
                <div class="h-24 flex items-center justify-center bg-gray-100 text-gray-500">Total Advertising Cost</div>
                <div class="h-24 flex items-center justify-center bg-gray-100 text-gray-500">$15,000.00</div>
                <div class="h-24 flex items-center justify-center bg-gray-100 text-gray-500 lg:mb-0 mb-8">–12% Year on Year</div>
                <div class="h-24 flex items-center justify-center bg-gray-100 text-gray-500">Advertising Cost – Teaching</div>
                <div class="h-24 flex items-center justify-center bg-gray-100 text-gray-500">$8,000.00</div>
                <div class="h-24 flex items-center justify-center bg-gray-100 text-gray-500 lg:mb-0 mb-8">–12% Year on Year</div>
                <div class="h-24 flex items-center justify-center bg-gray-100 text-gray-500">Advertising Cost – Non-Teaching</div>
                <div class="h-24 flex items-center justify-center bg-gray-100 text-gray-500">$7,000.00</div>
                <div class="h-24 flex items-center justify-center bg-gray-100 text-gray-500 lg:mb-0 mb-8">–12% Year on Year</div>

            </div>
            <div class="my-10 grid lg:grid-cols-4 grid-cols-1 gap-5">
                <x-chart.pie-chart title="Job Board by Usage" id="finance_chart_1" theme="black" chart_data="[18.8, 26.6, 4.7, 15.6, 3.1, 4.7, 26.6]" label_data='["Seek", "SchoolHouse", "TON", "Indeed", "University-State", "University-National", "EducationHQ"]' />
                <x-chart.pie-chart title="Job Board by Cost" id="finance_chart_2" theme="black" chart_data="[63.2, 36.8]" label_data='["PAID", "Free"]' />
                <x-chart.pie-chart title="Job Board by Applicant" id="finance_chart_3" theme="black" chart_data="[33.6, 4.5, 22.7, 13.6, 25.5]" label_data='["SchoolHouse", "EducationalHQ", "Linkedin", "Facebook", "Indeed"]' />
                <x-chart.pie-chart title="Job Board by Interview" id="finance_chart_4" theme="black" chart_data="[28.7, 16.7, 22.2, 11.1, 22.2]" label_data='["SchoolHouse", "EducationalHQ", "LinkedIn", "Facebook", "Indeed"]' />
            </div>
        </div>
    </div>
</div>
