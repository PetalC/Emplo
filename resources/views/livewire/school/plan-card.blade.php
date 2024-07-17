<div class="grid grid-rows-subgrid col-span-1 row-span-12" style="grid-auto-rows: minmax(30px, auto);">
    <div class="row-span-8 flex flex-col items-center gap-6 border rounded-lg border-app p-4">

        @if( $icon )
            <div class="w-24 h-24 rounded-full border flex justify-center items-center">
                <x-icon name="heroicon-s-{{ $icon }}" class="w-12 h-12 bg-[transparent] text-primary"/>
            </div>
        @endif

        <p class="text-2xl text-primary">
            {{ $plan->name }}
        </p>

        <div class="w-full flex flex-col gap-2 items-center divide-y divide-gray-300">
            @foreach( $plan->features as $feature )
                <p class="w-full text-center text-sm lg:text-md leading-relaxed pt-2 {{ $previous_features->isEmpty() || $previous_features->contains( $feature ) ? 'text-app' : 'text-primary' }}">
                    @if( (float)$feature->pivot->charges > 0 && $feature->name != 'Multi-User' ) {{ number_format( $feature->pivot->charges, 0 ) }} @endif
                    {{ ( $feature->pivot_charges > 1 && $feature->name != 'Multi-User' ) ? 'x' : '' }}
                    {{ $feature->name }}</p>
            @endforeach
        </div>

    </div>
    <div class="grid w-full mt-2 items-center row-span-1">
        @if( $active )
            <x-buttons.primary disabled :shadow="false" class="w-full flex flex-col justify-center h-full hover:opacity-100">
                <p class="m-0 p-0 text-lg">{{ __('Current Plan') }}</p>
                <p class="m-0 p-0 text-xs">Expires, {{ $subscription->expired_at->format('F Y') }}</p>
            </x-buttons.primary>
        @elseif( $plan->order < $subscription?->plan?->order ?? 0 )
            <x-buttons.dark @click="$wire.$parent.call( 'switchPlan', {{ $plan->id  }} )" :shadow="false" size="lg" class="w-full flex flex-col h-full justify-center">
                <p class="m-0 p-0 text-md lg:text-lg">{{ __('Downgrade') }}</p>
            </x-buttons.dark>
        @else
            <x-buttons.primary @click="$wire.$parent.call( 'switchPlan', {{ $plan->id  }} )" :shadow="false" size="lg" class="w-full flex flex-col h-full justify-center">
                <p class="m-0 p-0 text-md lg:text-lg">{{ __('Upgrade') }}</p>
            </x-buttons.primary>
        @endif
    </div>
    <div class="text-center mt-8 row-span-3">
        <p class="text-md font-bold text-gray-700 text-lg">{{ $plan->price }}</p>
        @if( $plan->retail_price )
            <p class="text-md font-bold text-red-500 text-lg">{{ $plan->retail_price }}</p>
        @endif
        <p class="text-app mt-8">{{ $plan->description }}</p>
    </div>

</div>
