<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enum\StatusEnum;

class CategoryGroup extends Model
{
    use HasFactory;

    protected $table="category_group";

    protected $guarded=[];

    

    public function categories()
    {
        return $this->hasMany(Category::class,"category_group_id","id");
    }

    public function getStatusAttribute($value)
    {
       
        if($value == "1")
        {
            return "active";
        }
        else if($value == "2")
        {
            return "inactive";
        }
        else if($this->istrashed())
        {
            return "deleted";
        }
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
