<?php

namespace App\Models;

use App\Notifications\OrderCreated;
use App\Notifications\InvoiceTrackingUpdate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class InvoiceTracking extends Model
{
    use HasFactory;

    protected $guarded=[];

    protected $table="invoice_tracking";

    protected static function booted()
    {
        static::created(function ($invoicetracking) {
          
            auth()->user()->notify(new OrderCreated($invoicetracking->invoice()->first()));
        });

        static::updated(function ($invoicetracking) {
          
            //auth()->user()->notify(new OrderCreated($invoicetracking->invoice()->first()));
            if($invoicetracking->isDirty("status"))
            {
                optional($invoicetracking->invoice()->first()->user()->first())->notify(new InvoiceTrackingUpdate($invoicetracking));
            }
        });
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class,"invoice_id","id");
    }
}