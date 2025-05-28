@if (Session::has('success'))
    <div x-data="{ show: true }" x-show="show"
        class="bg-green-200 border-green-600 p-4 mb-3 rounded-sm shadow-sm flex justify-between items-center">
        <span>{{ Session::get('success') }}</span>
        <button @click="show = false" class="text-green-700 font-bold ml-4">&times;</button>
    </div>
@endif
@if (Session::has('error'))
    <div x-data="{ show: true }" x-show="show"
        class="bg-red-200 border-red-600 p-4 mb-3 rounded-sm shadow-sm flex justify-between items-center">
        <span>{{ Session::get('error') }}</span>
        <button @click="show = false" class="text-red-700 font-bold ml-4">&times;</button>
    </div>
@endif
