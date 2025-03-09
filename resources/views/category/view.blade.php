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

        function doselectcategory()
        {
            document.frmgeneral.action+="/"+document.frmgeneral.categorygroup.value
            document.frmgeneral.submit();
        }

        function docreatecategory(createurl)
        {
            document.location.href=createurl + "/"+document.frmgeneral.categorygroup.value;
        }
    </script>
    
    <form method="get" action="{{ route('category.view')}}" name="frmgeneral">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <x-message :type="session("type")" :message="session("message")"/>
                    <div class="p-3 text-bold">
                        Categories ({{ count($categories) }}) <a href="javascript:docreatecategory('{{ route('category.create') }}');" class="text-indigo-700">Add</a>
                    </div>
                    <div class="p-3">
                        <div class="flex">
                            <div class="text-black-100 align-text-bottom p-2"><b>Category Group</b></div>
                            <select name="categorygroup" class="m-0 p-0 px-1 w-32 rounded-sm border-slate-400 focus:border-slate-600 ">
                                <option value="" selected>Select</option>
                                @foreach($categoryGroup_all as $categroup_all_i)
                                    <option value="{{$categroup_all_i->id}}" {{ $categroup_all_i->id == optional($categoryGroup)->id ? "selected":"" }}>{{ $categroup_all_i->name }}</option>
                                @endforeach
                            </select>
                            <div class="mx-2">
                                <x-primary-button class="mt-3" type="button" onclick="javascript:doselectcategory();">
                                    {{ __('Search') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </div>
                    @if(count($categories)>0)
                        <table class="" width="100%">
                            <thead>
                                <tr>
                                    <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3  dark:text-slate-200 text-left">#</th>
                                    <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3  dark:text-slate-200 text-left">Name</th>
                                    <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3  dark:text-slate-200 text-left">Status</th>
                                    <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3  dark:text-slate-200 text-left">Category Group</th>
                                    <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 dark:text-slate-200 text-left"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800">
                                @foreach($categories as $category)
                                    <tr>    
                                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $loop->index+1 }}</td>
                                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ $category->name }}</td>
                                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{  $category->status}} </td>
                                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400"><a href="">{{ $category->category_group->name }}</a></td>
                                        <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400"><a href="{{ route('category.edit',$category->id)}}" class="text-indigo-700">Edit</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-3 ">
                            No categories exists
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </form>
</x-app-layout>