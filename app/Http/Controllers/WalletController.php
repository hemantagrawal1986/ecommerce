<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Wallet;
use App\Models\WalletTransaction;

class WalletController extends Controller
{
    public function __construct() {

    }

    public function view()
    {
        $wallets=Wallet::withCount("transaction")->get();
       
        return view("wallet.view",compact("wallets"));
    }

    public function create()
    {
        return view("wallet.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "name"=>["required",Rule::unique("wallet")->where(function($query)
            {
                $query->where("user_id",auth()->user()->id);
            })],
            "amount"=>["required","numeric"]
        ]);

        $wallet=new Wallet();
        $wallet->name=request("name");
        $wallet->amount=request("amount");
        $wallet->user_id=auth()->user()->id;
        $wallet->default=request("default")?1:0;
        $wallet->save();

        return redirect(route("wallet.view"))->with(["type"=>"success","message"=>"Congratulations! A New Wallet Has Been Added"]);
    }

    public function transact(Wallet $desiredwallet=NULL)
    {
        $wallets=Wallet::mine()->orderBy("name")->get();
        return view("wallet.transact",compact("wallets","desiredwallet"));
    }

    public function use(Request $request) 
    {
        $request->validate([
            "type"=>"required|in:debit,credit",
            "amount"=>"required|numeric",
            "wallet"=>"required",
        ]);

        $wallet=Wallet::findOrFail(request("wallet"));

        $walletbalance=$wallet->amount;
        if(request("type") == "debit") {
            $walletbalance-=request("amount");
            if($walletbalance-request("amount")<0)
            {
                return back()->with(["type"=>"error","message"=>"Wallet Does Not Have Enough Balance For Withdrawal"]);
            }
        }
        else {
            $walletbalance+=request("amount");
        }

        
        
        $walletTransaction=new WalletTransaction();
        $walletTransaction->user_id=auth()->user()->id;
        $walletTransaction->type=request("type");
        $walletTransaction->amount=request("amount");
        $walletTransaction->wallet_id=$wallet->id;
        $walletTransaction->save();

        $wallet->amount=$walletbalance;
        $wallet->save();
    

        return redirect(route("wallet.view"))->with(["type"=>"success","message"=>"Congratulations! You Just Used Your Wallet"]);
    }

    public function history(Wallet $wallet)
    {
        $wallet->load("transaction","transaction.transactor");
        return view("wallet.history",compact("wallet"));
    }
}
