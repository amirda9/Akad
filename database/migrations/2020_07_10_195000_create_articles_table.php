<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('slug');
            $table->text('short_description');
            $table->text('full_description')->nullable();
            $table->text('image')->nullable();
            $table->boolean('published')->default(true);
            $table->boolean('can_comment')->nullable();
            $table->boolean('can_rate')->nullable();
            $table->foreignId('user_id');
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
        Schema::dropIfExists('articles');
    }
}
