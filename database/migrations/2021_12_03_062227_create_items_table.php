<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('categorie_id')->unsigned()->index();
            $table->string('img');
            $table->string('contact_information'); //phone or facebook
            $table->string('expiration_date');     //تاريخ انتهاء الصلاحية
            $table->integer('quantity');
            $table->float('price');
            $table->float('new_price')->nullable();
            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);
            $table->integer('Total_product_life')->nullable();
            $table->integer('Number_Of_Remaining_Day')->nullable();
            $table->timestamps();

            $table->foreign('user_id')     ->references('id')->on('users')     ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
}
