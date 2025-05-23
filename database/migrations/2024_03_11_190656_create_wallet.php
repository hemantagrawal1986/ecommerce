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
        Schema::create('wallet', function (Blueprint $table) {
            $table->id();
            $table->float("amount")->default(0);
            $table->unsignedBigInteger("user_id")->nullable();
            $table->timestamps();
        });

        Schema::table("wallet",function (Blueprint $table) {
            $table->foreign("user_id")->references("id")->on("users")->onUpdate("NO ACTION")->onDelete("SET NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("wallet");
      
    }
};
