<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $table="wallet";


    public function scopeMine($query)
    {
        $query->where("user_id",auth()->user()->id);
    }

    public function transaction()
    {
        return $this->hasMany(WalletTransaction::class,"wallet_id","id");
    }
}
