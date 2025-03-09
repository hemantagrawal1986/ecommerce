<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $table="wallet_transaction";

    public function wallet()
    {
        return $this->belongsTo(Wallet::class,"wallet_id","id");
    }

    public function transactor()
    {
        return $this->belongsTo(User::class,"user_id","id");
    }
}
