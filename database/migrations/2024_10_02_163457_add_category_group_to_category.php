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
        if(!Schema::hasColumn("categories","category_group_id")) {
            Schema::table('categories', function (Blueprint $table) {
                $table->unsignedBigInteger("category_group_id")->nullable();
            });
        }
        
        Schema::table('categories', function (Blueprint $table) {
            $table->foreign("category_group_id")->references("id")->on("category_group")->onDelete("set null")->onUpdate("no action");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasColumn("categories","category_group_id")) {   
            Schema::table('categories', function (Blueprint $table) {
                $table->dropForeign(["category_group_id"]);
                $table->dropColumn("category_group_id");
            });
        }
    }
};
