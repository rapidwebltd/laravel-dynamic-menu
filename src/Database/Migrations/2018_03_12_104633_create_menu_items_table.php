<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ldm_menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id')->index();
            $table->integer('parent_id')->index();
            $table->string('name');
            $table->string('menuable_type')->index();
            $table->integer('menuable_id')->index();
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
        Schema::drop('menu_items');
    }
}
