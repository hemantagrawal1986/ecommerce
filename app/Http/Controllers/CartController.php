<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Item;
use App\Models\Order;
use App\Models\Invoice;

class CartController extends Controller
{
    public function __construct() {

    }

    public function view()
    {
        $cart = Cart::current();
        
        return view("cart.view",compact("cart"));
    }

    public function action()
    {
        switch(request("mode"))
        {
            case "update":
                Cart::action("update",request("productid"),request("qty",1));
                break;
            
            case "remove":
                Cart::action("remove",request("productid"));
                break;
        }
    }

    public function checkout()
    {
        //code to flush cart and create invoice
        $cart_collection=Cart::forCurrentUser()->with("item")->where("qty",">",0)->get();

        $invoice=new Invoice;
        $invoice->user_id=auth()->user()->id;
        $invoice->invoice_number=0;
        $invoice->total=0;
        $invoice->balance=0;
        $invoice->save(); //event to add new tracking id is in the model event of Invoice model

        if(count($cart_collection)>0)
        {
                       
            foreach($cart_collection as $cart)
            {
                $total=0.00;
                $total+=round($cart->item->price,2);
                $total*=$cart->qty; //tax pending
                $total=round($total,2);

                $discount=0.00;
                if($cart->item->discount>0)
                {
                    $discount+=$total;
                    $discount*=($cart->item->discount/100);
                }

                $tax=0.00;
                if($cart->item->tax>0)
                {
                    $tax+=$total;
                    $tax*=($cart->item->tax/100);
                    $tax=round($tax,2);
                }
                $total+=$tax;

                $final=0.00;
                $final+=round($total,2);
                $final-=round($discount,2);


                Order::create([
                    "item"=>$cart->item->name,
                    "price"=>$cart->item->price,
                    "quantity"=>$cart->qty,
                    "item_id"=>$cart->item_id,
                    "discount"=>$discount,
                    "discount_rate"=>$cart->item->discount,
                    "invoice_id"=>$invoice->id,
                    "final"=>$final,
                    "tax_rate"=>$cart->item->tax,
                    "tax"=>$tax,
                ]);
                
             
                $invoice->total+=$final;
                $invoice->balance+=$final;

              
                $cart->forceDelete();
            }
        }

        $invoice->save();
       
        return view("order.confirm",compact("invoice"));
    }
}
