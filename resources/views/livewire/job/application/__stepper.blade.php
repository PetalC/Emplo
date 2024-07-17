<div class="rounded-xl border-2 border-gray-200 p-4 mb-6">

    <x-text.heading class="!text-4xl text-center mt-6 mb-10" variant="h3">Job Application</x-text.heading>

    @if( $application_complete )

        <div class="flex flex-col gap-5 justify-center px-16 py-16 text-center">
            <x-icon name="heroicon-c-check-circle" class="w-20 h-20 text-primary cursor-pointer mx-auto" />
            <x-text.heading variant="h5">You have applied for a <span class="font-bold">{{ $job->title }}</span> position at <span class="font-bold">{{ $job->school->name }}</span></x-text.heading>
            <x-text.heading variant="h5">Good luck with your application.</x-text.heading>
        </div>

    @else



        <div class="px-10">
            <x-dynamic-component :component="'app.job.application.steps.' . $active_component . '-step'"
                                 :job="$job"
                                 :application_id="$application_id"
                                 :references="$references"
                                 :min_references="$min_references"
                                 :documents="$documents"
                                 :school_documents="$school_documents"
            />
        </div>

        @if($showSaveDetails)
            <div class="px-10 py-10 md:col-span-12 flex flex-col gap-10">
                <x-input.checkbox id="save_details" name="save_details" :value="true" label="Save my details for future job applications" wire:model.blur="save_details" />
                @error('save_details')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
        @endif

{{--        @if( $current_component + 1 == count( $steps ) )--}}
{{--            <div class="g-recaptcha" --}}
{{--                data-sitekey="reCAPTCHA_site_key" --}}
{{--                data-callback='onSubmit' --}}
{{--                data-action='submit'>Submit</div>--}}
{{--            @error('captcha')--}}
{{--                <span class="text-red-500">{{ $message }}</span>--}}
{{--            @enderror--}}
{{--        @endif--}}

        <div class="pt-6 pb-4 border-t bg-theme-light flex flex-row justify-center items-center md:gap-5 md:col-span-12">
            <div class="flex flex-col items-center md:flex-row md:gap-5 md:p-0">
                @if( $current_component > 1 )
                    <x-buttons.secondary :shadow="false" size="lg" wire:click="previousComponent" wire:loading.attr="disabled" class="mt-5 md:mt-0">
                        <span wire:loading wire:target="previousComponent">Wait...</span>
                        <span wire:loading.remove wire:target="previousComponent">{{ $previousTitle }}</span>
                    </x-buttons.secondary>
                @endif
                @if( $current_component < count( $steps ) )
                    <x-buttons.primary :shadow="false" type="submit" size="lg" wire:click="nextComponent" wire:loading.attr="disabled" class="mt-5 md:mt-0 md:col-start-5 md:col-span-1">
                        <span wire:loading wire:target="nextComponent">Wait...</span>
                        <span wire:loading.remove wire:target="nextComponent">{{ $nextTitle }}</span>
                    </x-buttons.primary>
                @endif
        </div>

    @endif

</div>

@push( 'script' )
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        window.handleCaptcha = function(e) {

            let widget = grecaptcha.render('captcha', {
                'sitekey': '{{ env('RECAPTCHA_SITE_KEY') }}',
                'theme': 'light', // you could switch between dark and light mode.
                'callback': function( response ){
                    @this.set('captcha', response);
                    @this.$refresh();
                }
            });

            if( document.getElementById('captcha') ) {
                let widget = grecaptcha.render('captcha', {
                    'sitekey': '{{ env('RECAPTCHA_SITE_KEY') }}',
                    'theme': 'light', // you could switch between dark and light mode.
                    'callback': function( response ){
                        @this.set('captcha', response);
                        @this.$refresh();
                    }
                });

                @this.$on('refresh-captcha', () => {
                    grecaptcha.reset(widget);
                } );

            }
        }
    </script>
@endpush
