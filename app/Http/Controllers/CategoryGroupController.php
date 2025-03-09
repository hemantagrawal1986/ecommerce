<?php

namespace App\Http\Controllers;

use App\Models\CategoryGroup;
use Illuminate\Http\Request;

class CategoryGroupController extends Controller
{
    public function __construct() {

    }
    public function view()
    {
        $categoryGroups = CategoryGroup::withCount("categories")->orderBy("name")->get();  
        return view("category_group.view",compact("categoryGroups"));
    }

    public function create() {
        return view("category_group.create");
    }

    public function store(Request $request) {
        CategoryGroup::create([
            "name"=>$request->get("category"),
            "order"=>$request->get("order"),
            "status"=>$request->get("status"),
        ]); 

        
        
        return redirect(route("category_group.view"))->with(
        [
            "type"=>"success",
            "message"=>"Category Group Has Been Added",
        ]);
    }

    public function edit(CategoryGroup $categoryGroup) {
        

        return view("category_group.edit",compact("categoryGroup"));
    }

    public function update(CategoryGroup $categoryGroup,Request $request) {
        $categoryGroup->update([
            "name"=>$request->get("category"),
            "order"=>$request->get("order"),
            "status"=>$request->get("status"),
        ]); 

        return redirect(route("category_group.view"))->with(
        [
            "type"=>"success",
            "message"=>"Category Group Has Been Updated",
        ]);
    }
}
