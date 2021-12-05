<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
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
            $table->foreignId('user_id')->nullable();
            $table->string('code');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile');
            $table->text('address');
            $table->text('province');
            $table->text('city');
            $table->text('postal_code')->nullable();
            $table->text('description')->nullable();
            $table->string('shipping');
            $table->double('shipping_price');
            $table->double('discount')->default(0);
            $table->double('shipping_discount')->default(0);
            $table->string('status')->nullable();
            $table->string('is_approved');
            $table->foreignId('coupon_id')->nullable();
            $table->string('payment')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->double('paid_price')->default(0);
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
}
