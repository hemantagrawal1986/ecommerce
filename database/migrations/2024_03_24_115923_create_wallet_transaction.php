<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable("wallet_transaction")) {
            Schema::create('wallet_transaction', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->unsignedBigInteger("user_id")->nullable();
                $table->unsignedBigInteger("wallet_id")->nullable();
                $table->string("type",10)->nullable()->default("credit");
                $table->float("amount");
                $table->string("notes",128)->nullable();
            });
        }


        if(Schema::hasTable("wallet_transaction")) {
            Schema::table("wallet_transaction",function(Blueprint $table) {
                $table->foreign("user_id")->references("id")->on("users")->onUpdate("NO ACTION")->onDelete("SET NULL");
                $table->foreign("wallet_id")->references("id")->on("wallet")->onupdate("NO ACTION")->onDelete("SET NULL");
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("wallet_transaction");
    }
};
