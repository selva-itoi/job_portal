<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- User details display -->
                    <div class="mb-4">
                        <p class="text-3xl font-semibold text-indigo-900">{{ auth()->user()->name }}</p>
                        <p class="text-gray-500">{{ auth()->user()->email }}</p>
                    </div>

                    <!-- Update profile form -->
                    <div class="mt-8">
                        <h3 class="text-2xl font-semibold mb-4 text-indigo-900">Update Profile</h3>
                        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <!-- Add your profile update fields here -->
                            <div>
                                <x-label for="name" :value="__('Name')" class="text-indigo-900" />
                                <x-input id="name" class="block mt-1 w-full border rounded-md focus:outline-none focus:border-indigo-500" type="text" name="name" :value="auth()->user()->name" required />
                            </div>

                            <div>
                                <x-label for="email" :value="__('Email')" class="text-indigo-900" />
                                <x-input id="email" class="block mt-1 w-full border rounded-md focus:outline-none focus:border-indigo-500" type="email" name="email" :value="auth()->user()->email" required />
                            </div>

                            <!-- Add more profile update fields as needed -->

                            <div class="flex items-center justify-end mt-4">
                                <x-button class="bg-indigo-500 text-white hover:bg-indigo-600">
                                    {{ __('Update Profile') }}
                                </x-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
