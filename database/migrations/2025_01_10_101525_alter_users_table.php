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
        Schema::table('users',function(Blueprint $table){
            $table->string('restaurant_name')->after('password');
            $table->string('restaurant_email')->after('restaurant_name');
            $table->string('restaurant_phone')->after('restaurant_email');
            $table->string('restaurant_logo')->after('restaurant_phone');
            $table->string('restaurant_theme')->after('restaurant_logo');
            $table->string('restaurant_address')->after('restaurant_theme');                      
        });
    }   

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders',function(Blueprint $table){
            $table->dropColumn('restaurant_name');
            $table->dropColumn('restaurant_email');
            $table->dropColumn('restaurant_phone');
            $table->dropColumn('restaurant_logo');
            $table->dropColumn('restaurant_theme');
            $table->dropColumn('restaurant_address');            
        });
    }
};
