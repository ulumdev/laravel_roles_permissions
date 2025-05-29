<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users | Edit') }}
            </h2>
            <a href="{{ route('users.index') }}"
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
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        <div>
                            <label for="name" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input value="{{ old('name', $user->name) }}" type="text" id="name"
                                    name="name" class="form-input border-gray-300 shadow-sm w-1/2 rounded-lg"
                                    placeholder="Enter user name">
                                @error('name')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <label for="email" class="text-lg font-medium">Email</label>
                            <div class="my-3">
                                <input value="{{ old('email', $user->email) }}" type="email" id="email"
                                    name="email" class="form-input border-gray-300 shadow-sm w-1/2 rounded-lg"
                                    placeholder="Enter user email">
                                @error('email')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-4 mb-3">
                                @if ($roles->isNotEmpty())
                                    @foreach ($roles as $role)
                                        <div class="my-3">
                                            <input {{ $hasRoles->contains($role->id) ? 'checked' : '' }} type="checkbox"
                                                id="role_{{ $role->id }}" name="roles[]" value="{{ $role->name }}"
                                                class="rounded">
                                            <label for="role_{{ $role->id }}"
                                                class="ml-2 text-sm text-gray-700">{{ $role->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
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
