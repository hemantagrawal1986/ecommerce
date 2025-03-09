<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order') }}
        </h2>
    </x-slot>
    <div class="py-12">
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="text-lg font-medium text-gray-900">Order Information</div>
            <div class="p-6 text-gray-900">

                <form method="post" action="{{route("order.store")}}" >
                        @csrf
                    <table class="table-auto" width="100%">
                        <thead>
                            <tr>
                                <th class="border text-left p-8 p-4">Item</th>
                                <th class="border text-left p-8 p-4">Qty</th>
                                <th class="border text-left p-8 p-4">Unit Cost</th>
                                <th class="border text-left p-8 p-4"></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    {{ $data->links() }}
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
