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
        if(!Schema::hasColumn("categories","status"))
        {
            Schema::table('categories', function (Blueprint $table) {
                $table->tinyInteger("status")->default(1)->nullable();
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
        if(Schema::hasColumn("categories","status"))
        {
            Schema::dropColumns("categories","status");
        }
    }
};
