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
        Schema::table('wallet', function (Blueprint $table) {
            $table->string("name",255);
            $table->tinyInteger("default")->default(0);
            $table->string("description",512)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(!Schema::hasColumns("wallet",["name","default","description"]))
        {
            Schema::table('wallet', function (Blueprint $table) {
                $table->dropColumn("name");
                $table->dropColumn("default");
                $table->dropColumn("description");
            });
        }
        
    }
};
