<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Offer;
use Carbon\Carbon;

class OfferFactory extends Factory
{
    protected $model =Offer::class;
    public function definition()
    {
        static $number = 2;
        return [
            'item_id'   => $number++,
            'Days1'      => rand(1,35),
            'Discount1' => rand(1,35),
            'Days2'      => rand(36,65),
            'Discount2' => rand(36,65),
            'Days3'      => rand(66,99),
            'Discount3' => rand(66,99),   
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

 