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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3">
                <form method="post" action="{{ route("item.view") }}" name="frmgeneral">
                    @csrf
                    <div class="flex">
                        <div class="text-lg font-medium text-gray-900 mb-1 w-3/4">
                            Item Setup ({{ $items->total() }})
                        </div>
                        <div class="w-1/4 flex">
                            
                            <a href="{{ route("item.create")  }}"  class="px-2 mr-2 rounded-sm"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                            </a>
                            <label>
                                <input type="checkbox" name="chktrashed" value="checked" {{request("chktrashed")}} onclick="javascript:doreloadform();"/>&nbsp;<span>Show InActive Records</span>
                            </label>

                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row">
                        <div class="w-full flex flex-col space-x-0 sm:flex-row sm:space-x-3">
                            <div class="">
                                <div class="font-bold">{{ _("Category")}}</div>
                            </div>
                            <select name="category" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 w-full sm:w-3/12">
                                <option value="">Select</option>
                                @php
                                $categorygroup="";
                                @endphp
                                @foreach($categories as $category)
                                    @if($category->category_group->name != $categorygroup)
                                    @if($categorygroup != "")
                                    </optgroup>
                                    @endif
                                    @php
                                    $categorygroup=$category->category_group->name
                                    @endphp
                                    <optgroup label="{{ $category->category_group->name }} ">
                                    @endif

                                    @if($category->id == request("category"))
                                    <option value="{{$category->id}}" selected>{{ $category->name }}</option>
                                    @else
                                    <option value="{{$category->id}}">{{ $category->name }}</option>
                                    @endif 
                                    
                                @endforeach
                                </optgroup>
                            </select>
                            <x-primary-button type="submit">Search</x-button>
                            @if($errors->has("name"))
                                <div class="p-2 text-red-600 text-md">{{$errors->first("name")}}</div>
                            @endif
                        </div>
                        
                    </div>

               
                    <div class="p-6 px-0 text-gray-900">
                        @csrf
                        <table class="table w-full" >
                            <thead>
                                <tr>
                                    <th class="w-0.5/6 text-slate-500 p-4 text-left border-b"></th>
                                    <th class="w-1/6 text-slate-500 p-4 text-left border-b">Name</th>
                                    <th class="w-1/6 text-slate-500 p-4 text-left border-b">Category</th>
                                    <th class="w-1/6 text-slate-500 p-4 text-left border-b">Category Group</th>
                                    <th class="w-1/6 text-slate-500 p-4 text-right border-b ">Cost Price</th>
                                    <th class="w-1/6 text-slate-500 p-4 text-right border-b">Retail Price<div class="text-sm">(Before Tax)</div></th>
                                    <th class="w-0.5/6 text-slate-500 p-4 text-right border-b">Discount %</th>
                                    <th class="w-0.5/6 text-slate-500 p-4 text-right border-b">Tax %</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td class="w-0.5/6 text-slate-700 p-2 text-left border-b"><a href="{{route("item.edit",$item->id) }} " class="hover:border-2 border-2 hover:bg-white hover:text-black bg-black px-2 py-1 text-white text-blue-600 hover:text-blue-400 p-2 rounded-md px-4">Edit</a></td>
                                        <td class="w-1/6 text-slate-700 p-2 text-left border-b ">
                                            <div class="flex w-full">
                                            {{ $item->name}}
                                            @if($item->trashed())
                                                <div class="group ml-1 mt-1 relative ">
                                                    <a class="text-red-600 text-bold"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                                                        <path fill-rule="evenodd" d="M15 8A7 7 0 1 1 1 8a7 7 0 0 1 14 0ZM9 5a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM6.75 8a.75.75 0 0 0 0 1.5h.75v1.75a.75.75 0 0 0 1.5 0v-2.5A.75.75 0 0 0 8.25 8h-1.5Z" clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                    <div class="hidden group-hover:block absolute bg-white p-3 min-w-[290px] bold mr-3 w-400 shadow-md z-40">This item has been made inactive</div>
                                                </div>
                                            @endif
                                            </div>
                                        </td>
                                        <td class="w-1/6 text-slate-700 p-2 text-left border-b">{{ $item->category->name}}</td>
                                        <td class="w-1/6 text-slate-700 p-2 text-left white-space-nowrap border-b">{{ $item->category->category_group->name}}</td>
                                        <td class="w-0.5/6 text-slate-700 p-2 text-left border-b text-right">{{ $item->purchasecost}}</td>
                                        <td class="w-0.5/6 text-slate-700 p-2 text-left border-b text-right">{{ $item->price}}</td>
                                        <td class="w-0.5/6 text-slate-700 p-2 text-left border-b text-right">{{ $item->discount}}</td>
                                        <td class="w-0.5/6 text-slate-700 p-2 text-left border-b text-right">{{ $item->tax}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $items->links() }}
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
