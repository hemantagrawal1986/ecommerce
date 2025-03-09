<x-app-layout>
    <script language="javascript">
        async function addtocart(element,id)
        {
            //$(element).addClass("bg-slate-200")
            if(element.innerHTML.toLowerCase() == "added")
            {
                return;
            }
            let intermediate_class="yellow";
            element.className=element.getAttribute("class").replace(/indigo/g,intermediate_class);
            element.innerHTML="Adding...";
           // return;
            let response=await window.fetch("{{ route('order.cart','') }}/"+id,{
                "X-CSRF-TOKEN":"{{ csrf_token() }}",
                "credentials":"same-origin",
            })

            if(response.ok) 
            {
                element.className=element.getAttribute("class").replace(new RegExp(intermediate_class,"g") ,"green");
                element.innerHTML="Added";

            }
        }
    </script>
    <!-- COMBINED LAYOUT 2 part for ecommerce -->
    <div class="flex py-5 p-5">
        <div class="w-80 mr-3 md:mr-3 sm:mr-0 md:w-80 sm:w-full">
            <div>
@php
                /*<!--<div class="bg-white p-5 ">
                    @foreach($dummycategories as $category)
                        <div class="text-xl {{ $loop->index > 0 ? 'mt-4':''}}">
                            {{ $category }}
                        </div>
                        <div class="mt-1">
                            @foreach($dummysubcategories[$category] as $subcategory)
                                <a class="block ml-2 px-3 border-2 border-transparent  transition duration-100 hover:border-l-gray-900 hover:ease-in" href="javascript:;">
                                    {{ $subcategory }}
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </div>-->*/
@endphp
                <div class="bg-white p-5 ">
                    <div class="p-1 text-lg font-bold" >Shop By Categories</div>
                    @foreach($category_groups as $categorygroup)
                        <!--<div class="text-xl {{ $loop->index > 0 ? 'mt-4':''}}">
                            {{ $categorygroup->name }}
                        </div>-->
                        <div class="mt-1">
                            <!--<a class="block ml-2 px-3 border-2 border-transparent  transition duration-100 hover:border-l-gray-900 hover:ease-in" href="javascript:;">
    -->
                                @foreach($categorygroup->categories as $category)
                                  
                                    @if($category->new_status == "active")
                                    
                                    <a class="text-md block ml-2 p-2 border-2 border-transparent  transition duration-100 hover:border-l-gray-900 hover:ease-in" href="{{ route('order.products',['category'=>$category->id]) }}">
                                        {{ $category->name }}
                                    </a>
                                    @endif
                                @endforeach
                            <!--</a>-->
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="w-full">
            
            <div>
                @foreach($products as $product)
                <div class="bg-white mb-2 shadow-md overflow-hidden mr-2 p-4">
                    <div class="flex md:p-2 sm:p-0">
                        <div class="md:shrink-0">
                            <img class="w-32 md:w-32 sm:w-full mx-auto" src="{{ asset('storage/'.$product->photo) }}" >
                        </div>
                        <div class="p-2 sm:p-0 ml-4 border-1">
                            <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold mb-2">Rating {{ $product->rating }}</div>
                            <a href="{{ route('item.info',$product->id) }}  " class="block mt-1 text-lg leading-tight font-medium text-black hover:underline after:content-['_↗']" >{{ $product->name }}</a>
                            <p class="mt-2 text-slate-500">
                                {{ $product->description }}
                            </p>
                            <div class="mt-1">
                                @if(array_key_exists($product->id,$cart))
                                    <button class="rounded-md bg-green-900 rounded text-white px-4 py-1 w-32 hover:bg-green-600">Added</button>
                                @else   
                                    <button class="rounded-md bg-indigo-900 rounded text-white px-4 py-1 w-32 hover:bg-indigo-600" onclick="javascript:addtocart(this, '{{ $product->id }}' );">Buy Now</button>
                                @endif    
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <!--
                <div class=" bg-white rounded-xl shadow-md overflow-hidden mb-3">
                    <div class="md:flex md:p-2 sm:p-0">
                        <div class="md:shrink-0">444
                            <img class="w-32 md:w-32 sm:w-full mx-auto" src="https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg" alt="Modern building architecture">
                        </div>
                        <div class="p-8">
                            <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">
                                Company retreats
                            </div>
                            <a href="#" class="block mt-1 text-lg leading-tight font-medium text-black hover:underline" >Incredible accommodation for your team</a>
                            <p class="mt-2 text-slate-500">
                                Looking to take your team away on a retreat to enjoy awesome food and take in some sunshine? We have a list of places to do just that.
                            </p>
                            <div class="mt-1">
                                <button class="rounded-md bg-indigo-900 rounded text-white px-4 py-1 w-32 hover:bg-slate-600">Add To Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" bg-white rounded-xl shadow-md overflow-hidden ">
                    <div class="md:flex md:p-2 sm:p-0">
                        <div class="md:shrink-0">
                            <img class="w-32 md:w-32 sm:w-full mx-auto" src="https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg" alt="Modern building architecture">
                        </div>
                        <div class="p-8">222
                            <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">Company retreats</div>
                            <a href="#" class="block mt-1 text-lg leading-tight font-medium text-black hover:underline after:content-['_↗']" >Incredible accommodation for your team</a>
                            <p class="mt-2 text-slate-500">
                                Looking to take your team away on a retreat to enjoy awesome food and take in some sunshine? We have a list of places to do just that.
                            </p>
                            <div class="mt-1">
                                <button class="rounded-md bg-indigo-900 rounded text-white px-4 py-1 w-32 hover:bg-slate-600">Add To Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                -->
            </div>
        </div>
    </div>
    
</x-app-layout>