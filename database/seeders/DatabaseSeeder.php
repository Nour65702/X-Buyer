<?php

namespace Database\Seeders;

use Database\Factories\offersFactory;
use Database\Seeders\ItemSeeder as SeedersItemSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
   
    public function run()
    {
        $this->call(UserSeeder::class);



        $this->call(CategorySeeder::class);


        
        $this->call(SeedersItemSeeder::class);

        $number_of_Users=0  ;
        $number_of_items=0  ;

        \App\Models\User ::factory($number_of_Users)->create();
        \App\Models\Item ::factory($number_of_items)->create();
        \App\Models\Offer::factory($number_of_items)->create();
        
    }
}
