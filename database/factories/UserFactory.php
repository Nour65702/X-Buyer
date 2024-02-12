<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model =User::class;
    
    public function definition()
    {
        $photo= $this->faker->image('public/storage/images/users_fake/',400,300, null, false) ;
        return [
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password'  => Hash::make(123456),
            'remember_token' => str::random(10),
            'phone' => $this->faker->e164PhoneNumber() ,
            'img'=>	   '/storage/images/users_fake/'.$photo        

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
