<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;
use Illuminate\Support\Facades\Http;
use App\Models\CategoryGroup;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DevStoreSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //return Command::SUCCESS;
       
        if(!(env("APP_ENV")=="local"))
        {
            echo "Valid Only For Local / Development Environment";
            return Command::FAILURE;
        }
        
        $preference=array();
        $preference["existinginactive"]="n";
        $preference["existinginactive"]= $this->ask('Would you like to make inactive existing items?(Y/n)',"n");

        echo "\nSetting up default store";
        //dev site configure api block
        if(strtolower($preference["existinginactive"])=="y")
        {
            Item::where("active",1)->getQuery()->update(["active"=>0]);
        }

        $response = Http::get('https://fakestoreapi.com/products');
        foreach($response->json() as $item)
        {
            //echo $item["title"];
            $item=json_decode(json_encode($item),false);

            $category_group=CategoryGroup::where("name",$item->category)->first();
            if($category_group === NULL)
            {
                $category_group=new CategoryGroup;
                $category_group->name=$item->category;
                $category_group->id=$category_group->save();
            }

           // echo "<br> category group id first ".$category_group->id;;
        
           // DB::enableQueryLog();
            $category=Category::where("name",$item->category)->whereHas("category_group",function($query) use($category_group)
            {
                $query->where("id",$category_group->id);
            })->first();
            //echo json_encode(DB::getQueryLog())."<br/>";
           // echo "<br> category group id ".$category_group->id;;

            if($category === NULL)
            {
                $category=new Category;
                $category->name=$item->category;
                $category->category_group_id=$category_group->id;
                $category->id=$category->save();
            }

            //echo json_encode($category);
            
            $dbitem=Item::where("name",$item->title)->whereHas("category",function($query) use($category,$category_group)
            {
                $query->where("id",$category->id);
                $query->whereHas("category_group",function($query) use ($category_group)
                {
                    $query->where("id",$category_group->id);
                });
            })->first();

            if($dbitem === NULL)
            {
                $dbitem=new Item;
            }

           // $photo=Http::get($item->image);

            
            $dbitem->category_id=$category->id;
            $dbitem->name=$item->title;
            $dbitem->description=$item->description;
            $dbitem->price=$item->price; //selling price
            $dbitem->purchasecost=$item->price; //cost price
            $dbitem->tax=0;
            $dbitem->active=1;
            $dbitem->rating=$item->rating->rate;
            $dbitem->save();

            Storage::disk("public")->delete("item/".$dbitem->id);

            //echo file_get_contents($item->image);
            
            $dbitem->photo=Storage::disk("public")->putFileAs("item/".$dbitem->id,$item->image,basename($item->image));
            $dbitem->save();
        }

        echo "\nDefault store setup done";
    }
}
