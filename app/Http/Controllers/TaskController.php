<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function __construct() {}

    public function view()
    {
        $tasks = Task::orderBy("name");

        return view("task.view",compact("tasks"));
    }
}
