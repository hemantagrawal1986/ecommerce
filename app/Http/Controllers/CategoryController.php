<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryGroup;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function __construct() {

    }

    public function view(CategoryGroup $categoryGroup=NULL) 
    {
        //DB::enableQueryLog();
        $categoryGroup_all = CategoryGroup::orderBy("name")->get();
        $categories=Category::with("category_group")->where(function($query) use ($categoryGroup)
        {
            $query->when($categoryGroup,function($query) use ($categoryGroup)
            {
                $query->where("category_group_id",$categoryGroup->id);
            });
        })->get();

       // dd(DB::getQueryLog());

        return view("category.view",compact("categories","categoryGroup_all","categoryGroup"));
    }

    public function create(Request $request) {
    
        $categoryGroup_all = CategoryGroup::orderBy("name")->get();

        return view("category.create",compact("categoryGroup_all"));
    }

    public function store(CategoryRequest $request) {
        
       // $request->validate([
       //     "categorygroup"=>"required|exists:category_group,id",
       //     "category"=>"required|unique:categories,name",
         //   "status"=>"required|in:active,inactive",
       // ]);

        Category::create([
            "name"=>$request->get("category"),
            "status"=>$request->get("status"),
            "category_group_id"=>$request->get("categorygroup"),
        ]);
        return redirect(route("category.view"),);
    }

    public function edit(Category $category,Request $request) {
        
        $categoryGroup_all = CategoryGroup::orderBy("name")->get();

        return view("category.edit",compact("categoryGroup_all","category"));
    }

    public function update(Category $category,CategoryRequest $request) {
        
        $category->update([
            "name"=>$request->get("category"),
            "status"=>$request->get("status"),
            "category_group_id"=>$request->get("categorygroup"),
        ]);

        return redirect(route("category.view"));
    }
}
