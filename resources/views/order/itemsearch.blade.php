
@foreach($items as $product)
    
    <div class="flex md:p-2 sm:p-0">
        <div class="md:shrink-0">
            <img class="w-8 mx-auto" src="{{ asset('storage/'.$product->photo) }}" onerror="javascript:this.src='https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg';" alt="Modern building architecture">
        </div>
        <div class="p-2 sm:p-0 ml-4 border-1">
            <a href="#" class="block mt-1 text-sm leading-tight font-medium text-black hover:underline after:content-['_↗']" >{{ $product->name }}</a>
            <!--<p class="mt-2 text-slate-500">
                {{ $product->description }}
            </p>-->
            <!--<div class="mt-1">
                @if(array_key_exists($product->id,$cart))
                    <button class="rounded-md bg-green-900 rounded text-white px-1 py-1 w-16 hover:bg-green-600 text-sm">Added</button>
                @else   
                    <button class="rounded-md bg-indigo-900 rounded text-white px-1 py-1 w-16 hover:bg-indigo-600 text-sm" onclick="javascript:addtocart(this, '{{ $product->id }}' );">Buy Now</button>
                @endif    
            </div>-->
        </div>
    </div>
@endforeach