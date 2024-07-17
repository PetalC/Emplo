@php
$textLargeHeadingComponentString = htmlspecialchars_decode('<x-text.heading variant="h1">Large heading</x-text.heading>');
$textSecondaryHeadingComponentString = htmlspecialchars_decode('x-text.heading variant="h3">Secondary heading</x-text.heading>');
$textTertiaryHeadingComponentString = htmlspecialchars_decode('<x-text.heading variant="h5">Tertiary heading</x-text.heading>');
$textParagraphComponentString = htmlspecialchars_decode('<x-p>Body copy</x-p>');
$textPrimaryButtonComponentString = htmlspecialchars_decode('<x-button.primary>Primary Button</x-button.primary>');
$textSecondaryButtonComponentString = htmlspecialchars_decode('<x-button.secondary>Secondary Button</x-button.secondary>');
$textOutlineButtonComponentString = htmlspecialchars_decode('<x-button.outline>Outline Button</x-button.outline>');
$textDialogComponentString = htmlspecialchars_decode('<x-dialog>Dialog</x-dialog>');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'EMPLO' }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://use.typekit.net/xjv3llh.css">

        <!-- Styles -->
        @livewireStyles
        @vite('resources/css/app.css')

        <!-- Scripts -->
        @vite('resources/js/app.js')

        @stack('script')
        @stack('head')
    </head>

    <body class="font-app flex h-full flex-col bg-white antialiased">
        <div class="flex min-h-full">

            <div class="mx-auto max-w-7xl my-10">
                <h3 class="text-3xl font-bold">UI Elements</h3>

                <div class="flex flex-col gap-4 mt-6">
                    <h4 class="text-xl">1. Heading Elements</h4>

                    <!-- 1.1. Large -->
                    <div class="flex flex-col gap-2">
                        <h5>1.1. Large</h5>

                        <div class="inline-flex items-center justify-start text-sm text-slate-300 bg-gray-800 p-5 my-4 rounded-2xl">
                            {{ $textLargeHeadingComponentString }}
                        </div>

                        <x-text.heading variant="h1">Large heading</x-text.heading>
                    </div>

                    <!-- 1.2. Secondary -->
                    <div class="flex flex-col gap-2">
                        <h5>1.2. Secondary</h5>

                        <div class="inline-flex items-center justify-start text-sm text-slate-300 bg-gray-800 p-5 my-4 rounded-2xl">
                            {{ $textSecondaryHeadingComponentString }}
                        </div>

                        <x-text.heading variant="h3">Secondary heading</x-text.heading>
                    </div>

                    <!-- 1.3. Tertiary -->
                    <div class="flex flex-col gap-2">
                        <h5>1.3. Tertiary</h5>

                        <div class="inline-flex items-center justify-start text-sm text-slate-300 bg-gray-800 p-5 my-4 rounded-2xl">
                            {{ $textTertiaryHeadingComponentString }}
                        </div>

                        <x-text.heading variant="h5">Tertiary heading</x-text.heading>
                    </div>
                </div>

                <div class="flex flex-col gap-4 mt-6">
                    <h4 class="text-xl">2. Paragraph</h4>

                    <div class="inline-flex items-center justify-start text-sm text-slate-300 bg-gray-800 p-5 my-4 rounded-2xl">
                        {{ $textParagraphComponentString }}
                    </div>

                    <x-p>Body copy</x-p>
                </div>

                <div class="flex flex-col gap-4 mt-6">
                    <h4 class="text-xl">3. Buttons</h4>

                    <!-- 3.1. Primary -->
                    <div class="flex flex-col gap-2">
                        <h5>3.1. Primary</h5>

                        <div class="inline-flex items-center justify-start text-sm text-slate-300 bg-gray-800 p-5 my-4 rounded-2xl">
                            {{ $textPrimaryButtonComponentString }}
                        </div>

                        <x-button.primary>Primary Button</x-button.primary>
                    </div>

                    <!-- 3.2. Secondary -->
                    <div class="flex flex-col gap-2">
                        <h5>3.2. Secondary</h5>

                        <div class="inline-flex items-center justify-start text-sm text-slate-300 bg-gray-800 p-5 my-4 rounded-2xl">
                            {{ $textSecondaryButtonComponentString }}
                        </div>

                        <x-button.secondary>Secondary Button</x-button.secondary>
                    </div>

                    <!-- 3.3. Outline -->
                    <div class="flex flex-col gap-2">
                        <h5>3.3. Outline</h5>

                        <div class="inline-flex items-center justify-start text-sm text-slate-300 bg-gray-800 p-5 my-4 rounded-2xl">
                            {{ $textOutlineButtonComponentString }}
                        </div>

                        <x-button.outline>Outline Button</x-button.outline>
                    </div>
                </div>

                <div class="flex flex-col gap-4 mt-6">
                    <h4 class="text-xl">5. Dialog</h4>

                    <div class="inline-flex items-center justify-start text-sm text-slate-300 bg-gray-800 p-5 my-4 rounded-2xl">
                        {{ $textDialogComponentString }}
                    </div>

                    <x-dialog>Dialog</x-dialog>
                </div>

                <div class="flex flex-col gap-4 mt-6">
                    <h4 class="text-xl">6. Select Dropdown Elements</h4>

                    <!-- 6.1. Primary -->
                    <div class="flex flex-col gap-2">
                        <h5>6.1. Primary</h5>

                        <div class="inline-flex items-center justify-start text-sm text-slate-300 bg-gray-800 p-5 my-4 rounded-2xl">
                            {{ $textPrimaryButtonComponentString }}
                        </div>

                        <x-select.only-icon label="Position" icon="heroicon-o-book-open" :options="['Option 1', 'Option 2']" />
                    </div>
                </div>

                <div class="flex flex-col gap-4 mt-6 py-6">
                    <h4 class="text-xl">7. Input</h4>

                    <!-- 7.2. Outline -->
                    <div class="flex flex-col gap-2">
                        <h5>7.2. Primary</h5>

                        <div class="inline-flex items-center justify-start text-sm text-slate-300 bg-gray-800 p-5 my-4 rounded-2xl">
                            {{ $textPrimaryButtonComponentString }}
                        </div>

                        <x-input.outline id="outline" name="outline" label="Outline" placeholder="Placeholder" />
                    </div>

                    <!-- 7.3. Textarea -->
                    <div class="flex flex-col gap-2">
                        <h5>7.3. Textarea</h5>

                        <div class="inline-flex items-center justify-start text-sm text-slate-300 bg-gray-800 p-5 my-4 rounded-2xl">
                            {{ $textPrimaryButtonComponentString }}
                        </div>

                        <x-input.textarea id="textarea" name="textarea" label="Textarea" placeholder="Textarea placeholder" />
                    </div>

                    <!-- 7.4. Slider -->
                    <div class="flex flex-col gap-2">
                        <h5>7.4. Slider</h5>

                        <div class="inline-flex items-center justify-start text-sm text-slate-300 bg-gray-800 p-5 my-4 rounded-2xl">
                            {{ $textPrimaryButtonComponentString }}
                        </div>

                        <x-input.slider id="slider" name="slider" min="0" max="100" />
                    </div>
                </div>
            </div>
            @stack('scripts')
            @livewireScripts
        </div>
    </body>
</html>
