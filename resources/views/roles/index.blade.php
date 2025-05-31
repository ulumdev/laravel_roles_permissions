<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles | List') }}
            </h2>
            @can('create roles')
                <a href="{{ route('roles.create') }}"
                    class="ml-auto btn bg-slate-700 hover:bg-slate-600 text-sm text-white rounded-md px-3 py-2">Create
                    Role</a>
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
                                <th class="px-5 py-4 text-left">Permissions</th>
                                <th class="px-5 py-4 text-left" width="15%">Created At</th>
                                <th class="px-5 py-4 text-center" width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($roles->isNotEmpty())
                                @foreach ($roles as $role)
                                    <tr class="border-b border-gray-200 hover:bg-gray-200">
                                        <td class="px-5 py-3 text-left">{{ $loop->iteration }}</td>
                                        <td class="px-5 py-3 text-left">{{ $role->name }}</td>
                                        <td class="px-5 py-3 text-left">
                                            @if ($role->permissions->isNotEmpty())
                                                @foreach ($role->permissions as $permission)
                                                    <span
                                                        class="inline-block bg-gray-100 text-gray-700 rounded-sm px-2 py-1 text-xs font-semibold mr-2 mb-1">
                                                        {{ $permission->name }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-xs text-slate-700"> --- No Permissions ---</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3 text-left">
                                            {{ \Carbon\Carbon::parse($role->created_at)->format('d M Y') }}</td>
                                        <td class="px-5 py-3 text-center">
                                            @canany(['edit roles', 'delete roles'])
                                                @can('edit roles')
                                                    <a href="{{ route('roles.edit', $role->id) }}"
                                                        class="bg-slate-700 text-sm text-white rounded-md px-3 py-2 hover:bg-slate-600 mr-2">
                                                        Edit
                                                    </a>
                                                @endcan
                                                @can('delete roles')
                                                    <a href="javascript:void(0)" onclick="deleteRole({{ $role->id }})"
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
                                    <td colspan="5" class="px-5 py-4 text-center text-gray-500">No roles found!
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="my-3">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script type="text/javascript">
            function deleteRole(id) {
                if (confirm('Are you sure you want to delete this role?')) {
                    $.ajax({
                        url: '{{ route('roles.destroy') }}',
                        type: 'delete',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            window.location.href = '{{ route('roles.index') }}';
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>
