@props([
    'user' => \Illuminate\Support\Facades\Auth::user(),
    'class' => '',
    'img_class' => '',
    'url' => false,
])

<div class="bg-gradient-to-r from-gray-100 to-gray-200 2xl:to-white 2xl:via-gray-200 2xl:to-90% 2xl:via-90% pt-16 pb-12 -mt-6">
    <div class="max-w-7xl mx-auto flex px-0 lg:px-10">
        <p class="text-9xl text-gray-500">"</p>
        <p class="text-app text-3xl ml-3 font-light leading-relaxed">{{ $user->profile->brief }}</p>
    </div>
</div>
