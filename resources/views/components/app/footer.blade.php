<footer class="flex flex-col pl-0 text-gray-700 divide-y divide-gray-300 bg-stone-100 sm:pl-10 lg:pl-0">
    <div class="flex flex-col pl-10 sm:pl-0">
        <div class="flex flex-col gap-10 py-10 max-w-7xl lg:mx-auto">
            <h3 class="text-xl">Resources</h3>

            <div class="grid grid-cols-1 gap-10 text-sm lg:grid-cols-3">
                <div class="flex flex-col gap-4">
                    <h5 class="font-semibold">Tools</h5>

                    <div class="grid grid-cols-1 gap-10 lg:grid-cols-2">
                        <div class="flex flex-col gap-4">
                            <x-app.foot-menu href="{{ route( 'search' ) }}">Search jobs</x-app.foot-menu>
                            <x-app.foot-menu href="{{ route( 'search', [ 'schools' => 'true' ] ) }}">Search schools</x-app.foot-menu>
                            <x-app.foot-menu href="{{ route( 'search', [ 'schools' => 'true' ] ) }}">Follow schools</x-app.foot-menu>
                        </div>

                        <div class="flex flex-col gap-4">
                            <x-app.foot-menu href="{{ route( 'search' ) }}">Apply for a job</x-app.foot-menu>
{{--                            <x-app.foot-menu>Speak with recruiter</x-app.foot-menu>--}}
                            <x-app.foot-menu href="{{ route( 'contact' ) }}">General enquiry</x-app.foot-menu>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <h5 class="font-semibold">Candidates</h5>

                    <div class="grid grid-cols-1 gap-10 lg:grid-cols-2">
                        <div class="flex flex-col gap-4">
                            <x-app.foot-menu class="opacity-50 cursor-not-allowed">Career path advice</x-app.foot-menu>
                            <x-app.foot-menu class="opacity-50 cursor-not-allowed">Resume preparation</x-app.foot-menu>
                            <x-app.foot-menu class="opacity-50 cursor-not-allowed">Interviewing advice</x-app.foot-menu>
                        </div>

                        <div class="flex flex-col gap-4">
                            <x-app.foot-menu class="opacity-50 cursor-not-allowed">Online resources</x-app.foot-menu>
                            <x-app.foot-menu class="opacity-50 cursor-not-allowed">Government resources</x-app.foot-menu>
                            <x-app.foot-menu href="{{ route( 'contact' ) }}">Contact us</x-app.foot-menu>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <h5 class="font-semibold">Schools</h5>

                    <div class="grid grid-cols-1 gap-10 lg:grid-cols-2">
                        <div class="flex flex-col gap-4">
                            <x-app.foot-menu class="opacity-50 cursor-not-allowed" disabled>Speak with Software Specialists</x-app.foot-menu>
                            <x-app.foot-menu class="opacity-50 cursor-not-allowed">Job Description templates</x-app.foot-menu>
                            <x-app.foot-menu class="opacity-50 cursor-not-allowed">Interviewing formats</x-app.foot-menu>
                        </div>

                        <div class="flex flex-col gap-4">
                            <x-app.foot-menu href="{{ route( 'contact' ) }}">Legal checks</x-app.foot-menu>
                            <x-app.foot-menu href="{{ route( 'contact' ) }}">Contact us</x-app.foot-menu>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col pl-10 sm:pl-0">
        <div class="grid w-full grid-cols-1 gap-10 py-10 mx-auto text-sm max-w-7xl lg:grid-cols-4">
            <div class="flex flex-col gap-4">
                <h5 class="font-semibold">Quick links</h5>

                <div class="flex flex-col gap-4">
                    <x-app.foot-menu href="{{ route( 'auth' ) }}">Signin</x-app.foot-menu>
                    <x-app.foot-menu href="{{ route( 'auth' ) }}">Signup</x-app.foot-menu>
                    <x-app.foot-menu href="{{ route( 'about' ) }}">About Employo</x-app.foot-menu>
                    <x-app.foot-menu href="{{ route( 'contact' ) }}">Contact us</x-app.foot-menu>
                    <x-app.foot-menu href="{{ route( 'be_careful' ) }}">Be Careful</x-app.foot-menu>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <h5 class="font-semibold">Candidates</h5>

                <div class="flex flex-col gap-4">
                    <x-app.foot-menu href="{{ route( 'search', [ 'school' => true ] ) }}">Find your dream school</x-app.foot-menu>
{{--                    <x-app.foot-menu>Register with our recruiters</x-app.foot-menu>--}}
                    <x-app.foot-menu href="{{ route( 'terms_policy' ) }}">Terms of Use</x-app.foot-menu>
                    <x-app.foot-menu class="opacity-100" href="{{ route('candidate_policy') }}">Privacy Policy</x-app.foot-menu>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <h5 class="font-semibold">Schools</h5>

                <div class="flex flex-col gap-4">
                    <x-app.foot-menu href="{{ route( 'auth' ) }}">Find your dream candidates</x-app.foot-menu>
                    <x-app.foot-menu class="opacity-50 cursor-not-allowed">Pricing & Packages</x-app.foot-menu>
                    <x-app.foot-menu href="{{ route( 'terms_policy' ) }}">Terms & Conditions</x-app.foot-menu>
                    <x-app.foot-menu class="opacity-100" href="{{ route('school_policy') }}">Privacy Policy</x-app.foot-menu>
                </div>
            </div>

            <div class="mx-auto md:mx-0">
                <img class="mx-auto mb-6 max-w-52" src="{{ asset('assets/app/logo.png') }}" class="mx-auto"/>
                <img class="max-w-44 grayscale-[50%] mx-auto" src="{{ asset('assets/app/makers_mark.png') }}" class="mx-auto"/>
            </div>

        </div>

    </div>

    <div class="flex flex-col ml-32 sm:m-auto">
        <div class="flex flex-col-reverse items-center justify-between w-full gap-10 py-4 mx-auto my-12 text-sm max-w-7xl lg:flex-row lg:gap-0 lg:my-0">
            <div class="flex flex-col items-center justify-center gap-2 text-gray-700 lg:flex-row lg:gap-0">
                <p>© {{ date('Y') }} Employo Pty Limited</p>
                <div class="flex">
                    <span class="hidden mx-2 lg:block">•</span>
                    <x-app.foot-menu href="{{ route('candidate_policy') }}">Privacy</x-app.foot-menu>
                    <span class="mx-2 ">•</span>
                    <x-app.foot-menu>Terms</x-app.foot-menu>
                    <span class="hidden mx-2 lg:block">•</span>
                    <x-app.foot-menu class="hidden lg:block">Sitemap</x-app.foot-menu>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <x-app.foot-menu class="flex">
                    <x-heroicon-o-arrow-small-up class="w-5 h-5 mx-2"/>
                    Back to top
                </x-app.foot-menu>

                <div class="flex items-center gap-4">
                    <x-app.foot-menu>
                        <x-icons.facebook class="w-6 h-6"/>
                    </x-app.foot-menu>
                    <x-app.foot-menu>
                        <x-icons.linkedin class="w-6 h-6"/>
                    </x-app.foot-menu>
                    <x-app.foot-menu>
                        <x-icons.facebook class="w-6 h-6"/>
                    </x-app.foot-menu>
                </div>
            </div>
        </div>
    </div>
</footer>
