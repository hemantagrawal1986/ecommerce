<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use HasFactory;

    protected $table="categories";

    protected $guarded=[];

    public function category_group()
    {
        return $this->belongsTo(CategoryGroup::class,"category_group_id","id")->withDefault(["name"=>"UNASSIGNED"]);
    }

    public function items()
    {
        return $this->hasMany(Item::class,"category_id","id");
    }

    public function getNewStatusAttribute()
    {
       
        
        if($this->status == "1")
        {
            return "active";
        }
        else if($this->status  == "2")
        {
            return "inactive";
        }
        //else if($this->istrashed())
        //{
          //  return "deleted";
       // }
        else
        {
            return "inactive";
        }
    }

    public function setStatusAttribute($value)
    {
        $value=strtolower($value);
        if($value == "active")
        {
            $value="1";
        }
        else if($value == "inactive")
        {
            $value="2";
        }
        else
        {
            $value="3";
        }

        $this->attributes["status"]=$value;
    }
}
