<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Offer;
use App\Models\Item;
use App\Models\like;
use App\Models\View;

use Carbon\Carbon;

class ItemController extends Controller { 

    function get_Views($item_id){ // عل اغلب باي 
      
        
        $Item_Views = View::all()->where('item_id',$item_id);
        $number_of_views=count($Item_Views);

        $item= Item::where('id', $item_id)->first();
                    $item->views=$number_of_views;
                    $item->save();
// dd($number_of_views);
        return response()->json([
            'status'  =>'1',
            'views' => $number_of_views
        ]);
    }
// __________________________________________________________________________________________________________


function getViewss($item_id){ // باي

    $views = View::all()->where('item_id',$item_id);
    
    $number_of_veiws=count($views);
   
    return $number_of_veiws;
}

// _____________________________________________________________________________________________________________________________________________


public function itemDetails($id){ //باي

    $item = Item::find($id);
    $category=Category::find($item->categorie_id);

    return response()->json([
        'status' =>'1',
        'details'=> $item,
        'cat name'=> $category->categorie_name,
    ]);
}
// __________________________________________________________________________________________________________

function get_Likes($item_id)// يمكن باي
{ 

      $item= Item::where('id', $item_id)->first();
      $number_of_Likes=$item->likes;

      return response()->json([
          'status'  =>'1',
          'Likes' => $number_of_Likes
      ]);
}
 // __________________________________________________________________________________________________________



//  Route::get ('/getLikes/{item_id}',                 [ItemController   ::class, 'get_Likes'               ]);//باي
//  Route::get('/item_Details/{id}',                   [ItemController   ::class, 'itemDetails'             ]);//باي
//  Route::get ('/get_Views/{item_id}',                [ItemController   ::class, 'get_Views'               ]);//باي
 



}
 // $destination_path = 'public/images/users';
        // $img=$request->file('img');
        // $img_name=$img->getClientOriginalName();
        // $path=str_replace('public','/storage',$request->file('img')->storeAs($destination_path,$img_name));    //        http://127.0.0.1:8000/storage/images/users/amgad.jpg 
        // $path=str_replace('public','/storage/public',$request->file('img')->storeAs($destination_path,$img_name));    http://127.0.0.1:8000/public/storage/images/users/amgad.jpg 
        // $path=$request->file('img')->storeAs($destination_path,$img_name);                                            http://127.0.0.1:8000/public/images/users/amgad.jpg
        
                    // 'img'       => str_replace('\\','/', $path_photo),
    //$path_photo= base_path().'\\storage\\app\\'.$request->file('img')->store('users_images');



//<مشان لبعدين ازا بدا تعديل الصورة بس حاليا عل كب
 $img=$request->file('img');
 $img_name=$img->getClientOriginalName();
 $path=str_replace('public','/storage',$request->file('img')->storeAs($destination_path,$img_name));    //        http://127.0.0.1:8000/storage/images/users/amgad.jpg 
 $path=str_replace('public','/storage/public',$request->file('img')->storeAs($destination_path,$img_name));   // http://127.0.0.1:8000/public/storage/images/users/amgad.jpg 
 $path=$request->file('img')->storeAs($destination_path,$img_name);                                           // http://127.0.0.1:8000/public/images/users/amgad.jpg
//هون عم نخزن الصورة عنا ب مشروع اللارافيل ب مكانين   الاول بل ستوريج وومكن نكبو   والتاني بل بابليج للفلاتر
  $image = $request->file('img');                                 // tmp تخزين الصورة ب ملفات الزامب  ب لاحقة 
 $image_name = $image->getClientOriginalName();                  //الحصول على اسم الصورة ولاحقتها النظامية
 $image->move(public_path('/storage/images/users'),$image_name); //ب الاسم واللاحقة الصحpublic نقل الصورة  من ملفات الزامب لل 
 $request->file('img')->store('users_images')  ;           //storage/app/users_images  تخزين  بل 
$path_photo= base_path().'\\storage\\app\\'.$request->file('img')->store('users_images');
 $destination_path = public_path('images\items');
$destination_path = 'public/images/items';
$img=$request->file('img');
$img_name=$img->getClientOriginalName();
   $image = $request->file('img');
 $image_name = $image->getClientOriginalName();
 $image->move(public_path('/storage/images/items'),$image_name);
 $image_path = "/storage/images/items/" . $image_name;//>}