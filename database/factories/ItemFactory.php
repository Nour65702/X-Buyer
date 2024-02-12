<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use Carbon\Carbon;

class ItemFactory extends Factory
{
    protected $model =Item::class;

    public function definition()
    {

        $photo= $this->faker->image('public/storage/images/items_fake',400,300, null, false) ;
        $expiration_date=$this->faker->dateTimeBetween('now', '2022-6-2')->format('d-m-Y');
        return [
                'title'              => $this->faker->word(),
                'expiration_date'    => $expiration_date,
                'user_id'            => rand(1,4),
                'categorie_id'       => rand(1,6),
                'contact_information'=>'+963'. $this->faker->phoneNumber,
                'quantity'           =>$this->faker->randomDigit,
                'price'              => $this->faker->numberBetween($min = 500, $max = 8000),
                'Total_product_life' =>Carbon::now()->diffInDays(Carbon::parse($expiration_date) ),
                'img'               =>'/storage/images/items_fake/'.$photo        
            ];    
 
    }
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}

 