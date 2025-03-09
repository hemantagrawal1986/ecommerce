<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Http\Requests\ItemRequest;
use App\Models\CategoryGroup;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use App\Models\Cart;

class ItemController extends Controller
{
    public function __construct() {

    }

    public function view()
    {
        $categories=Category::with(["category_group:id,name"])->where("status","1")->orderBy("name")->get();
        $items = Item::with(["category:name,id,category_group_id","category.category_group:name,id"])->orderBy("name")
                ->when(request("category"),function($query)
                {
                    $query->where("category_id",request("category"));
                })
                ->when(request("chktrashed"),function($query)
                {
                    return $query->withTrashed();
                })
                ->paginate(config("appconfig.paging.size"));
                
          return view("item.view",compact("items","categories"));
    }

    public function create() 
    {
        $categories=Category::with(["category_group:name,id"])->where("status","1")->orderBy("name")->get();
        return view("item.create",compact("categories"));
    }

    public function store(ItemRequest $request) {
       // $request->validate([
         //   "name"=>"required|unique:items",
           // "price"=>"numeric",

        //]);

     

        $item = new Item();
        $item->name=$request->name;
        $item->description=$request->description;
        $item->category_id=$request->category;
        $item->price=$request->price;
        $item->discount=$request->discount;
        $item->purchasecost=$request->purchasecost;
        $item->tax=$request->tax;
        $item->save();

        $item->photo=optional($request->file("photo"))->storeAs("item/".$item->id,$request->file("photo")->getClientOriginalName(),"public");
        $item->save();

       

        return redirect(route("item.view"))->with("type","success")->with("message","Item created successfully");

    }

    public function edit(Item $item) {
        
        $category_groups=CategoryGroup::where("status",'1')->orderBy("name")->get();
        $categories=Category::with(["category_group:name,id"])->orderBy("name")->where("status","1")->orderBy("name")->get();

        //echo "i am here ".$request->route("item")->id;
        return view("item.edit",compact("item","category_groups","categories"));
    } 

    public function update(ItemRequest $request,Item $item) {
        
        $item->name=$request->name;
        $item->description=$request->description;
        $item->category_id=$request->category;
        $item->price=$request->price;
        $item->discount=$request->discount;
        $item->purchasecost=$request->purchasecost;
        $item->tax=$request->tax;
        $item->save();

        if($request->file("photo") !== NULL)
        {
            if($item->photo !== NULL)
            {
                if(Storage::exists("item/".$item->id,$item->photo))
                {
                    Storage::disk("public")->delete("item/".$item->id."/".$item->photo);
                }
            }

            $item->photo=optional($request->file("photo"))->storeAs("item/".$item->id,$request->file("photo")->getClientOriginalName(),"public");
            $item->save();
        }
        return redirect(route("item.view"))->with("type","success")->with("message","Item created successfully");
    } 

    public function delete(Item $item) {
        $item->delete();

        return redirect(route("item.view"))->with("type","success")->with("message","Item Deleted Successfully");
    } 

    public function deletephoto(Item $item)
    {
        if($item->photo !== NULL)
        {
            if(Storage::disk("public")->exists("item/".$item->id,$item->photo))
            {
                Storage::disk("public")->delete("item/".$item->id."/".$item->photo);
            }

            $item->photo=NULL;
            $item->save();
        }
    }
    
    public function restore(Item $item) {
        $item->restore();
        return redirect(route("item.view"))->with("type","success")->with("message","Item Restored Successfully");
    } 

    public function search($searchstr=NULL)
    {
        return Item::when($searchstr,function($query) use ($searchstr) {
            $query->where("name","like","%".$searchstr."%");
        })
        ->get()->toArray();
    }

    public function info(Item $product)
    {
        $cart=Cart::current();
        return view("item.info",compact("product","cart"));
    }
}
