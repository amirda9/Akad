<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->text('en_name')->nullable();
            $table->text('slug')->nullable();
            $table->text('logo')->nullable();
            $table->text('image')->nullable();
            $table->text('short_description')->nullable();
            $table->text('full_description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('published')->default(true);
            $table->boolean('featured')->default(false);
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->bigInteger('views')->default(0);
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
        Schema::dropIfExists('brands');
    }
}
