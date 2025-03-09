<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order') }}
        </h2>
    </x-slot>
    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                <div class="text-xl text-green-900">
                    Order Has Been Placed Order# {{ $invoice->id }}
                </div>
                <div class="mt-1 text-md text-gray-900">
                    You will receive an email of order confirmation. As the order is ready to be dispatched, we will inform you.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>