<div class="flex flex-col">
    <!-- label -->
    @if($label)
        <label class="block mb-2 text-sm font-bold text-secondary">{{ $label }}</label>
    @endif

    <div wire:ignore>
        <div id="editor_{{ $id }}" class="h-96">
            {!! $value !!}
        </div>
    </div>

    @if( $error )
        <div class="text-red-500 text-sm mt-2">
            {{ $error }}
        </div>
    @endif

</div>

@script
<script>
    const quill = new Quill('#editor_{{ $id }}', {
        theme: 'snow',
        placeholder: '{{ $placeholder }}'
    });

    quill.on('blur', function () {
        $wire.set('value', quill.root.innerHTML );
    });

    $wire.$watch('value', value => {
        quill.root.innerHTML = value;
    });
</script>
@endscript
