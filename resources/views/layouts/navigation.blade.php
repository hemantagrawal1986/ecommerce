<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                

                <!-- Navigation Links -->
                 @auth
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @php 
                    /*
                    <x-nav-link :href="route('order.view')" :active="request()->routeIs('order.view')">
                        {{ __('Order') }}
                    </x-nav-link>
                    */
                    @endphp
                    <!--<x-nav-link :href="route('wallet.view')" :active="request()->routeIs('wallet.view')">
                        {{ __('Wallet') }}
                    </x-nav-link>-->
                    <!--<x-nav-link :href="route('item.view')" :active="request()->routeIs('item.view')">
                        {{ __('Item') }}
                    </x-nav-link>-->
                    <!--<x-nav-link :href="route('settings.view')" :active="request()->routeIs('settings.view')">
                        {{ __('Setup') }}
                    </x-nav-link>-->
                    <x-nav-link :href="route('order.products')" :active="request()->routeIs('order.products')">
                        {{ __('Shop Now') }}
                    </x-nav-link>
                </div>
                @endauth
            </div>
            <script language="javascript">
                var dosearchitem_controller = null
                async function dosearchitem(element,event)
                {   
                    //let className=document.getElementById("searchitem").className;
                    if(dosearchitem_controller)
                    {
                        dosearchitem_controller.abort();
                    }

                    
                    document.getElementById("searchitem").className=document.getElementById("searchitem").className.replace(/hidden/g,"");
                    //console.log(document.getElementById("searchitem").className);
                    
                    let value = element.value;
                    if(value.length > 2)
                    {
                        dosearchitem_controller = new AbortController();
                        let response=await window.fetch(" {{ route('order.itemsearch') }}?searchstr="+encodeURIComponent(value),{
                            method:"POST",
                            credentials:"same-origin",
                            headers:{
                                "X-CSRF-TOKEN":"{{ csrf_token() }} "
                            },
                            signal:dosearchitem_controller.signal,
                        });

                        
                    //    console.log(response);
                        response=await response.text();
                        document.getElementById("searchitem").innerHTML=response

                    }

                    
                }

                function hidedosearchitem()
                {   
                    let classname=document.getElementById("searchitem").className;
                    classname.replace(/hidden/g,"");
                    classname+=" hidden";
                    document.getElementById("searchitem").className=classname;
                }
            </script>
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <div class="px-1 pt-1 position-relative">
                        <input autocomplete="off" type="text" name="txtsearch" value="" class="inline-flex p-1 rounded-lg border-indigo-400 focus:border-indigo-700  transition duration-150 ease-in-out" onkeyup="javascript:dosearchitem(this,event);" onfocus="javascript:dosearchitem(this,event);" onblur="javascript:hidedosearchitem(this);"/>
                        <div class="hidden absolute bg-white transition transition-duration-150 ease-in-out border-md rounded-md border-indigo-200 w-80 h-64 mt-5 shadow-md max-h-64 overflow-auto" id="searchitem">
                            
                        </div>
                    </div>
                </div>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            
                           
                            @guest 
                            <div>Guest</div>
                            @endguest
                            @auth
                            <div>{{ Auth::user()->name }}</div>
                            @endauth
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <a href="{{ route('cart.view') }}" onclick="javascript:event.stopPropagation();" class="relative">
                                
                             
                                @if(\App\Models\Cart::current())
                                    <div class="absolute p-1 bg-red-600 animate-pulse rounded-full right-[0px] top-[-4px]"></div>
                                @endif
                                <div class="ml-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                    </svg>
                                </div>
                            </a>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @guest
                        <x-dropdown-link :href="route('login')">
                            {{ __('Login') }}
                        </x-dropdown-link>
                        @endguest
                        @auth 
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                        @endauth
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @guest
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ __("Guest") }}</div>
            </div>
            
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('login')">
                    {{ __('login') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            @endguest
            @auth
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            @endauth
        </div>
    </div>
</nav>
