<x-app-layout>
    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pending Orders ('.$invoicetrackings->total().')')  }}
        </h2>
    </x-slot>
    <script language="javascript">
        

         document.addEventListener('alpine:init', () => {
            Alpine.data("tracking",(initial_id,initial_status)=>({
                id:initial_id,
                status:initial_status,
                status_types:{
                    "pending":"ready",
                    "ready":"shipped",
                    "shipped":"received",
                },
                busy:false,
                async action() {
                    
                
                    if(this.status_types[this.status])
                    {
                        this.busy=true;
                        let response=await fetch("{{ route('invoice_tracking.update')}}/"+this.id+"/"+this.status_types[this.status])
                        this.busy=false;
                        if(response.ok)
                        {
                            let json=response.json;
                            this.status=this.status_types[this.status]; //json.newStatus;
                            
                        }
                    }
                },
                trackingActionLabel(status)
                {
                    if(this.busy) {
                        return "Saving...";
                    }
                    if(status == "pending")
                        return "Pack";
                    else if(status== "ready")
                        return "Ship Now";
                    else if(status == "shipped")
                        return "Receive";
                    else if(status == "received")
                        return "Received";
                },
                getActionBackground(status)
                {
                    if(this.busy)
                        return "bg-slate-300 text-dark disabled hover:cursor-progress"
                    
                    if(status == "pending")
                        return "bg-red-700 text-white hover:bg-red-500";
                    else if(status== "ready")
                        return "bg-yellow-700 text-dark hover:bg-yellow-500";
                    else if(status == "shipped")
                        return "bg-green-700 text-white hover:bg-orange-500";
                    else if(status == "received")
                        return "bg-green-700 text-white hover:bg-green-500";
                }
            }));
         })
    </script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">

                <table class="table-auto" width="100%">
                    <thead>
                        <tr>
                            <th class="border-b-2 p-2 text-center w-1/6">#</th>
                            <th class="border-b-2 p-2 text-center w-1/6">Invoice #</th>
                            <th class="border-b-2 p-2 text-right w-1/6">Amount</th>
                            <th class="border-b-2 p-2 text-right w-1/6">Balance</th>
                            <th class="border-b-2 p-2 text-center w-1/6">Items</th>
                            <th class="border-b-2 p-2 text-center w-1/6">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($invoicetrackings as $invoicetracking)
                        <tr x-data="tracking({{$invoicetracking->id}},'{{$invoicetracking->status}}')">
                            <td class="border-b-2 p-2 text-center">{{ $loop->index+1 }} </td>
                            <td class="border-b-2 p-2 text-center">
                                <a href="{{ route('invoice.view',$invoicetracking->invoice->id ) }}" rel="external" target="_blank" class="text-indigo-500 hover:text-indigo-700">
                                    {{$invoicetracking->invoice->invoice_number }}
                                </a>
                            </td>
                            <td class="border-b-2 p-2 text-right">{{$invoicetracking->invoice->total }} </td>
                            <td class="border-b-2 p-2 text-right">{{$invoicetracking->invoice->balance }} </td>
                            <td class="border-b-2 p-2 text-center">{{ $invoicetracking->invoice_orders_count }} </td>
                            
                            <td class="border-b-2 p-2 " align="center">
                                <a @click="action()" x-bind:class="getActionBackground(status)" x-text="trackingActionLabel(status)" class="w-3/5 rounded-md  border-1  px-1 py-1 text-center block  hover:cursor-pointer" ></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>