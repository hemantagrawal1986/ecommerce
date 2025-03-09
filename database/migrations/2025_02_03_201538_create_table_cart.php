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
        if(!Schema::hasTable("cart"))
        {
            Schema::create('cart', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger("item_id")->nullable();
                $table->unsignedFloat("qty")->nullable();
                $table->string("username",128)->nullable();
                $table->unsignedBigInteger("user_id")->nullable();
                $table->timestamps();
            });
        }

        Schema::table('cart', function (Blueprint $table) {
            $table->foreign("item_id")->references("id")->on("items")->onDelete("set null")->onUpdate("no action");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("set null")->onUpdate("no action");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("cart");

        /*
        if(Schema::hasColumns("cart",array("item_id","user_id")))
        {
            Schema::table('cart', function (Blueprint $table) {
                $table->dropForeign(["item_id"]);
                $table->dropForeign(["user_id"]);
                $table->dropColumn(["user_id","item_id"]);
            });
        }
        */
    }
};
