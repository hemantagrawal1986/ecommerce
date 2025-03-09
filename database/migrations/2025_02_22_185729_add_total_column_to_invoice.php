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
        
        Schema::table('invoice', function (Blueprint $table) {
            if(!Schema::hasColumn("invoice","total"))
            {
                $table->float("total")->nullable();
            }

            if(!Schema::hasColumn("invoice","balance"))
            {
                $table->float("balance")->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('invoice', function (Blueprint $table) {
           
        });
    }
};
