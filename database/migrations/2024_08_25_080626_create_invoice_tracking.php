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
        if(!Schema::hasTable("invoice_tracking")) {
            Schema::create('invoice_tracking', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger("invoice_id")->nullable();
                $table->string("status",10)->nullable();
                $table->timestamps();
            });

            Schema::table('invoice_tracking', function (Blueprint $table) {
                $table->foreign("invoice_id")->references("id")->on("invoice")->onUpdate("NO ACTION")->onDelete("SET NULL");
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
        Schema::dropIfExists("invoice_tracking");
    }
};
