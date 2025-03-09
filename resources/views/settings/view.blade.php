<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                
                <div class="p-3 text-bold">
                    Item Settings
                </div>
                <div class="mx-2 font-bold">
                    <div class="p-3">
                        <a href="{{ route('category_group.view') }}" class="text-indigo-700">Add / Edit Category Group</a>
                    </div>
                    <div class="p-3">
                        <a href="{{ route('category.view') }}" class="text-indigo-700">Add / Edit Category</a>
                    </div>
                    <div class="p-3">
                        <a href="{{ route('item.view') }}" class="text-indigo-700">Add / Edit Item</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>