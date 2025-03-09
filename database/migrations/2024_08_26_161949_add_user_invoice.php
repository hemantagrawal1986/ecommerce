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
        if(!Schema::hasColumn("invoice","user_id"))
        {
           Schema::table('invoice', function (Blueprint $table) {
                $table->unsignedBigInteger("user_id")->nullable();
            });
        }
        if(Schema::hasColumn("invoice","user_id")) {
            Schema::table('invoice', function (Blueprint $table) {
                $table->foreign("user_id")->references("id")->on("users")->onDelete("SET NULL")->onUpdate("NO ACTION");
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
        if(Schema::hasColumn("invoice","user_id"))
        {
            Schema::table('invoice', function (Blueprint $table) {
                $table->dropForeign(["user_id"]);
                $table->dropColumn("user_id");
            });
        }
        
    }
};
