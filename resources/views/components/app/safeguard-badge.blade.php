@props([
    'verified' => false,
    'label',
    'class' => '',
    'icon_class' => ''
])

<div class="relative flex justify-center items-center w-8 h-8 text-xs font-semibold {{ $class }}">
    <x-icons.shield class="w-8 h-8 {{ $verified ? 'text-school_primary' : 'text-gray-200' }} -z-0 absolute top-0 left-0 {{ $icon_class }}" />
    <div class="relative z-10 pl-[1px] {{ $verified ? 'text-white' : 'text-black' }}">{{$label}}</div>
</div>
