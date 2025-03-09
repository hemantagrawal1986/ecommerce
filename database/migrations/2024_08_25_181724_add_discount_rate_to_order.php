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
        if(!Schema::hasColumn("order","discount_rate")) {
            Schema::table('order', function (Blueprint $table) {
                $table->float("discount_rate")->nullable();
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
        if(Schema::hasColumn("order","discount_rate")) {
            Schema::table('order', function (Blueprint $table) {
                $table->dropColumn("discount_rate");
            });
        }
    }
};
