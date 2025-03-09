<?php

namespace App\Http\Controllers;

use App\Models\InvoiceTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceTrackingController extends Controller
{
    public function view()
    {
        $invoicetrackings=InvoiceTracking
                            ::with(["invoice","invoice.user"])
                            ->select()
                            ->addSelect(DB::raw("(select count(1) from `order` where order.invoice_id=invoice_tracking.invoice_id) as 'invoice_orders_count'"))
                            ->where("status","<>","received")
                            ->paginate(env("appconfig.paging.size"));
        
     
        return view("invoice_tracking.view",compact("invoicetrackings"));
    }

    public function update(InvoiceTracking $invoice_tracking,$newstatus)
    {
        switch($newstatus)
        {
            case "ready":
                if(!$invoice_tracking->status=="pending")
                {
                    return response()->json(["type"=>"error","message"=>"Invalid State"]);
                }
            break;

            case "shipped":
                if(!$invoice_tracking->status=="ready")
                {
                    return response()->json(["type"=>"error","message"=>"Invalid State"]);
                }
            break;

            case "received":
                if(!$invoice_tracking->status=="shipped")
                {
                    return response()->json(["type"=>"error","message"=>"Invalid State"]);
                }
            break;
        }

        $invoice_tracking->status=$newstatus;
        $invoice_tracking->save();
    }
}
