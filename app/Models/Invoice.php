<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Invoice extends Model
{
    use HasFactory;
    protected $table="invoice";

    
    protected static function booted()
    {
        static::created(function ($invoice) {
            //
           // if(invoice_number)
           if($invoice->invoice_number==0)
           {
            
            $appsequence=AppSequence::getSequence(); //first();
            $appsequence->increment("invoice",1);
            //$invoice->invoice_number = $invoice->id;
            $invoice->invoice_number=$appsequence->invoice;
            $invoice->saveQuietly();
           }
            //create 
            InvoiceTracking::create([
                "status"=>"pending",
                "invoice_id"=>$invoice->id,
            ]);
        });
    }

    public function orders()
    {
        return $this->hasMany(Order::class,"invoice_id","id");
    }

    public function user()
    {
        return $this->belongsTo(User::class,"user_id","id");
    }
}
