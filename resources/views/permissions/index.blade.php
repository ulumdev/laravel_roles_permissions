<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permissions | List') }}
            </h2>
            @can('create permissions')
                <a href="{{ route('permissions.create') }}"
                    class="ml-auto btn bg-slate-700 hover:bg-slate-600 text-sm text-white rounded-md px-3 py-2">Create
                    Permission</a>
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
                                <th class="px-5 py-4 text-left" width="15%">Created At</th>
                                <th class="px-5 py-4 text-center" width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($permissions->isNotEmpty())
                                @foreach ($permissions as $permission)
                                    <tr class="border-b border-gray-200 hover:bg-gray-200">
                                        <td class="px-5 py-3 text-left">{{ $loop->iteration }}</td>
                                        <td class="px-5 py-3 text-left">{{ $permission->name }}</td>
                                        <td class="px-5 py-3 text-left">
                                            {{ \Carbon\Carbon::parse($permission->created_at)->format('d M Y') }}</td>
                                        <td class="px-5 py-3 text-center">
                                            @canany(['edit permissions', 'delete permissions'])
                                                @can('edit permissions')
                                                    <a href="{{ route('permissions.edit', $permission->id) }}"
                                                        class="bg-slate-700 text-sm text-white rounded-md px-3 py-2 hover:bg-slate-600 mr-2">
                                                        Edit
                                                    </a>
                                                @endcan
                                                @can('delete permissions')
                                                    <a href="javascript:void(0)"
                                                        onclick="deletePermission({{ $permission->id }})"
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
                                    <td colspan="4" class="px-5 py-4 text-center text-gray-500">No permissions found!
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="my-3">
                        {{ $permissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script type="text/javascript">
            function deletePermission(id) {
                if (confirm('Are you sure you want to delete this permission?')) {
                    $.ajax({
                        url: '{{ route('permissions.destroy') }}',
                        type: 'delete',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            window.location.href = '{{ route('permissions.index') }}';
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>
