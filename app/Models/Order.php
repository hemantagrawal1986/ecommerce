<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table="order";

   // protected $fillable=["*"];
    protected $guarded=[];


    protected static function booted()
    {
        static::creating(function ($order) {
            $total="0.00";
            $total+=$order->quantity;
            $total*=$order->price;
            $discount_rate=round($order->discount_rate/100,2);
            $discount=round($total*$discount_rate,2);
            $total-=$discount;
            $order->discount=$discount;
            $order->final=$total;
        });
    }

    public function items()
    {
        return $this->belongsTo(Item::class,"item_id","id");
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class,"invoice_id","id");
    }
}
