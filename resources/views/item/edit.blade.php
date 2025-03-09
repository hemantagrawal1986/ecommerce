<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Item Setup') }}
        </h2>
    </x-slot>
    <script language="javascript">
        function doconfirminactive()
        {
            var x = confirm("Item Will Be Made InActive?\nConfirm");
            if(x)
            {
                document.frmdelete.submit();
            }
        }

        function doconfirmactive()
        {
            var x = confirm("Item Will Be Made Active?\nConfirm");
            if(x)
            {
                document.frmrecover.submit();
            }
        }

        async function dodeletephoto(itemid)
        {
            const x = confirm("Delete photo?");

            if(x) {
                let response = await window.fetch("{{ route('item.deletephoto').'/'.$item->id }}",{
                    method:"DELETE",
                    headers:{
                        "X-CSRF-TOKEN":"{{ csrf_token() }}" ,
                    },
                    credentials: "same-origin"
                })
                    
              
                if(response.ok)
                {   
                    document.getElementById('photo_action').style.display="none";
                }
                else
                {
                    alert("Sorry! unable to confirm action");
                }
            }
        }
    </script>
    <div class="py-12 "> 
        <form method="post" action="{{route('item.delete',$item->id) }}" name="frmdelete">
            @method("DELETE")
            @csrf
        </form>
        <form method="post" action="{{route('item.restore',$item->id) }}" name="frmrecover">
            @method("PUT")
            @csrf
        </form>
        <form method="post" action="{{ route('item.update',$item->id) }}" autocomplete="off" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8  bg-white overflow-hidden shadow-sm">
                <div class="rounded-b-sm p-4 pb-2 col-span-2">
                    <h4 class="py-2 text-black-900 text-xl ">
                        Item Information
                    </h4>
                    <div class="py-1 text-gray-600">
                        Category
                    </div>
                    <div>
                        <select name="category" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 w-full sm:w-5/12">
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
                                @if($category->id == old("category",$item->category_id))
                                <option value="{{$category->id}}" selected>{{ $category->name }}</option>
                                @else
                                <option value="{{$category->id}}">{{ $category->name }}</option>
                                @endif 
                                
                            @endforeach
                            </optgroup>
                        </select>
                        @if($errors->has("name"))
                            <div class="p-2 text-red-600 text-md">{{$errors->first("name")}}</div>
                        @endif
                    </div>
                    <div class="py-1 text-gray-600">
                        Product Name
                    </div>
                    <div>
                        <input type="text" name="name" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 w-full sm:w-7/12"  value="{{old('name',$item->name)}}"></td>
                        @if($errors->has("name"))
                            <div class="p-2 text-red-600 text-md">{{$errors->first("name")}}</div>
                        @endif
                    </div>
                    <div class="py-1 text-gray-600">
                        Product Description
                    </div>
                    <div>
                        <textarea name="description" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 w-full sm:w-7/12">{{old('description',$item->description)}}</textarea>
                        @if($errors->has("description"))
                            <div class="p-2 text-red-600 text-md">{{$errors->first("description")}}</div>
                        @endif
                    </div>
                    <div>
                        <div class="flex">
                            <div class="w-3/4">
                                <div class="py-1 text-gray-600">
                                    Product photo
                                </div>                    
                                <input type="file"name="photo" />&nbsp;
                                @if($item->photo)
                                    <span id="photo_action">
                                        <a href="{{ asset('storage/'.$item->photo)}}" class="text-indigo-700 visited:text-indigo-500" target="_blank">View</a>
                                        <a href="javascript:dodeletephoto('{{ $item->id }}');" class="ml-5 text-red-700 visited:text-red-500">Delete</a>
                                    </span>
                                @endif
                                <div class="text-slate-400">JPEG,JPG,PNG format required</div>
                                @if($errors->has("photo"))
                                    <div class="p-2 text-red-600 text-md">{{$errors->first("photo")}}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" p-4 col-span-1">
                    <h4 class="py-2 text-black-900 text-xl ">
                        Cost Setup
                    </h4>
                    <div class="flex space-x-4">
                        <div>
                            <div class="py-1 text-gray-600">
                                Purchase Cost
                            </div>
                            <div>
                                <input type="text" name="purchasecost" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1  w-full"  value="{{old('purchasecost',$item->purchasecost)}}"></td>
                                @if($errors->has("purchasecost"))
                                    <div class="p-2 text-red-600 text-md">{{$errors->first("purchasecost")}}</div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="py-1 text-gray-600">
                                Price (Before Tax)
                            </div>
                            <div>
                                <input type="text" name="price" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 w-full "  value="{{old('price',$item->price)}}"></td>
                                @if($errors->has("price"))
                                    <div class="p-2 text-red-600 text-md">{{$errors->first("price")}}</div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="py-1 text-gray-600">
                                Discount %
                            </div>
                            <div>
                                <input type="text" name="discount" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1  w-full "  value="{{old('discount',$item->discount)}}"></td>
                                @if($errors->has("discount"))
                                    <div class="p-2 text-red-600 text-md">{{$errors->first("discount")}}</div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="py-1 text-gray-600">
                                Tax %
                            </div>
                            <div>
                                <input type="text" name="tax" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1  w-full "  value="{{old('tax',$item->tax)}}"></td>
                                @if($errors->has("tax"))
                                    <div class="p-2 text-red-600 text-md">{{$errors->first("tax")}}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-5">
                    <x-primary-button class="ml-3 mt-3">
                        Save
                    </x-primary-button>
                    <a href="{{ route('item.view') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3 mt-3">
                        Back
                    </a>
                </div>
                @if($item->trashed()) 
                <div class="bg-white p-5 rounded-sm mt-4">
                    <h4 class="py-2 text-black-900 text-xl ">
                        Restore / Activate Item
                    </h4>
                    <div class="py-1 text-gray-600">
                        Item will be made inactive / trashed
                    </div>

                    <a href="javascript:doconfirmactive();" class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3 mt-3">
                        Recover 
                    </a>
                </div>
                @else
                <div class="bg-white p-5 rounded-sm mt-4">
                    <h4 class="py-2 text-black-900 text-xl ">
                        Delete / DeActivate Item
                    </h4>
                    <div class="py-1 text-gray-600">
                        Item will be made inactive / trashed
                    </div>

                    <a href="javascript:doconfirminactive();" class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-3 mt-3">
                        Delete 
                    </a>
                </div>
                @endif
            </div>
        </form>
    </div>
</x-app-layout>
