<x-app-layout>
    <x-hero></x-hero>
    <section class="container px-5 py-12 mx-auto">
        <div class="mb-12 text-center">
            @foreach($tags as $tag)
                <a href="{{ route('jobs.index', ['tag' => $tag->slug]) }}"
                    class="inline-block ml-2 text-xs font-medium text-indigo-500 py-1 px-2 border border-indigo-500 uppercase {{ $tag->slug === request()->get('tag') ? 'bg-indigo-500 text-white' : 'bg-white text-indigo-500' }}"
                >{{ $tag->name }}</a>
            @endforeach
        </div>
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 title-font mb-4">All Jobs ({{ $jobs->total() }})</h2>
        </div>
        <div class="-my-6">
            @foreach($jobs as $Jobs)
                <a href="{{ route('jobs.show', $Jobs->slug) }}"
                    class="py-6 px-4 flex flex-wrap md:flex-nowrap border-b border-gray-100 {{ $Jobs->is_highlighted ? 'bg-yellow-100 hover:bg-yellow-200' : 'bg-white hover:bg-gray-100' }}"
                >
                    <div class="md:w-16 md:mb-0 mb-6 mr-4 flex-shrink-0 flex flex-col">
                        <img src="/storage/{{ $Jobs->logo }}" alt="{{ $Jobs->company }} logo" class="w-16 h-16 rounded-full object-cover">
                    </div>
                    <div class="md:w-1/2 mr-8 flex flex-col items-start justify-center">
                        <h2 class="text-xl font-bold text-gray-900 title-font mb-2">{{ $Jobs->title }}</h2>
                        <p class="leading-relaxed text-gray-900">
                            {{ $Jobs->company }} &mdash; <span class="text-gray-600">{{ $Jobs->location }}</span>
                        </p>
                    </div>
                    <div class="md:flex-grow mr-8 flex items-center justify-start space-x-2">
                        @foreach($Jobs->tags as $tag)
                            <span class="text-xs font-medium text-indigo-500 border border-indigo-500 uppercase px-2 py-1 {{ $tag->slug === request()->get('tag') ? 'bg-indigo-500 text-white' : 'bg-white text-indigo-500' }}">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                    <span class="md:flex-grow flex items-center justify-end text-gray-600">
                        <span>{{ $Jobs->created_at->diffForHumans() }}</span>
                    </span>
                </a>
            @endforeach
        </div>

        <!-- Pagination links -->
        <div class="mt-8">
            {{ $jobs->links() }}
        </div>
    </section>
</x-app-layout>
