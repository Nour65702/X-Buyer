<?php

use App\Http\Controllers\API\AuthApiController;
use App\Http\Controllers\API\ItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register',                           [AuthApiController::class, 'register'      ]);
Route::post('/login',                              [AuthApiController::class, 'login'         ]);
Route::get('/get_Categories',                      [ItemController   ::class, 'get_Categories']);

/*_______________________________________________________________________________________________*/
Route::middleware('auth:api')->group( function(){
    Route::post('/logout',                             [AuthApiController::class,'logout'                   ]);
    /*_____________________________________________________________________________________________________*/
    Route::post('/add_Item',                           [ItemController   ::class, 'addItem'                 ]);
    Route::post('/update_item/{id}',                   [ItemController   ::class, 'updateitem'              ]);
    Route::post('/delete_Item/{id}',                   [ItemController   ::class, 'deleteItem'              ]);
    Route::post('/Discount_Items_And_Show',            [ItemController   ::class, 'discount_items_And_Show' ]);
    /*_____________________________________________________________________________________________________*/
    Route::get('/my_products',                         [ItemController   ::class, 'myproducts'              ]);//يمكن باي  
    Route::get('/Sort_ASC',                            [ItemController   ::class, 'Sort_ASC'                ]);
    Route::get('/Sort_DESC',                           [ItemController   ::class, 'Sort_DESC'               ]);
    Route::get('/search_By_Name/{name}',               [ItemController   ::class, 'searchByName'            ]);
    Route::get('/search_By_Cat/{searchByCATE}',        [ItemController   ::class, 'searchByCATE'            ]);
    Route::get('/search_By_Expir_date/{expir_date}',   [ItemController   ::class, 'search_Expir_Date'       ]);
    /*______________________________________________________________________________________________________*/
    Route::get ('/Add_View/{item_id}',                 [ItemController   ::class, 'Add_View'                ]);
    
    Route::get ('/AddLike/{item_id}',                  [ItemController   ::class, 'AddLike'                 ]);
    Route::get ('/UnLike/{item_id}',                   [ItemController   ::class, 'UnLike'                  ]);
    Route::get ('/Get_Items_Liked',                    [ItemController   ::class, 'Get_Items_Liked'         ]);
    
    Route::post('/add_Comment/{item_id}',              [ItemController   ::class, 'addComment'              ]);
    Route::post('/remove_Comment/{comm_id}',           [ItemController   ::class, 'removeComment'           ]);
    Route::get ('/Show_Comments/{item_id}',            [ItemController   ::class, 'ShowComments'            ]);      
});




