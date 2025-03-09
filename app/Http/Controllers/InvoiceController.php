<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function __construct() {

    }

    public function view(Invoice $invoice)
    {
        return view("invoice.view",compact("invoice"));
    }
}
