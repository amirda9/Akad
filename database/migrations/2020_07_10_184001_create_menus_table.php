<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('menu_id');
            $table->foreignId('parent_id')->nullable();
            $table->string('title');
            $table->string('icon_class')->nullable();
            $table->text('link')->nullable();
            $table->foreignId('menu_itemable_id')->nullable();
            $table->string('menu_itemable_type')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('new_page')->default(false);
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
        Schema::dropIfExists('menus');
        Schema::dropIfExists('menu_items');
    }
}
