<x-app-layout>
    <section class="text-gray-600 body-font overflow-hidden">
        <div class="container px-5 py-12 mx-auto">
            <div class="mb-12 flex items-center justify-between">
                <h2 class="text-3xl font-bold text-indigo-900 mb-4">
                    Your Jobs ({{ $jobs->count() }})
                </h2>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('profile') }}" class="text-indigo-500 hover:underline">Profile</a>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="text-indigo-500 hover:underline">Sign Out</button>
                    </form>
                </div>
            </div>
            <div class="-my-6">
                @foreach($jobs as $job)
                    <a
                        href="{{ route('jobs.show', $job->slug) }}"
                        class="py-6 px-4 flex flex-wrap md:flex-nowrap border-b border-gray-100 transition duration-300 ease-in-out transform hover:scale-105 {{ $job->is_highlighted ? 'bg-yellow-100' : 'bg-white' }}"
                    >
                        <div class="md:w-16 md:mb-0 mb-6 mr-4 flex-shrink-0 flex flex-col">
                            <img src="/storage/{{ $job->logo }}" alt="Company Logo" class="w-16 h-16 rounded-full object-cover">
                        </div>
                        <div class="md:w-1/2 mr-8 flex flex-col items-start justify-center">
                            <h2 class="text-xl font-bold text-indigo-900 title-font mb-1">{{ $job->title }}</h2>
                            <p class="leading-relaxed text-gray-900">{{ $job->company }} &mdash; <span class="text-gray-600">{{ $job->location }}</span></p>
                        </div>
                        <div class="md:flex-grow mr-8 mt-2 flex items-center justify-start">
                            @foreach($job->tags as $tag)
                                <span class="inline-block mr-2 text-xs font-medium text-indigo-500 bg-indigo-100 px-2 py-1.5 rounded">{{ strtoupper($tag->name) }}</span>
                            @endforeach
                        </div>
                        <span class="md:flex-grow flex flex-col items-end justify-center">
                            <span class="text-gray-600">{{ $job->created_at->diffForHumans() }}</span>
                            <span class="text-indigo-700"><strong class="text-bold">{{ $job->clicks()->count() }}</strong> Apply Button Clicks</span>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>
