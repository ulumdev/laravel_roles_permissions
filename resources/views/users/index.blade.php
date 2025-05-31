<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users | List') }}
            </h2>
            @can('create users')
                <a href="{{ route('users.create') }}"
                    class="ml-auto btn bg-slate-700 hover:bg-slate-600 text-sm text-white rounded-md px-3 py-2">Create
                    User</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-message></x-message>
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr class="border-b border-gray-300">
                                <th class="px-5 py-4 text-left" width="5%">#</th>
                                <th class="px-5 py-4 text-left">Name</th>
                                <th class="px-5 py-4 text-left">Email</th>
                                <th class="px-5 py-4 text-left">Roles</th>
                                <th class="px-5 py-4 text-left" width="12%">Created At</th>
                                <th class="px-5 py-4 text-center" width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($users->isNotEmpty())
                                @foreach ($users as $user)
                                    <tr class="border-b border-gray-200 hover:bg-gray-200">
                                        <td class="px-5 py-3 text-left">{{ $loop->iteration }}</td>
                                        <td class="px-5 py-3 text-left">{{ $user->name }}</td>
                                        <td class="px-5 py-3 text-left">{{ $user->email }}</td>
                                        <td class="px-5 py-3 text-left">
                                            @if ($user->roles->isNotEmpty())
                                                @foreach ($user->roles as $role)
                                                    <span
                                                        class="inline-block bg-green-100 text-green-900 rounded-sm px-2 py-1 text-xs font-semibold mr-2">
                                                        {{ $role->name }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-xs text-slate-700"> --- No Roles ---</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3 text-left">
                                            {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</td>
                                        <td class="px-5 py-3 text-center">
                                            @canany(['edit users', 'delete users'])
                                                @can('edit users')
                                                    <a href="{{ route('users.edit', $user->id) }}"
                                                        class="bg-slate-700 text-sm text-white rounded-md px-3 py-2 hover:bg-slate-600 mr-2">
                                                        Edit
                                                    </a>
                                                @endcan
                                                @can('delete users')
                                                    <a href="javascript:void(0)" onclick="deleteUser({{ $user->id }})"
                                                        class="bg-red-600 text-white text-sm rounded-md px-3 py-2 hover:bg-red-500">Delete</a>
                                                @endcan
                                            @else
                                                ---
                                            @endcanany
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="px-5 py-4 text-center text-gray-500">No users found!
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="my-3">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script type="text/javascript">
            function deleteUser(id) {
                if (confirm('Are you sure you want to delete this user?')) {
                    $.ajax({
                        url: '{{ route('users.destroy') }}',
                        type: 'delete',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            window.location.href = '{{ route('users.index') }}';
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>
