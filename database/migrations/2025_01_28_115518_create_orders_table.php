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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable();
            $table->foreignId('seat_id')->constrained()->onDelete('cascade')->nullable();
            $table->foreignId('area_id')->constrained()->onDelete('cascade')->nullable();
            $table->string('table_number')->nullable();
            $table->enum('order_type',['Dinein','Takeaway','Delivery'])->default('Dinein');
            $table->string('delivery_name')->nullable();
            $table->string('delivery_phone')->nullable();
            $table->string('delivery_email')->nullable();
            $table->string('takeaway_name')->nullable();
            $table->string('takeaway_phone')->nullable();
            $table->string('takeaway_email')->nullable();
            $table->string('ready_time')->nullable();
            $table->text('address')->nullable();
            $table->text('notes')->nullable();
            $table->double('shipping',10,2)->nullable();
            $table->double('total',10,2)->nullable();
            $table->enum('payment',['paid','not paid'])->default('not paid');
            $table->enum('status',['running','pending','shipped','delivered'])->default('running');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
