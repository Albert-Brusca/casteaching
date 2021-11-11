<x-casteaching-layout>
    <div class="flex flex-col h-screen space-x-4 space-y-4 lg:space-x-4 lg:space-y-4 xl:space-x-10 xl:space-y-5
        2xl:space-x-20 2xl:space-y-10">
        <iframe
            class="md:p-3 lg:p-5 xl:px-10 xl:py-5 2xl:px-20 2xl:py-10 h-4/5"
            src="https://www.youtube.com/embed/ednlsVl-NHA"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen></iframe>

        <h2 class="text-gray-900 uppercase font-bold text-2xl tracking-tight">
            {{ $video->title }}
        </h2>
        <div>
            {{ $video->description }}
        </div>

    </div>
</x-casteaching-layout>
