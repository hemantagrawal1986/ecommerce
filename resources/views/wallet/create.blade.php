<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wallet') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <form method="post" action="{{ route('wallet.store') }}">
                    @csrf
                    <div class="max-w-xl space-y-6">
                       
                        <div>
                            <x-input-label for="name" :value="__('Wallet Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')"/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    
                
                        <div>
                            <x-input-label for="amount" :value="__('Wallet Amount')" />
                            <x-text-input id="name" name="amount" type="text" class="mt-1 block w-full" :value="old('amount')"/>
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="default">
                                <x-text-input id="default" name="default" type="checkbox"  />&nbsp;Default
                            </x-input-label>
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                       
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>