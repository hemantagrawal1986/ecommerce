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
        if(!Schema::hasColumn("order","item_id"))
        {
            Schema::table("order",function(Blueprint $table) {
               
                $table->unsignedBigInteger("item_id")->nullable();
            });
            Schema::table('order', function (Blueprint $table) {
                $table->foreign("item_id")->references("id")->on("items")->onDelete("SET NULL")->onUpdate("NO ACTION");
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
        //Schema::table('order', function (Blueprint $table) {
        //    //
        //});

        if(Schema::hasColumn("order","item_id"))
        {
            Schema::table("order",function(Blueprint $table)
            {
                $table->dropForeign(["item_id"]);
                $table->dropColumn("item_id");
            });
        }
    }
};
