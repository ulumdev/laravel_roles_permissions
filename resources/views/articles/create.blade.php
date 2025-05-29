<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Articles | Create') }}
            </h2>
            <a href="{{ route('articles.index') }}"
                class="ml-auto btn bg-slate-700 hover:bg-slate-600 text-sm text-white rounded-md px-3 py-2 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('articles.store') }}" method="POST">
                        @csrf
                        <div>
                            <label for="title" class="text-lg font-medium">Title</label>
                            <div class="my-3">
                                <input value="{{ old('title') }}" type="text" id="title" name="title"
                                    class="form-input border-gray-300 shadow-sm w-1/2 rounded-lg" placeholder="Title">
                                @error('title')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <label for="content" class="text-lg font-medium">Content</label>
                            <div class="my-3">
                                <textarea id="content" name="content" class="form-input border-gray-300 shadow-sm w-1/2 rounded-lg" cols="30"
                                    rows="5" placeholder="Content">{{ old('content') }}</textarea>
                            </div>
                            <label for="author" class="text-lg font-medium">Author</label>
                            <div class="my-3">
                                <input value="{{ old('author') }}" type="text" id="author" name="author"
                                    class="form-input border-gray-300 shadow-sm w-1/2 rounded-lg" placeholder="Author">
                                @error('author')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <button
                                class="btn bg-slate-700 hover:bg-slate-600 text-sm text-white rounded-md px-5 py-3">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
