<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Articles | List') }}
            </h2>
            <a href="{{ route('articles.create') }}"
                class="ml-auto btn bg-slate-700 hover:bg-slate-600 text-sm text-white rounded-md px-3 py-2">Create
                Article</a>
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
                                <th class="px-5 py-4 text-left" width="20%">Title</th>
                                <th class="px-5 py-4 text-left">Content</th>
                                <th class="px-5 py-4 text-left" width="15%">Created At</th>
                                <th class="px-5 py-4 text-center" width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($articles->isNotEmpty())
                                @foreach ($articles as $article)
                                    <tr class="border-b border-gray-200 hover:bg-gray-200">
                                        <td class="px-5 py-3 text-left">{{ $loop->iteration }}</td>
                                        <td class="px-5 py-3 text-left">
                                            <div
                                                style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                {{ $article->title }}
                                            </div>
                                        </td>
                                        <td class="px-5 py-3 text-left">
                                            <div
                                                style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                {{ $article->content }}
                                            </div>
                                        </td>
                                        <td class="px-5 py-3 text-left">
                                            {{ \Carbon\Carbon::parse($article->created_at)->format('d M Y') }}</td>
                                        <td class="px-5 py-3 text-center">
                                            <a href="{{ route('articles.edit', $article->id) }}"
                                                class="bg-slate-700 text-sm text-white rounded-md px-3 py-2 hover:bg-slate-600 mr-2">
                                                Edit
                                            </a>
                                            <a href="javascript:void(0)" onclick="deleteArticle({{ $article->id }})"
                                                class="bg-red-600 text-white text-sm rounded-md px-3 py-2 hover:bg-red-500">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="px-5 py-4 text-center text-gray-500">No articles found!
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="my-3">
                        {{ $articles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="scripts">
        <script type="text/javascript">
            function deleteArticle(id) {
                if (confirm('Are you sure you want to delete this article?')) {
                    $.ajax({
                        url: '{{ route('articles.destroy') }}',
                        type: 'delete',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            window.location.href = '{{ route('articles.index') }}';
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>
