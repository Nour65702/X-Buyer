<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Offers extends Migration
{
    public function up()
    {
            Schema::create('offers', function (Blueprint $table) 
            {
                $table->increments('id');
                $table->integer('item_id')->unsigned()->index();
                $table->float('Days1');
                $table->float('Discount1');
                $table->float('Days2');
                $table->float('Discount2');
                $table->float('Days3');
                $table->float('Discount3');
                $table->timestamps();

            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade')->onUpdate('cascade');
            
            });
    }
    
    
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
