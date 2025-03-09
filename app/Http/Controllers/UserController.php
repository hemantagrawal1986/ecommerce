<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function __construct() {

    }

    public function view()
    {
        $users=User::cursorPaginate(5);
        return view("user.view",compact("users"));
    }
}
