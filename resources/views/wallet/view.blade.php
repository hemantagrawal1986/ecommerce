<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wallet') }}
        </h2>
    </x-slot>
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
                <div class="max-w-xl">
                    <form method="post" action="{{route("wallet.view")}}" >
                        @csrf
                        <div>
                            <b>Total Wallets ({{ $wallets->count() }})</b>
                            &nbsp;
                            <a href="{{route('wallet.transact')}}">Transact</a>
                        </div>
                       
                        <table class="table-auto" width="100%">
                            <thead>
                                <tr>
                                    <th class="border text-left p-8 p-4">#<a href="{{route("wallet.create")}}">Add</a></th>
                                    <th class="border text-left p-8 p-4">Name</th>
                                    <th class="border text-left p-8 p-4">Balance</th>
                                    <th class="border text-left p-8 p-4"></th>
                                    <th class="border text-left p-8 p-4">Default</th>
                                    <th class="border text-left p-8 p-4">History</th>
                                </tr>
                            </thead>
                            <tbody id="datatable">
                                @foreach($wallets as $wallet)
                                    <tr>
                                        <td class="border text-left p-8 p-4">{{$loop->index+1}}</td>
                                        <td class="border text-left p-8 p-4">{{$wallet->name}}</td>
                                        <td class="border text-left p-8 p-4">{{$wallet->amount}}</td>
                                        <td class="border text-left p-8 p-4">
                                            <a href="{{ route('wallet.transact',$wallet->id) }}">Transact</a>
                                        </td>
                                        <td class="border text-left p-8 p-4">{{$wallet->default == 0?"N":"Y"}}</td>
                                        <td class="border text-left p-8 p-4">
                                            <a href="{{ route('wallet.history',$wallet->id) }}">({{$wallet->transaction_count}}) View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>