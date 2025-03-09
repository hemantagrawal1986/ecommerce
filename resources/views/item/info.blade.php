<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('About Product') }}
        </h2>
    </x-slot>
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

        function loadRecommendations()
        {
            window.fetch("{{ route('order.recommend',$product->id) }}",
                {
                    "X-CSRF-TOKEN":"{{ csrf_token() }}",
                    "credentials":"same-origin",
                })
                .then((response)=>response.text())
                .then(
                    function(response)
                    {
                       
                        document.getElementById('recommendations').innerHTML=response
                    });
        }
    </script>
    <div class="py-12 ">          
        <div class="w-50">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white  overflow-hidden shadow-sm">
                <div class="flex flex-col sm:flex-row">
                    <div class="w-4/4 sm:w-1/4">
                        <img src="{{ asset('storage/'.$product->photo) }} " class="w-56"/>
                    </div>
                    <div class="w-4/4 ml-3 pt-3 sm:w-3/4">
                        <h2 class="py-2 text-black-900 text-3xl">{{ $product->name }}</h2>
                        <p class="text-slate-700 text-md mt-3">{{ $product->description }}</p>
                        <div class="mt-4">
   
                            @if(array_key_exists($product->id,$cart))
                                <button class="rounded-md bg-green-900 rounded text-white px-4 py-1 w-32 hover:bg-green-600">Added</button>
                            @else   
                                <button class="rounded-md bg-indigo-900 rounded text-white px-4 py-1 w-32 hover:bg-indigo-600" onclick="javascript:addtocart(this, '{{ $product->id }}' );">Buy Now</button>
                            @endif   
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="recommendations">

        </div>

        <script language="javascript">
            loadRecommendations();
        </script>
    </div>
    
    
</x-app-layout>