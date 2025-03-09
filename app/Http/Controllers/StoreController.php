<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __construct() {

    }

    public function items()
    {
        $items=array();
        return view("store.item",compact("item"));
    }
}
