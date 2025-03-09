<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use function Ramsey\Uuid\v1;

class Cart extends Model
{
    use HasFactory;
    protected $table="cart";
    
    public function user()
    {
        return $this->belongsTo(User::class,"user_id","id")->withDefault([
            "name"=>"guest"
        ]);
    }

    public function item()
    {
        return $this->belongsTo(Item::class,"item_id","id")->withDefault([
            "name"=>"Unknown"
        ]);
    }

    public static function forUser($userid)
    {
        return Cart::where("user_id",$userid);
    }

    public static function forCurrentUser()
    {
        return static::forUser(auth()->user()->id);
    }

    public static function current()
    {
        if(auth()->check())
        {
            $cartitems=Cart::forCurrentUser()->select(["item_id","qty"])->get();
            //echo "i amh ere";
            $cart=array();
            foreach($cartitems as $item)
            {
                $cart[$item->item_id]=$item->qty;
            }
        }
        else
        {
            $cart=session("cart",[]);
           
        }

        return $cart;
    }

    public static function action($action,$itemid,$quantity=1)
    {
        if(auth()->check())
        {
            //DB::enableQueryLog();
            $cartitem=Cart::forCurrentUser()->where("item_id",$itemid)->first();
            //dd(DB::getQueryLog());
            if($cartitem === NULL)
            {
                $cartitem=new Cart();
                $cartitem->item_id=$itemid;
                $cartitem->save();
            }
            //echo "<br> actin ".$action;
            switch($action)
            {
               case "update":
                    $cartitem->qty=$quantity;
                    $cartitem->save();
                break;
                    
                case "remove":
                    $cartitem->forceDelete();
                    break;
            }

            
        }
        else
        {
            $cart=session("cart",[]);

            if(!isset($cart[$itemid]))
            {
                $cart[$itemid]=0;
            }
            
            switch($action)
            {
                
                case "update":
                    $cart[$itemid]=$quantity;
                    break;
                    
                case "remove":
                    unset($cart[$itemid]);
                    break;
            }
            session()->put("cart",$cart);
        }
    }

    public static function syncSession($clear_session=true)
    {
        if(auth()->check())
        {
           $cart=session("cart",[]);

           foreach($cart as $cartitem=>$qty)
           {
                $cart=Cart::forCurrentUser()->where("item_id",$cartitem)->first();
                if($cart===NULL)
                {
                    $cart=new Cart();
                    $cart->user_id=auth()->user()->id;
                    $cart->username=auth()->user()->name;
                    $cart->item_id=$cartitem;
                    $cart->qty=$qty;
                    $cart->save();
                }
                else
                {
                    $cart->increment("qty",$qty);
                }
           }

            session()->forget("cart");
        }
    }
}
