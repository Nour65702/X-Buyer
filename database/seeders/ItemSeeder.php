<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Offer;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run()
    {
        $Kent=
        [
            'title'              =>'Kent',
            'user_id'            => 1,
            'categorie_id'       => 6,
            'contact_information'=> '+963945623246',
            'expiration_date'    =>'22-2-2022',
            'quantity'           =>'15',
            'price'              =>'4000',
            'Total_product_life' =>Carbon::now()->diffInDays(Carbon::parse('22-2-2022') ),
            'img' =>'/storage/images/items/kent.jpg'  ,
            'views'=>1,

        ];
        
         $Kent_offer=
         [
             'item_id'                       =>  1,
             'Days1'                         => 25,
             'Discount1'                     => 25,
             'Days2'                         => 50,
             'Discount2'                     => 50,
             'Days3'                         => 75,
             'Discount3'                     => 75,
         ];

        $Kent_views = //للمنتج من صاحب المنتج  viewانشاء  
         [
          'item_id'                =>1,
          'user_id'                =>1
         ];

         $chocolate=
         [
            'title'              =>'chocolate',
            'user_id'            => 2,
            'categorie_id'       => 1,
            'contact_information'=> '+963993433122',
            'expiration_date'    =>'1-2-2022',
            'quantity'           =>'15',
            'price'              =>'4000',
            'Total_product_life' =>Carbon::now()->diffInDays(Carbon::parse('1-2-2022') ),
            'img' =>'/storage/images/items/chocolate.jpg'  ,
            'views'=>1,
        ];
        $chocolate_offer=
        [
            'item_id'                       =>  2,
            'Days1'                         => 25,
            'Discount1'                     => 25,
            'Days2'                         => 50,
            'Discount2'                     => 50,
            'Days3'                         => 75,
            'Discount3'                     => 75,
        ];
        $chocolate_views = //للمنتج من صاحب المنتج  viewانشاء  
        [
         'item_id'                =>2,
         'user_id'                =>2
        ];

        Item ::create($Kent);            
          Item ::create($chocolate);
        Offer::create($Kent_offer);        Offer::create($chocolate_offer);
        View ::create($Kent_views);        View ::create($chocolate_views);
    }
}
