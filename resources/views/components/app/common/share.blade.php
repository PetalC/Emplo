@props(['url'])
<div x-data="{ open: false }" class="relative">

    <div>
        <x-icons.arrow-right class="w-6 h-6 text-gray-200" @click.stop="open = !open" />
    </div>

    <div @click.away="open = false" x-show="open"
         class="sharing-buttons flex gap-4 absolute top-[100%] left-1/2 translate-y-2 -translate-x-1/2 z-20 p-4 border border-gray-100 shadow-md rounded bg-white"
         x-cloak>
        <a class="duration-200 ease inline-flex items-center mb-1 mr-1 transition p-2 rounded-full bg-school_primary hover:opacity-80" target="_blank" rel="noopener" href="https://facebook.com/sharer/sharer.php?u={{ urlencode( $url ) }}" aria-label="Share on Facebook">
            <x-icon name="iconoir-facebook" class="w-6 h-6 fill-white text-white" />
        </a>
        <a class="duration-200 ease inline-flex items-center mb-1 mr-1 transition p-2 rounded-full text-white bg-school_primary hover:opacity-80" target="_blank" rel="noopener" href="https://twitter.com/intent/tweet?url={{ urlencode( $url ) }}" aria-label="Share on Twitter">
            <x-icon name="iconoir-x" class="w-6 h-6 fill-white" />
        </a>
        <a class="duration-200 ease inline-flex items-center mb-1 mr-1 transition p-2 rounded-full text-white bg-school_primary hover:opacity-80" target="_blank" rel="noopener" href="https://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode( $url ) }}" aria-label="Share on Linkedin">
            <x-icon name="iconoir-linkedin" class="w-6 h-6 fill-none" />
        </a>
    </div>

</div>


