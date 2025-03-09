<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wallet') }}
        </h2>
    </x-slot>
    <script language="javascript">
        function dovalidate()  {
            
        }
    </script>
    <div class="py-12">
        @if(session("type"))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <h3>{{ session("message") }}</h3>
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <form method="post" action="{{ route('wallet.use') }}">
                    @csrf
                    <div>
                        <x-input-label for="name" :value="__('Wallet')" />
                        <select name="wallet" class="block w-full">
                            <option value="" selected>Select</option>
                            @foreach($wallets as $wallet)
                              
                                <option value="{{ $wallet->id }}" wallet-balance="{{$wallet->amount}}" {{($wallet->id==old("wallet",optional($desiredwallet)->id))?"selected":""}}>{{$wallet->name}} {{$wallet->amount}}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('wallet')" class="mt-2" />
                    </div><br/>
                    <div>
                        <label>
                            <input type="radio" name="type" value="debit" :checked="(old('type')=='debit':'checked':'')">&nbsp;WithDraw
                        </label>
                        &nbsp;&nbsp;<label>
                            <input type="radio" name="type" value="credit" :checked="(old('type')=='debit':'checked':'')">&nbsp;Deposit
                        </label>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div><br/>
                    <div>
                        <x-input-label for="amount" :value="__('Wallet Amount')" />
                        <x-text-input id="amount" name="amount" type="text" class="mt-1 block w-full" :value="old('amount')"/>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        
                    </div><br/>
                    <div class="flex items-center gap-4">
                        <x-primary-button onclick="javascript:return dovalidate(this);">{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>