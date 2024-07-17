@if($map)
    {{-- render map if map is true --}}
    [MAP of school address here]
@endif

@if($school->address)
    <p>
        {{ $school->address }} map your commute
    </p>
@endif
