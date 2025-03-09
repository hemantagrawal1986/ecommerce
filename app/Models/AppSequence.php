<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSequence extends Model
{
    use HasFactory;

    protected $table="app_sequence";

    public static function getSequence()
    {
       if(AppSequence::count()==0)
       {
            AppSequence::factoy()->create();
       }

       return AppSequence::first();
    }
}
