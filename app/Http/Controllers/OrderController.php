<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\CategoryGroup;
use App\Models\Item;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

use Closure;

class OrderController extends Controller
{
    //
    public function __construct() {

    }

    public function view() {
        
    }

    public function store(Request $request)
    {
      
        $request->validate([
            "name"  => [
                    "required","array","min:1",
                    function (string $attribute, mixed $value, Closure $fail) 
                        {
                            if( (count(request("name")) == (count(request("qty")) == count(request("unitcost")) )) ) {}
                            else {
                                $fail("Invalid parameters 1");
                            }
                        }],
            "qty"  => [
                        "required","array","min:1",
                        function (string $attribute, mixed $value, Closure $fail) 
                        {
                            if( (count(request("name")) == (count(request("qty")) == count(request("unitcost")))) ) {}
                            else {
                                $fail("Invalid parameters 2 ".count(request("name"))."----".count(request("qty"))."----".count(request("unitcost")) );
                            }
                        }
                    ],
            "item"=>[
                "required","array","min:1",

                function (string $attribute, mixed $value, Closure $fail) 
                {
                    if( (count(request("name")) == (count(request("qty")) == count(request("unitcost")))) ) {}
                    else {
                        $fail("Invalid parameters 2 ".count(request("name"))."----".count(request("qty"))."----".count(request("unitcost")) );
                    }
                }
            ],
           // "unitcost"  => [
             //       "required","array","min:1",
               //     function (string $attribute, mixed $value, Closure $fail) 
                 //   {
                   //     if( (count(request("name")) == (count(request("qty")) == count(request("unitcost"))) ) ) {}
                     //   else{
                       //     $fail("Invalid parameters 3");
                       // }
                   // }
            //],

            "name.*"=>"required",
            "qty.*"=>"required|numeric",
          //  "unitcost.*"=>"required",            
        ],[
            "name.required"=>":attribute is required",
            "name.*.required"=>":attribute is empty",
            "qty.*.required"=>":attribute is required",
           // "unitcost.*.required"=>":attribute is required",
        
        ]);

        $items=collect(request("name"));
        $prices=collect(request("unitcost"));
        $qty=collect(request("qty"));
        $itemrefs=collect(request("item"));
        $discounts=collect(request("discount"));
        
        $invoice=(new Invoice());
        $invoice->invoice_number=0;
        $invoice->user_id=auth()->user()->id;
        $invoice->save();

        collect(request("name"))->each(function($item,$index) use($items,$prices,$qty,$itemrefs,$invoice,$discounts)
        {
           
            Order::create([
                "item"=>$items->get($index),
                "price"=>$prices->get($index),
                "quantity"=>$qty->get($index),
                "item_id"=>$itemrefs->get($index),
                "discount_rate"=>$discounts->get($index),
                "invoice_id"=>$invoice->id,
            ]);
        });

        //$orders=Order::where(function($query)
       // {
         //   $query->where("invoice_id","=","0")->orWhereNull("invoice_id");
        
       // });
        
        //if($orders->count()>0)
        //{
            //$invoice=(new Invoice());
          //  $invoice->invoice_number=0;
         //   $invoice->save();

            
          //  $orders->get()->each(function($order) use ($invoice)
           // {
             //   $order->update(["invoice_id"=>$invoice->id]);
            //});
        //}

        return view("order.confirm",
                                [
                                    "invoice"=>
                                    $invoice
                                ]
                    );
    }

    public function products()
    {
        //$categories=Category::with(["category_group:id,name"])->orderBy("name")->where("status",1)->orderBy("name")->get();
        $category_groups=CategoryGroup::with(["categories:id,name,category_group_id,status"])
                        ->orderBy("name")
                        ->where("status",1) 
                        ->orderBy("name")
                        ->get();

        $products=Item::where("active",1)
                        ->when(request("category"),function($query)
                        {
                            $query->where("category_id",request("category"));
                        })
                        ->orderBy("name")->paginate();

        
        //$cartuser=Cart::forCurrentUser();
        $cart=Cart::current();
        
        
        
        return view("order.products",compact("category_groups","products","cart"));
    }

    public function cart(Item $item)
    {
        if(!auth()->check())
        {
            //log data in session
            //guest user section   
            $cart=session()->get("cart",array());
          
            if(!isset($cart[$item->id]))
            {
                $cart[$item->id]=0;
            }
            $cart[$item->id]++;
            session(["cart"=>$cart]);  //flush cart when the user is available as a login  
        }
        else
        {
            //add qty in cart table
            $cart=Cart::forCurrentUser()->where("item_id",$item->id)->first();
            if($cart === NULL)
            {
                $cart=new Cart();
                $cart->item_id=$item->id;
                $cart->user_id=auth()->user()->id;
                $cart->qty=0;
            }
            $cart->qty++;
            $cart->save();
        }
    }

    public function itemsearch()
    {
       // echo "<br> reqest ".request("searchstr");
       // DB::enableQueryLog();
        $items=Item::where("name","like","%".request("searchstr")."%")->orderBy("name")->get();
        if(auth()->check())
        {
            $cartitems=Cart::forCurrentUser()->select(["id","qty"])->get();
            //echo "i amh ere";
            $cart=array();
            foreach($cartitems as $item)
            {
                $cart[$item->id]=$item->qty;
            }
        }
        else
        {
            $cart=session("cart",[]);
           
        }
     //   dd(DB::getQueryLog());
        
        //session("skip_debug",true);
        //echo "<br> item ".count($items);
        
        return view("order.itemsearch",compact("items","cart"));
    }

    public function recommend(Item $item)
    {
        $protocol = \App\DB\GraphConnector::connect();
        //$response = $response->logon(['scheme' => 'basic', 'principal' => 'neo4j', 'credentials' => 'neo4j']);

        $query="MATCH";
        $query.="(buyer:User)-[p:PURCHASE ]->(item:Item)";
        $query.="<-[cobuy:PURCHASE]-(cobuyer:User)";
        $query.=" where item.id <> ".$item->id."";
        $query.=" and item.category=".$item->category_id."";
        if(auth()->guest()) {}
        else
        {
        //$query.=" AND buyer.name <> '".auth()->user()->name."'";
        }
      //  $query.=" AND item.category=".$item->category_id."";
        $query.=" return item,count(item) as frequency order by frequency desc";

        //echo $query;

        $protocol
          ->run($query)
          ->pull();

        $recommends=array();
        foreach ($protocol->getResponses() as $response) {
            if($response->getMessage() == "PULL")
            {
                //echo "<hr/>";
               // var_dump($response);

                //echo "<hr/>";

                foreach($response->getContent() as $content)
                {
                    ob_start();
                    echo $content;
                    $data=ob_get_clean();

                    $data=json_decode($data,true);
                    if(is_array($data))
                    {
                         //echo json_encode($data["properties"]);
                         $recommends[]=\App\Models\Item::find($data["properties"]["id"]);
                    }
                   
                  
                }
            }
            
         }
        // echo json_encode( $recommends);

         return view("partial.order.recommend",compact("recommends"));

    }
}
