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
        if(!Schema::hasColumn("items","description"))
        {
            Schema::table('items', function (Blueprint $table) {
                $table->string("description",255)->nullable();
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
        if(Schema::hasColumn("items","description"))
        {
            Schema::table('items', function (Blueprint $table) {
                $table->dropColumn("description");
            });
        }
    }
};
