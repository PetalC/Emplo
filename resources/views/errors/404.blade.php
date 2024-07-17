<x-app-layout>
    <x-slot:title>
        Employo - Not Found
    </x-slot>
    <div class="flex flex-col items-center gap-6">
        <div class="max-w-64 mt-12 mb-12">
            <x-app.logo.logo />
        </div>

        <div class="relative w-32 h-32">
            <x-icon name="lucide-spell-check-2" class="w-32 h-32 text-gray-500 stroke-[0.5px]" />
        </div>
        <p class="text-app font-light text-xl text-center text-gray-900">This is not the classroom you are looking for. Please try again</p>
{{--        <a href="{{ route('auth') }}" class="text-indigo-600 hover:text-indigo-900">Login</a>--}}
    </div>
{{--    <x-app.logo.logo />--}}
{{--    <h1 class="text-4xl font-light text-center text-gray-900">404</h1>--}}
{{--    This is not the classroom you are looking for. <br />--}}
{{--    <a href="{{ route('auth') }}" class="text-indigo-600 hover:text-indigo-900">Login</a>--}}
</x-app-layout>
