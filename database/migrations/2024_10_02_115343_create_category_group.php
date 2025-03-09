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
        if(!Schema::hasTable("category_group")) {
            Schema::create('category_group', function (Blueprint $table) {
                $table->id();
                $table->string("name",128)->nullable();
                $table->integer("order")->nullable()->default(0);
                $table->tinyInteger("status")->default(1);
                $table->timestamps();
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
        if(!Schema::hasTable("category_group")) {
            Schema::dropIfExists("category_group");
        }
    }
};
