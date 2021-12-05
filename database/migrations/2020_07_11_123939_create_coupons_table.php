<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100)->unique();
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->double('amount')->nullable();
            $table->double('min_order_amount')->nullable();
            $table->double('max_discount_amount')->nullable();
            $table->double('shipping_discount')->nullable();
            $table->boolean('general')->nullable();
            $table->boolean('is_disposable')->default(true);
            $table->integer('number')->nullable();
            $table->enum('status', ['disable', 'enable'])->default('disable');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
