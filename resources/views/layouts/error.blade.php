@php use Illuminate\Support\Facades\Auth; @endphp
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset( 'assets/favicon.png' ) }}">

    <title>{{ $title ?? 'EMPLOYO - An Error Has Occurred' }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://use.typekit.net/xjv3llh.css">

    <!-- Styles -->
    @vite('resources/css/app.css')

</head>

<body class="font-app flex h-full flex-col bg-white antialiased">
    <div class="flex min-h-full max-h-full flex-col bg-cover bg-center" style="background-image: url(/assets/app/error_bg.png)">
        <main class="flex justify-center pt-20 xl:pt-80 h-full">
            <div>
                <div class="max-w-56 xl:max-w-80 mx-auto">
                    <a href="{{ route('home') }}">
                        <x-app.logo.logo />
                    </a>
                </div>

                <h2 class="text-4xl xl:text-6xl text-center font-light mt-20 max-w-4xl mx-auto text-gray-400">{{ $message }}</h2>

                {{ $slot ?? '' }}
            </div>
        </main>
    </div>
</body>
</html>
