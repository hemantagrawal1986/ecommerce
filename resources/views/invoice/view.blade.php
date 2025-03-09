<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        
        <!-- Scripts -->
        @vite(['resources/css/app.css'])
    </head>
    <body class="font-sans text-gray-900 antialiased ">
        <div class=" flex flex-col items-center pt-6  bg-gray-100 ">
            <div class="p-5 rounded-lg bg-white w-full h-screen">
                <div class="flex">
                    <div class="w-2/5">
                        <img src="https://laravel.com/img/notification-logo.png"/>
                    </div>
                    <div class="w-3/5">
                        <div class="flex">
                            <div class="w-2/4 text-right font-bold">Invoice #</div>
                            <div class="w-2/4 whitespace-nowrap ml-4">{{ $invoice->invoice_number}}</div>
                        </div>
                        <div class="flex">
                            <div class="w-2/4 text-right font-bold">Invoice Date</div>
                            <div class="w-2/4 whitespace-nowrap ml-4">Aug 25 2024</div>
                        </div>
                    </div>
                </div>
                <div class="flex mt-5">
                    <div class="w-3/6">
                        <div class="text-2xl">Billing Address</div>
                        <div class="text-lg font-bold">Hemant Agrawal</div>
                        <div class="text-md w-2/5">
                            A/5 Arunodaya Apts, Behind KES School, Kalina,
                            Santacruz (East) Mumbai 98
                        </div>
                    </div>
                    <div class="w-3/6">
                        <div class="text-2xl">Shipping Address</div>
                        <div class="text-lg font-bold">Hemant Agrawal</div>
                        <div class="text-md w-2/5">
                            A/5 Arunodaya Apts, Behind KES School, Kalina,
                            Santacruz (East) Mumbai 98
                        </div>
                    </div>
                </div>
                

                <div class="mt-10">
                    <div class="border-t">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class=" text-left p-2">#</th>
                                    <th class=" text-left p-2">Item</th>
                                    <th class=" text-left p-2">Qty</th>
                                    <th class=" text-left p-2">Unit Cost</th>
                                    <th class=" text-left p-2">Discount Rate</th>
                                    <th class=" text-left p-2">Discount Value</th>
                                    <th class=" text-left p-2">Total Cost</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                
                                
                                @foreach($invoice->orders()->get() as $order)
                                    <tr>
                                        <td class=" p-2">{{$loop->index + 1}}</td>
                                        <td class=" p-2">{{$order->item()->first()->name}}</td>
                                        <td class=" p-2">{{$order->quantity}}</td>
                                        <td class=" p-2">{{$order->price}}</td>
                                        <td class=" p-2">{{$order->discount_rate}}</td>
                                        <td class=" p-2">{{$order->discount}}</td>
                                        <td class=" p-2">{{$order->final}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                  
                </div>
            </div>
        </div>
    </body>
</html>

