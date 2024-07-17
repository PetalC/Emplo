<x-public-layout :green="false">
    <x-app.common.page_header>
        <x-slot:column_left>
            <x-app.school.avatar :campus="$application->job->campus" />
        </x-slot:column_left>

        <x-text.heading class="text-center text-gray-700" variant="h1">Nominate References</x-text.heading>
        <x-text.heading class="mt-6" variant="h3">{{ $application->user->name }}</x-text.heading>
        <x-text.heading class="mt-2" variant="h5">{{ \Carbon\Carbon::now()->format('d M Y') }}</x-text.heading>
    </x-app.common.page_header>

    <livewire:application.references.nominate :application="$application" />
</x-public-layout>
