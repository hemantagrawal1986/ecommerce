<x-app-layout>
    <div class="py-12">
        <script language="javascript">
            async function doactioncart(element,productid,mode)
            {
                let txtqty=document.getElementById("qty_"+productid);
                let qty=parseInt(txtqty.value);
             
                if(mode == "plus")
                {
                    qty++;
                }
                else
                {
                    qty--;
                    if(qty<0)
                    {
                        qty=0;
                    }
                }
                txtqty.value=qty;
                let response=await doupdateqty(productid,qty);
                //if(response.ok)

                doupdatetotal();
            }

            async function doremovecart(element,productid)
            {
                const x = confirm("Remove from cart?");
                if(x)
                {
                    let response=await doupdateqty(productid,null,"remove");
                    if(response.ok)
                    {
                        document.getElementById("cart_"+productid).remove();

                        checkforemptycart();

                        doupdatetotal();
                    }
                }
            }

            function checkforemptycart()
            {
               /// console.log(document.querySelectorAll("[id*='cart_']").className);
           //     console.log(document.querySelector("[id*='cart_']"));
              //  console.log(document.querySelector("[id*='cart_']"));
                if(document.querySelector("[id*='cart_']")==null)
                {
                    if ("content" in document.createElement("template"))
                    {
                        let cart_empty=document.getElementById("cartempty").content.cloneNode(true);

                        document.getElementById("cartdisplay").appendChild(cart_empty);
                    }
                    
                } 
            }

            function doupdatetotal()
            {
                
                const cartset=document.querySelectorAll("[id*='cart_']");
                
                const totalset={};
                totalset["order"]=0.00;
                totalset["discount"]=0.00;
                totalset["tax"]=0.00;
                totalset["paytotal"]=0.00;
                
                
                for(let cartitem_index=0;cartitem_index<cartset.length;cartitem_index++)
                {   
                    let cartitem=cartset[cartitem_index];
                    const discountrate=parseFloat(cartitem.getAttribute("data-discount"));
                    const taxrate=parseFloat(cartitem.getAttribute("data-tax"));
                    const ordertotal=parseFloat(cartitem.getAttribute("data-price"));
                    const qty=parseFloat(cartitem.querySelector("[id*='qty_']").value);
               
                    const total=ordertotal*qty;
                    totalset["order"]+=total;

                    if(discountrate>0)
                    {
                        totalset["discount"]+=(total *  (discountrate / 100) );
                    }

                    if(taxrate>0)
                    {
                        totalset["tax"]+=(total *  (taxrate / 100) );
                    }
                }

               
                totalset["paytotal"]=totalset["order"]-totalset["discount"];

                const section = document.getElementById("total_section");
                section.querySelector("[data-role='total']").innerHTML=totalset["order"];
                section.querySelector("[data-role='tax']").innerHTML=totalset["tax"];
                section.querySelector("[data-role='discount']").innerHTML=totalset["discount"];
                section.querySelector("[data-role='paytotal']").innerHTML=totalset["paytotal"];
            }

            var signalcontrollset={};
            async function doupdateqty(productid,qty,mode)
            {
               
                let signalcontroller=new AbortController();

                if(signalcontrollset[productid])
                {
                    signalcontrollset[productid].abort();
                }
                
                const formdata = new FormData()
                formdata.set("productid",productid);
                formdata.set("mode","update");
                if(mode == "remove") {
                    formdata.set("mode","remove");
                }
                formdata.set("qty",qty);

                signalcontrollset[productid]=signalcontroller;
                return await window.fetch(
                    "{{ route('cart.action')}}",
                    {
                        method:"POST",
                        body:formdata,
                        credentials:"same-origin",
                        headers:{
                            "X_CSRF_TOKEN":"{{ csrf_token() }} ",
                        },
                        signal:signalcontrollset[productid].signal,
                    }
                )

                response=response.status;
                signalcontrollset[productid]=undefined;

                return response;
            }
            function docheckout()
            {
                var x=confirm("Checkout?");

                if(x)
                {
                    return false;
                }

                return true;
            }
        </script>
        <form method="post" action="{{ route('cart.checkout') }}">
            @csrf
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" id="cartview">
                <!--<div class="text-xl text-slate-700 mb-3">Cart ({{ count($cart) }})</div>-->
                @if(count($cart)>0)
                    <div class="flex flex-col sm:flex-row" >
                        <div class="bg-white w-full sm:w-3/4 rounded-md" id="cartdisplay">
                            @foreach($cart as $product_id=>$qty)
                                @php
                                $product=\App\Models\Item::find($product_id)
                                @endphp
                                <div class="overflow-hidden p-3 w-full" id="cart_{{ $product->id }}" data-price="{{ $product->price }}" data-discount="{{ $product->discount }}"  data-tax="{{ $product->tax }}">  
                                    <div class="p-4">
                                        <div class="flex shadow-sm:rounded-lg ">
                                            <img src="{{ asset('storage/'.$product->photo) }}" class="w-16" onerror="javascript:this.src='https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg';"/>
                                            <div class="w-3/4 ml-5">
                                                <h4 class="text-xl">{{ $product->name }}</h4>
                                                <div class="flex mt-5 justify-baseline ">
                                                    <a href="javascript:;" onclick="javascript:doactioncart(this,'{{ $product->id }}','plus');" class="mt-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg></a>
                                                    <input type="text" id="qty_{{ $product->id }}" value="{{ $qty }}" class="p-1 rounded-md w-16 ml-2 mr-2 text-right"/>
                                                    <a href="javascript:;" onclick="javascript:doactioncart(this,'{{ $product->id }}','minus');" class="mt-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" /></svg></a>
                                                    <a class="text-slate-500 ml-5 mt-1" href="javascript:;"  onclick="javascript:doremovecart(this,'{{ $product->id }}');">Remove</a>
                                                </div>                           
                                            </div>
                                            <!--<div class="text-sm ml-5 mt-1 text-sm justify-end">INR {{ $product->price }}</div>-->
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- SHOPPING SUMMARY AND  CHECK OUT-->
                        <div class="bg-white w-full ml-0 sm:ml-3 sm:w-72 rounded-md p-4" id="total_section">
                            <div class="flex ">
                                <div class="p-4 text-left grow text-slate-500">
                                    Order Total
                                </div>
                                <div class="p-4 text-right w-32" data-role="total">-</div>
                            </div>
                            <div class="flex ">
                                <div class="p-4 text-left grow text-slate-500" >
                                    Tax
                                </div>
                                <div class="p-4 text-right w-32" data-role="tax">-</div>
                            </div>
                            <div class="flex ">
                                <div class="p-4 text-left grow text-slate-500" >
                                    Discount
                                </div>
                                <div class="p-4 text-right w-32" data-role="discount">-</div>
                            </div>
                            <div class="flex ">
                                <div class="p-4 text-left grow text-slate-500">
                                    Payable Total
                                </div>
                                <div class="p-4 text-right w-32" data-role="paytotal">-</div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="flex justify-end mt-3">
                        <div class="w-full  sm:w-72">
                            @auth
                                <button type="submit" class="p-2 text-white rounded-md border border-slate-400 w-full bg-indigo-600 hover:bg-indigo-500" onclick="javascript:docheckout();">Checkout</button>
                            @endauth

                            @guest
                            <a class="block text-center p-2 text-white rounded-md border border-slate-400 w-full bg-indigo-600 hover:bg-indigo-500" href="{{ route('login')}}?ischeckout=true">Login</a>
                            @endguest
                        </div>
                    </div>
                    <!-- TEMPLATE -->
                    <template id="cartempty">
                        <div class="ml-0 sm:ml-3 rounded-md p-4">
                            <div class="flex">
                                <div class="w-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                    </svg>
                                </div>
                                <div class="w-full ml-2">
                                    <div class="flex flex-col">
                                        <div class="text-lg ">
                                            You Shopping Cart Is Empty
                                        </div>
                                        <a href="{{ route('order.products') }}" class="mt-3 w-32 text-center shadow-sm rounded-sm border-2 border-slate-200 after:content-['_↗'] p-1">Shop Now</a>
                                    </div>
                                </div>
                            
                            </div>
                        </div>  
                    </template>
                    <script lanugage="javascript">
                        doupdatetotal();
                    </script>
                @else
                    <div class="bg-white overflow-hidden p-4 w-md">
                        <div class="flex">
                            <div class="w-8">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                            </div>
                            <div class="w-full ml-2">
                                <div class="flex flex-col">
                                    <div class="text-lg ">
                                        You Shopping Cart Is Empty
                                    </div>
                                    <a href="{{ route('order.products') }}" class="mt-3 w-32 text-center shadow-sm rounded-sm border-2 border-slate-200 after:content-['_↗'] p-1">Shop Now</a>
                                </div>
                            </div>
                        
                        </div>
                    </div>  
                @endif
            </div>
        </form>
    </div>
</x-app-layout>