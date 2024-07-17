<div x-data="{ openRegistrations : false }">
    <div class="flex items-center gap-2 cursor-pointer" @click="openRegistrations = true">
        <div class="p-3">
             <span class="underline">
        @if($user_certifications->isNotEmpty())
                     @foreach($user_certifications as $cert)
                         {{ $cert->certification }}
                     @endforeach
                 @else
                    None
            @endif
              </span>
        </div>
    </div>
    <x-modal
        x-show="openRegistrations"
        x-on:click.outside="openRegistrations = false"
        onClose="openRegistrations = false"
        x-cloak
    >
        <div class="flex flex-col gap-10 items-center">
            <h5 class="text-2xl">Registrations</h5>

            @if($user_certifications->isNotEmpty())
                @foreach($user_certifications as $cert)
                    <div class="p-3 flex flex-col items-center">
                        <div>
                            <strong>Certification:</strong> {{ $cert->certification }}
                        </div>
                        <div>
                            <strong>Is Valid:</strong>
                            @if($cert->is_valid)
                                <x-icon name="heroicon-s-check-circle" class="text-green-500 w-5 h-5 inline"/>
                            @else
                                <x-icon name="heroicon-s-x-circle" class="text-red-500 w-5 h-5 inline"/>
                            @endif
                        </div>
                        <div>
                            <strong>Expiry Date:</strong> {{ $cert->expires_at }}
                        </div>
                        <div>
                            <strong>Certification ID:</strong> {{ $cert->certification_id }}
                        </div>
                    </div>
                @endforeach
            @else
                No Registrations
            @endif

            <x-button.primary @click="openRegistrations = false">Done</x-button.primary>
        </div>
    </x-modal>

</div>
