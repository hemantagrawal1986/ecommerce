<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order') }}
        </h2>
    </x-slot>
    <!-- PARENT VIEW -->
    <div class=" m-5">
        <div class="flex space-x-5">
            <div  class="w-3/12 h-auto  border-2 bg-white text-xl h-3/4">
@php
                $menutree=array();
                $menutree["category"]=array();
                array_push($menutree["category"],"Food"); //explode("|","Food|Electronics|Gadgets");
                array_push($menutree["category"],"Electronics");
                array_push($menutree["category"],"Gadgets");

                $menutree["links"]=array();
@endphp
               
                @foreach($menutree["category"] as $category)
                    <a class=" p-2 text-indigo-700 block cursor-pointer hover:text-indigo-500 text-center">{{ $category }}</a>
                @endforeach

            </div>
            <div class="flex-grow bg-white">
                <div class="flex p-5">
                    <div class="w-20">
                        <img src="https://images.ctfassets.net/ihx0a8chifpc/oPtkn7DsBOsv8aitV1qns/1606c26302d81bab448e3a39581f86b5/lorem-flickr-1280x720.jpg?w=64&q=60&fm=webp"/>
                    </div>
                    <div>
                        <h3 class="text-xl">
                            Royal Canine 1 Kg 
                        </h3>
                        <p>A Cat In the Bag</p>
                        <br/>
                        <button type="button" class="border shadow-sm  text-white  bg-purple-500 px-5 py-2 rounded-sm hover:bg-purple-400">Hello</button>
                    </div>
                </div>
                <div class="flex p-5">
                    <div class="w-20">
                        <img src="https://images.ctfassets.net/ihx0a8chifpc/oPtkn7DsBOsv8aitV1qns/1606c26302d81bab448e3a39581f86b5/lorem-flickr-1280x720.jpg?w=64&q=60&fm=webp"/>
                    </div>
                    <div>
                        <h3 class="text-xl"> 
                            Royal Canine 1 Kg 
                        </h3>
                        <p>A Cat In the Bag</p>
                        <br/>
                        <button type="button" class="border shadow-sm  text-white bg-purple-500 px-5 py-2 rounded-sm hover:bg-purple-400">Hello</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12" style="display:none;">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-5">
            <div class="bg-white  shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                
                    @if($errors->count()>0)
                        <ul>
                            @foreach($errors->all() as $item)
                                <li>{{$item}}</li>
                            @endforeach
                        </ul>
                    @endif
                    <script language="javascript">
                        function dovalidateorder()
                        {
                            var flag=confirm("Do you want to proceed?");
                            
                            if(flag)
                            {
                                return true;
                            }

                            return false;
                        }
                        
                        document.addEventListener('alpine:init', () => {
                            Alpine.data("items",(initialOpenState=false)=>({
                                open: initialOpenState,
                                searchstr:"",
                                data:[],
                                seldata:{},
                                delete:"",
                                search()
                                {
                                    this.open=true;
                                    fetch(' {{route('item.search')}}/'+this.searchstr)
                                    .then(response=>response.json())
                                    .then(data=>this.data=[...data])
                                },
                                setdata(data)
                                {
                                    this.open=false;
                                    
                                    this.seldata={"qty":1,...data};
                                },
                                removeData(data)
                                {
                                    const x=confirm("Delete order");
                                    if(x)
                                    {
                                        this.seldata={};
                                    }
                                },
                                total()
                                {
                                    let cost=this.seldata.qty ?? 0;
                                    cost*=this.seldata.price ?? 0;
                                    
                                    let discount=this.seldata.discount ?? 0;
                                    if(discount>0)
                                    {
                                        cost*=(discount/100);
                                    }
                                    
                                    return new Number(cost).toFixed(2);
                                    
                                },
                                clearOrder(index)
                                {
                                    const x = confirm("Clear Order?");
                                    if(x)
                                    {
                                        this.seldata={};
                                    }
                                }
                            }));

                            Alpine.data("orderlist",()=>({
                                list:[{},{}],
                                init()
                                {
                                    
                                },
                                add()
                                {
                                    this.list.push({});
                                },
                                removeOrder(index)
                                {
                                   
                                    const x = confirm("Remove Order?");
                                    if(x)
                                    {
                                        //console.log(this.list);
                                        //console.log(index);
                                        this.list.splice(index,1);
                                       
                                        //console.log(this.list);
                                
                                    }
                                },
                                
                            }));
                    });
                    </script>

                    <!-- ALPINE JS TRIAL -->
                    <form method="post" action="{{route("order.store")}}" x-data=orderlist autocomplete="off">
                        @csrf
                        <table class="table-auto" width="100%">
                            <thead>
                                <tr>
                                    <th class="border text-left p-4">#</th>
                                    <th class="border text-left p-4">Item</th>
                                    <th class="border text-left p-4">Qty</th>
                                    <th class="border text-left p-4">Discount</th>
                                    <th class="border text-left p-4">Unit Cost</th>
                                    <th class="border text-left p-4">Total Cost</th>
                                    <th class="border text-left p-4"></th>
                                </tr>
                            </thead>
                            <tbody id="datatable" >
                                <template x-for="(listitem,index) in list">
                                    <tr data-row="index" x-data="items"> 
                                        <td class="border p-4" x-text="index+1"></td>
                                        <td class="border p-4" @click.outside="open=false">
                                            
                                            <div  class="relative " >
                                                <input type="text" name="name[]" x-bind:readonly="seldata.id ? 'readonly':null" x-model="searchstr" class="read-only:bg-gray-100 read-only:pointer-events-none border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"  value="Amoxicillin" @input.debounce.500ms="search()" @focus="search()" x-effect="searchstr=(seldata.name ?? '')">
                                                <input type="hidden" name="item[]"  x-model="seldata.id"/>
                                                
                                                <div  x-show="open" class="overscroll-contain z-20 absolute bg-white rounded-sm pt-2 w-full border-gray-300 shadow-md divide-y divide-slate-200 dark:divide-slate-700" >
                                                    <template x-for="item in data">
                                                        <a @click="setdata(item)" x-text="item.name + ' ' +  (item.price ?? '')" class=" p-2 divide-y divide-slate-200 block" style="cursor:pointer !important;"></a>
                                                    </template>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="border p-4">
                                            <input type="text" name="qty[]" x-bind:readonly="seldata.id ? null : 'readonly'" class="read-only:bg-gray-100 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"  x-model=seldata.qty ></td>
                                        </td>
                                        <td class="border p-4"><input type="text" name="discount[]" readonly class="read-only:bg-gray-100 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" x-model=seldata.discount></td></td>
                                        <td class="border p-4"><input type="text" name="unitcost[]" readonly class="read-only:bg-gray-100 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" x-model=seldata.price></td></td>
                                        <td class="border p-4" x-text="total()"></td>
                                        <td class="border p-4">
                                            <template x-if="seldata.id">
                                                <div>
                                                    <button type="button" @click="removeOrder(index)" class="text-blue-800 hover:text-blue-700 pointer" x-text="'Delete'"></button>
                                                    <button type="button" @click="clearOrder(index)" class="ml-1 text-blue-800 hover:text-blue-700 pointer" x-text="'Clear'"></button>
                                                </div>
                                            </template>
                                        </td>

                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <x-primary-button class="mt-3" type="submit" onclick="javascript:return dovalidateorder();">
                            {{ __('save') }}
                        </x-primary-button>
                        <x-primary-button class="ml-3" type="button" @click="add()">
                            {{ __('Add') }}
                        </x-primary-button>
                        <br/><br/>
                        <div class="grid grid-cols-4 gap-4">
                            <div class="shadow-1 rounded-md border-2 h-40">
                                <img class="w-full aspect-ratio" src="https://spotlight.tailwindui.com/_next/image?url=%2F_next%2Fstatic%2Fmedia%2Favatar.51a13c67.jpg&w=128&q=80"/>
                                <h3>Food Bowl Container</h3>
                                <x-primary-button>
                                    Buy
                                </x-primary-button>
                            </div>
                            <div>01</div>
                            <div>01</div>
                            <div>09</div>
                        </div>
                    </form>
                </div>
            </div>
        </div> 
    </div>
</x-app-layout>
