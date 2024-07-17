<div class="w-full">
    <div class="w-full flex lg:flex-row mb-10 justify-center items-center">
        <x-text.heading variant="h5" class="my-0 text-3xl text-gray-500 text-center mr-5">Manage <span class="text-school_primary">Your Plan</span></x-text.heading>
    </div>
    <div class="w-full grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 grid-rows-12 justify-center items-start gap-x-6" style="grid-auto-rows: minmax(30px, auto);">
        @foreach( $plans as $plan )
            @php
                $previous_plan_features = ( $loop->index > 0 ) ? $plans[$loop->index - 1]->features : [];
                $is_active = ( $subscription && ( $subscription->plan->id == $plan->id ) );
            @endphp
            <livewire:school.plan-card wire:key="plan_{{ $plan->id }}" :plan="$plan" :subscription="$subscription" :previous_features="$previous_plan_features" :active="$is_active"/>
        @endforeach
    </div>
</div>
