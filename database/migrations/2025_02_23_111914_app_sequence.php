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
        if(!Schema::hasTable("app_sequence"))
        {
            Schema::create("app_sequence",function (Blueprint $table)   
            {
                $table->id();
                $table->integer("invoice")->nullable();  
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
        //
    }
};
