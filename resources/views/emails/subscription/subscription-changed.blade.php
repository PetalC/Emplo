<x-mail::message>
# School Subscription Changed.

The school {{ $school->name }} has modified their subscription.

@if( $previous_subscription )
### Old Subscription Details
<x-mail::table>
| Subscription Plan                        | Start Date                                                  | End Date                                                       |
|:---------------------------------------- |:----------------------------------------------------------- |:-------------------------------------------------------------- |
| {{ $previous_subscription->plan->name }} | {{ $previous_subscription->started_at->format( 'Y-m-d' ) }} | {{ $previous_subscription->suppressed_at->format( 'Y-m-d' ) }} |
</x-mail::table>
@endif

### New Subscription Details
<x-mail::table>
| Subscription Plan                       | Start Date                                                 | Expiry Date                                                |
|:--------------------------------------- |:---------------------------------------------------------- |:---------------------------------------------------------- |
| {{ $school->subscription->plan->name }} | {{ $school->subscription->started_at->format( 'Y-m-d' ) }} | {{ $school->subscription->expired_at->format( 'Y-m-d' ) }} |
</x-mail::table>

<x-mail::button :url="route( 'nova.pages.detail', [ 'resource' => 'school', 'resourceId' => $school->id ] )">
View School Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
