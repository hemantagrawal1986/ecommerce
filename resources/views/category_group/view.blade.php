<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Item Setup') }}
        </h2>
    </x-slot>
    <script language="javascript">
        function doreloadform()
        {
            document.frmgeneral.submit();
        }
    </script>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                <x-message :type="session("type")" :message="session("message")"/>
                <div class="p-3 text-bold">
                    Categories ({{ count($categoryGroups) }}) <a href="{{ route('category_group.create') }}" class="text-indigo-700">Add</a>
                </div>
                <table class="table-auto" width="100%">
                    <thead>
                        <tr>
                            <th class="px-2 py-2 border-2 text-center w-1/6">#</th>
                            <th class="px-2 py-2 border-2 text-center w-1/6">Action</th>
                            <th class="px-2 py-2 border-2 text-left w-4/6">Name</th>
                            <th class="px-2 py-2 border-2 text-center w-2/6">Status</th>
                            <th class="px-2 py-2 border-2 w-2/6">Categories</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categoryGroups as $categorygroup)
                            <tr>    

                                <td class="px-2 py-2 border-2 text-center">{{ $loop->index+1 }}</td>
                                <td class="px-2 py-2 border-2 text-center"><a href="{{ route('category_group.edit',$categorygroup->id)}}" class="text-indigo-700">Edit</a></td>
                                <td class="px-2 py-2 border-2">{{ $categorygroup->name }}</td>
                                <td class="px-2 py-2 border-2 text-center">{{  $categorygroup->status}} </td>
                                <td class="px-2 py-2 border-2 text-center"><a href="{{ route('category.view',$categorygroup->id) }}" class="text-indigo-700">{{ $categorygroup->categories_count }}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>