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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("item",255);
            $table->float("price")->default(0)->nullable();
            $table->float("tax")->default(0)->nullable();
            $table->float("discount")->default(0)->nullable();
            $table->float("quantity")->default(0);
            $table->float("final")->default(0);
            $table->unsignedBigInteger("created_by")->nullable();
        });

        Schema::table('order', function (Blueprint $table) {
            $table->foreign("created_by")->references("id")->on("users")->onUpdate("NO ACTION")->onDelete("SET NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->dropIfExists("order");
        });
    }
};
