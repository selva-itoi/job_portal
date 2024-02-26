<x-app-layout>
    <section class="text-gray-600 body-font overflow-hidden">
        <div class="container px-5 py-12 mx-auto">
            <div class="mb-12">
                <h2 class="text-3xl font-semibold text-gray-900">{{ $jobs->title }}</h2>
                <div class="flex flex-wrap mt-4">
                    @foreach($jobs->tags as $tag)
                        <span class="inline-block mr-2 mb-2 px-3 py-1 bg-indigo-100 text-indigo-500 text-sm font-medium rounded">{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>
            <div class="flex flex-wrap -mx-4">
                <div class="w-full md:w-3/4 px-4 mb-4">
                    <div class="leading-relaxed text-base">{!! $jobs->content !!}</div>
                </div>
                <div class="w-full md:w-1/4 px-4">
                    <img src="/storage/{{ $jobs->logo }}" alt="{{ $jobs->company }} logo" class="w-full mb-4 rounded-lg">
                    <p class="mb-4 text-sm">
                        <strong class="font-semibold">Location:</strong> {{ $jobs->location }}<br>
                        <strong class="font-semibold">Company:</strong> {{ $jobs->company }}
                    </p>
                    <a href="{{ route('jobs.apply', $jobs->slug) }}" class="block w-full px-4 py-2 text-center text-white bg-indigo-500 rounded-md hover:bg-indigo-600">Apply Now</a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
