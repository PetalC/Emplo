@props([
    'progress' => '1'
])

<div class="flex items-center text-app">
    <div class="z-[1]">
        <div class="h-5 w-5 rounded-full bg-primary"></div>
        <p class="absolute mt-3 -ml-4">Account</p>
    </div>

   <div class="h-2 -ml-2 rounded-full {{$progress>=2 ? 'bg-primary' : 'bg-gray-200'}}  w-1/2"></div>
   <div class="z-[1]">
        <div class="h-5 -ml-2 w-5 rounded-full {{$progress>=2 ? 'bg-primary' : 'bg-gray-200'}} z-[1]"></div>
        <p class="absolute mt-3 -ml-4">School</p>
    </div>
   
   <div class="h-2 -ml-2 rounded-full {{$progress>=3 ? 'bg-primary' : 'bg-gray-200'}} w-1/2"></div>
   <div class="z-[1]">
        <div class="h-5 -ml-2 w-5 rounded-full {{$progress>=3 ? 'bg-primary' : 'bg-gray-200'}} z-[1]"></div>
        <p class="absolute mt-3 -ml-4">Details</p>
    </div>
</div>