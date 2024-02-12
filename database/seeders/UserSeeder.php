<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
/**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $amgad=['first_name'=>'Amgad',
        'last_name' =>'ALwattar',
        'email'     =>'amgad.wr.1@gmail.com',
        'password'  => Hash::make(123456),
        'phone'     =>'+963945623246',
        'img'       =>'/storage/images/users/amgad.jpg'];

        $aseel=[ 'first_name'=>'Aseel',
        'last_name' =>'Dibi',
        'email'     =>'aseel@gmail.com',
        'password'  => Hash::make(123456),
        'phone'     =>'+963955776688',
        'img'       =>'/storage/images/users/aseel.jpg'];

        $ayahm=['first_name'=>'ayham',
        'last_name' =>'hamami',
        'email'     =>'Ayham@gmail.com',
        'password'  => Hash::make(123456),
        'phone'     =>'+963944778855',
        'img'       =>'/storage/images/users/ayham.jpg' ];

        $nour= [ 'first_name'=>'nour', 
        'last_name' =>'alshikh',
        'email'     =>'nour@gmail.com', 
        'password'  => Hash::make(123456),
        'phone'     =>'+963944556633',  
        'img'       =>'/storage/images/users/nour.jpg'  ];
    
    // User::factory()->times(10)->create();
        User::create($amgad);
        User::create($aseel);
        User::create($ayahm);
        User::create($nour );
    }
}
