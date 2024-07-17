@props([
    'id' => '',
    'name' => '',
    'value' => '',
    'header' => '',
    'label' => '',
    'variant' => 'radio',
])

<li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
    <div class="flex items-center ps-3">
        <input id="{{ $id }}" type="{{ $variant }}" value="{{ $value }}" name="{{ $name }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
        <label for="{{ $id }}" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
            @if(!empty($header))
            <span class='font-bold'>{{ $header }}-</span>
            @endif
            {{ $label }}
        </label>
    </div>
</li>