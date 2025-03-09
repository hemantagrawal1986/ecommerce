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
        Schema::table('order', function (Blueprint $table) {
            $table->unsignedBigInteger("invoice_id")->nullable();
        });

        Schema::table("order",function(Blueprint $table)
        {
            $table->foreign("invoice_id")->references("id")->on("invoice")->onUpdate("NO ACTION")->onDelete("SET NULL");
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
            $table->dropForeign(["invoice_id"]);
            $table->dropColumn("invoice_id");
        });
    }
};
