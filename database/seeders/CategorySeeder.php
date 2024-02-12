<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create( ['categorie_name'=>'Food'         ,'id'=>1]);
        Category::create( ['categorie_name'=>'Drinks'       ,'id'=>2]);
        Category::create( ['categorie_name'=>'Medicine'     ,'id'=>3]);
        Category::create( ['categorie_name'=>'Detergent'    ,'id'=>4]);
        Category::create( ['categorie_name'=>'Self Care'    ,'id'=>5]);
        Category::create( ['categorie_name'=>'Others'       ,'id'=>6]);
    }
}
    