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
        if(!Schema::hasColumn("items","photo"))
        {
            Schema::table('items', function (Blueprint $table) {
                $table->string("photo",128)->nullable();
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
        if(Schema::hasColumn("item","photo"))
        {
            Schema::table('items', function (Blueprint $table) {
                $table->dropColumn("photo");
            });
        }
    }
};
