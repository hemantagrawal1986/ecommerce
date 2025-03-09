<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wallet') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <table class="table-auto" width="100%">
                    <thead>
                        <tr>
                            <th class="border text-left p-8 p-4">Date</th>
                            <th class="border text-left p-8 p-4">Description</th>
                            <th class="border text-left p-8 p-4">Credit (+)</th>
                            <th class="border text-left p-8 p-4">Debit (-)</th>
                            <th class="border text-left p-8 p-4">Balance</th>
                            <th class="border text-left p-8 p-4">User ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        
                        $grandtotal["balance"]="0.00";
                        $grandtotal["credit"]="0.00";
                        $grandtotal["debit"]="0.00";

                        @endphp
                        @foreach($wallet->transaction as $transaction)
                        
                        <tr>
                            <td class="border text-left p-8 p-4">{!! nl2br($transaction->created_at->format("d M Y\nH:i:s")) !!}</td>
                            <th class="border text-left p-8 p-4">
                                @if($transaction->description)
                                    {!! $transaction->description !!}
                                @else
                                    @if($transaction->type=="credit")
                                        Credit
                                        
                                    @else 
                                        Debit
                                        @php $grandtotal["balance"]-=$transaction->amount; @endphp
                                    @endif
                                @endif
                            </td>
                            @if($transaction->type=="credit")
                                <td class="border text-left p-8 p-4">{{ $transaction->amount }}</td>
                                <td class="border text-left p-8 p-4"></td>
                                @php $grandtotal["balance"]+=$transaction->amount; @endphp
                            @else
                                <td class="border text-left p-8 p-4"></td>
                                <td class="border text-left p-8 p-4">{{ $transaction->amount }}</td>
                                @php $grandtotal["balance"]+=$transaction->amount; @endphp
                            @endif
                            
                            <td class="border text-left p-8 p-4">{{ $grandtotal["balance"] }}</td>
                            <td class="border text-left p-8 p-4">{{ $transaction->transactor->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                
            </div>
        </div>
    </div>
</x-app-layout>


    