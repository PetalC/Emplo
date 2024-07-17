@props([
    'id',
    'label' => '',
    'disabled' => false,
    'placeholder' => '',
])

<div class="flex flex-col">
    @if($label)
        <label class="block mb-2 text-sm font-bold text-secondary">{{ $label }}</label>
    @endif
    <div id="editor_{{ $id }}" class="h-96" wire:ignore></div>
</div>

@script
<script>
    const quill = new Quill('#editor_{{ $id }}', {
        theme: 'snow',
        placeholder: '{{ $placeholder }}'
    });

    {{--quill.on('text-change', function () {--}}
    {{--    @this.set('{{$attributes->wire('model')->value}}', quill.root.innerHTML);--}}
    {{--});--}}
  {{--const quill = new Quill('#editor_{{$id}}', {--}}
  {{--  theme: 'snow',--}}
  {{--  placeholder: '{{ $placeholder}}'--}}
  {{--});--}}
</script>
@endscript
