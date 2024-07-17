@props([
    'campus_profile'
])

<div>

    @if( $campus_profile )

        <div class="max-w-8xl mx-auto px-20 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 2xl:grid-cols-9 lg:gap-14 gap-24 lg:w-full">
            <x-app.school.public.info_badge icon="school.enrollments_count" label="Enrollments" data="{{ $campus_profile->student_enrollments }}"/>
            <x-app.school.public.info_badge icon="school.staff_count" label="Staff" data="{{ $campus_profile->staff_size }}"/>
            <x-app.school.public.info_badge icon="school.teachers_count" label="Teachers" data="{{ $campus_profile->teacher_size }}"/>
            <x-app.school.public.info_badge icon="school.sector_count" label="Sector" data="{{ join( ' & ' , $campus_profile->sectors()->get()->pluck( 'name' )->toArray() ) }}"/>
            <x-app.school.public.info_badge icon="school.curricula" label="Curriculum" data="{{ join( ' & ' , $campus_profile->curricula()->get()->pluck( 'name' )->toArray() ) }}"/>
            <x-app.school.public.info_badge icon="school.ethos" label="Ethos" data="{{ join( ' & ' , $campus_profile->religions()->get()->pluck( 'name' )->toArray() ) }}"/>
            <x-app.school.public.info_badge icon="school.areas" label="Areas" data="{{ join( ' & ' , $campus_profile->location_types()->get()->pluck( 'name' )->toArray() ) }}"/>
            <x-app.school.public.info_badge icon="school.type" label="School Type" data="{{ join( ' & ' , $campus_profile->school_types()->get()->pluck( 'name' )->toArray() ) }}"/>
            <x-app.school.public.info_badge icon="school.gender" label="Gender" data="{{ join( ' & ' , $campus_profile->genders()->get()->pluck( 'name' )->toArray() ) }}"/>
        </div>

    @endif

</div>
