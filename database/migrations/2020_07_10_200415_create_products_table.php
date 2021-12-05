<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->nullable();
            $table->string('type')->nullable();
            $table->text('title');
            $table->text('en_title')->nullable();
            $table->text('slug');
            $table->text('image')->nullable();
            $table->integer('order')->default(0);
            $table->foreignId('brand_id')->nullable();
            $table->boolean('can_rate')->nullable();
            $table->boolean('can_comment')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('full_description')->nullable();
            $table->longText('product_helper')->nullable();
            $table->boolean('manage_stock')->nullable();
            $table->boolean('sold_individually')->nullable();
            $table->integer('stock')->nullable();
            $table->string('stock_status')->nullable();
            $table->integer('min_stock')->nullable();
            $table->boolean('published')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('can_order')->default(true);
            $table->integer('min_order')->nullable();
            $table->integer('max_order')->nullable();
            $table->double('weight')->nullable();
            $table->double('regular_price')->nullable();
            $table->double('sale_price')->nullable();
            // $table->unsignedBigInteger('product_size_helper')->nullable();
            $table->text('video')->nullable();
            $table->bigInteger('views')->default(0);
            $table->timestamps();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
