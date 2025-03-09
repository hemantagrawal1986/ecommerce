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
        if(!Schema::hasColumn("items","category_id"))
        {
          Schema::table('items', function (Blueprint $table) {
                $table->unsignedBigInteger("category_id")->nullable();
            });

            
        }

        Schema::table('items', function (Blueprint $table) {
            $table->foreign("category_id")->references("id")->on("categories")->onUpdate("no action")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasColumn("items","category_id"))
        {
            Schema::table('items', function (Blueprint $table) {
                $table->dropForeign(["category"]);
                $table->dropColumn("category_id");
            });
        }
    }
};
