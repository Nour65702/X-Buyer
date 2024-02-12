<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Offer;
use App\Models\Item;
use App\Models\like;
use App\Models\View;
use Carbon\Carbon;
class ItemController extends Controller 
{ 
    public function get_Categories(){
        
        $offers=Category::all();
        return response()->json([
            'status'   => '1',
            'details'  =>$offers                
        ]);  }
    //________________________________________________________________________________________________________
    public function addItem(Request $request){
            
                $validator = Validator::make($request->all(), [
                
            'title'              => ['required'],
            'img'                => ['required'],
            'categorie_id'       => ['required',function ($key,$value,$fail) { if ($value<1||$value>6 ) {$fail(' you entered wrong value ');} }],
            'price'              => ['required',function ($key,$value,$fail) { if ($value<1 ) {$fail(' you entered wrong value ');} }],
            'quantity'           => ['required',function ($key,$value,$fail) { if ($value<1 ) {$fail(' you entered wrong value ');} }],
            'expiration_date'    => ['required'],
            'contact_information'=> ['required'], 
    
            'Days1'              => ['required',function ($key,$value,$fail) { if ($value<1 || $value>99) {$fail(' you entered wrong value ');} }],
            'Discount1'          => ['required',function ($key,$value,$fail) { if ($value<1 || $value>99) {$fail(' you entered wrong value ');} }],
            'Days2'              => ['required',function ($key,$value,$fail) { if ($value<1 || $value>99) {$fail(' you entered wrong value ');} } ] ,
            'Discount2'          => ['required',function ($key,$value,$fail) { if ($value<1 || $value>99) {$fail(' you entered wrong value ');} }],
            'Days3'              => ['required',function ($key,$value,$fail) { if ($value<1 || $value>99) {$fail(' you entered wrong value ');} }],
            'Discount3'          => ['required',function ($key,$value,$fail) { if ($value<1 || $value>99) {$fail(' you entered wrong value ');} }],
    
        ]);
        if (($request->Days1>$request->Days2)||$request->Days1>$request->Days3 ||$request->Days2>$request->Days3)
        {
            return response()->json([
                'status'       => '0',
                'details'      => ' you entered wrong value ', 422
            ]);
        }
    
        if (($request->Discount1>$request->Discount2)||$request->Discount1>$request->Discount3||$request->Discount2>$request->Discount3)
        {
            return response()->json([
                'status'       => '0',
                'details'      => ' you entered wrong value ', 422
            ]);
        }
    
    
                if($validator->fails())
                {
                    return response()->json([
                    'status'       => '0',
                    'details'      => $validator->errors(), 422
                    ]);
                }
            //     if ($request->expiration_date<=0)
            //     {  $item->delete();
            //       return response()->json([
  
            //           'status' => '1',
            //           'message' => 'wrong date ',
                      
            //   ]); }
                $uniqid='('.uniqid().')';                                 //كل كرة بيعطيني رقم فريد     انا عم استخدمو مشان اسم كل صورة يكون غير التاني حتى لو اسم الايتيم والصورة  نفسون
                $destination_path = 'public/images/items';                       //storage بمسار الصورة للتخزين جوات ال  
                $request->img->storeAs($destination_path, $uniqid . $request->img->getClientOriginalName());  //بل اسم واللاحقة الصح storage/public/images/users تخزينن الصورة بل
                //هلأ هون نحنا عاملين 
                //php artisan storage:link
                //The [C:\Users\ASUS\Desktop\New folder\X-Buyer old\public\storage] link has been connected to [C:\Users\ASUS\Desktop\New folder\X-Buyer old\storage\app/public].
                //الملفات الموجودة بل ستوريج بروح لحالها بصير بل بابليك ب هاد المسار
                $image_path = "/storage/images/items/" . $uniqid .$request->img->getClientOriginalName();           // مشان نبعتو بل ريسبونس للفلاتر publicباث الصورة يلي بل 
                //هيك الصورة فيك تفتحا ب رابط لوكال هوست متل ال بهب لانو صارت ب ملف البابليك وهيك بدا يوصللها لفلاتر 
                
                $data = [
                    'user_id'             => Auth::id(),
                    'categorie_id'        => $request->categorie_id,
                    'title'               => $request->title,   
                    'contact_information' => $request->contact_information,
                    'expiration_date'     => $request->expiration_date,
                    'quantity'            => $request->quantity,
                    'price'               => $request->price,
                    'img'                 => $image_path       //هون حطيت باث الصورة يلي بل بابليك مشان يروح الباث عل داتا بيز واسيل تاخد هاد الباث 
                    ];
    
                $item = Item::create($data);
                //dd($item->img);
                $expiration_date = $request->expiration_date;//اخدت تاريخ انتهاء الصلاحية من الداتابيز
                $remaining_days = Carbon::now()->diffInDays(Carbon::parse($expiration_date),$absolute = false); //طرحت تاريخ انتهاء الصلاحية من تاريخ اليوم وهوة متغير
                $item->Total_product_life = $remaining_days; /*  هاد الريمينينغ دايس هوة فرق بين تاريخ الانتهاء وتاريخ اليوم بس طالما انا استدعيتوعند انشاء ايتم جديد
                ف هوة رح يتطبق مرة وحدة ويتسجل بل داتا بيز وخلص ما عاد يتعدل لانو ما عاد ئلو فوتة لهاد المكان مرة تانية*/
                $item->save(); // هون  عملت سيف مشان عدد الايام الكلي يروح عل داتا بيز
                 

                $data_of_discount =
                [
                    'item_id'             => $item->id,
                    'Days1'               => $request->Days1,
                    'Discount1'           => $request->Discount1,
                    'Days2'               => $request->Days2,
                    'Discount2'           => $request->Discount2,
                    'Days3'               => $request->Days3,
                    'Discount3'           => $request->Discount3
                ];
                Offer::create($data_of_discount);
    
                $data_of_view = //للمنتج من صاحب المنتج  viewانشاء  
                [
                'item_id'                =>$item->id,
                'user_id'                =>Auth::id()
                ];
                View::create($data_of_view);
                $item->views++;
                $item->save();
                return response()->json([
    
                    'status' => '1',
                    'message' => 'item added successfully',
                    'item'=>$item,
                    
            ]);     
        }
    // _______________________________________________________________________________________________________
    public function updateItem(Request $request ,$id){
        $item = Item::where('id',$id)->where('user_id' , Auth::id())->first(); //...
        if( $item  === null)
        {
            return response()->json([
                'status' => '0',
                'details' => 'access denied'
            ]);
        }
       // $item = Item::where('id',$id)->where('user_id' , Auth::id())->first();
        $validator = Validator::make($request->all(), [
            'contact_information' => ['required'],
            'title'               => ['required'],
            'categorie_id'        => ['required'],
            'quantity'            => ['required'],
            'price'               => ['required'],
            'img'                 => ['nullable']
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'       => '0',
                'details'      => $validator->errors(), 422
            ]);
        }

        if (!($request->img==null))
        {
            
            $destination_path = 'public/images/items';                      
            $request->file('img')->storeAs($destination_path,$request->img->getClientOriginalName());  
            $image_path = "/storage/images/items/" . $request->img->getClientOriginalName();          
            
            $data = [
                'categorie_id'        => $request->categorie_id,
                'title'               => $request->title,   
                'contact_information' => $request->contact_information,
                'quantity'            => $request->quantity,
                'price'               => $request->price,
                'img'                 => $image_path,   //هون حطيت باث الصورة يلي بل بابليك مشان يروح الباث عل داتا بيز واسيل تاخد هاد الباث 
                ];
            }


        else{

                $data = [
                    'title'               => $request->title,
                    'categorie_id'        => $request->categorie_id,
                    'contact_information' => $request->contact_information,
                    'quantity'            => $request->quantity,
                    'price'               => $request->price,
                    'img'                 => $item->img
                ];
            }


           $item->update($data);

            $expiration_date = $item->expiration_date;   //تاريخ انتهاء الصلاحية
                    
            $remaining_days = Carbon::now()->diffInDays(Carbon::parse($expiration_date),$absolute = false);
            $first_Rate = $item->offer->Days1; 
            $first_Discount = $item->offer->Discount1; 

            $second_Rate = $item->offer->Days2;
            $second_Discount = $item->offer->Discount2;

            $third_Rate = $item->offer->Days3;
            $Third_Discount = $item->offer->Discount3;

            $Total_product_life= $item->Total_product_life; /*هون جبت عدد ايام المنتج الكلي  من الداتا بيز*/

                        $number_of_day_for_first_offer  =$Total_product_life-($Total_product_life * $first_Rate /100);    // 9-9 *25/100  6.75  9
                        $number_of_day_for_second_offer =$Total_product_life-($Total_product_life * $second_Rate/100);    // 9-(9*(50/100))  4.5
                        $number_of_day_for_third_offer  =$Total_product_life-($Total_product_life * $third_Rate /100); 


            switch ($remaining_days)
            {
                case $remaining_days > $number_of_day_for_first_offer :
                $item->new_price = $item->price;
                $item->save();

                break;

                case $remaining_days <= $number_of_day_for_first_offer && $remaining_days > $number_of_day_for_second_offer :/*
                ازا كان عدد الايام  الباقية اصغر من ايام اول فتر_عرض واكبر من تاني فترة_عرض*/
                $price = $item->price;    //اخدت سعر المنتج من داتابيز وحطيتو بل برايس
                $value_Discount = $price * $first_Discount /100;
                        //عرفت متحول فاليو_ديسكاونت(قيمة الخصم) وقلت انو بساوي
                    //قيمة الخصم =السعر الاصلي ضرب (قيمة الخصم بل فترة الاولى ) على 100
                $new_price = $price - $value_Discount;
                    //السعر الجديد هوة السعر القديم ناقص قيمة الخصم
                $item->new_price = $new_price;
                $item->save();

                    //حفظ القيمة الجديدة بل داتا بيز
                break;

                case$remaining_days <= $number_of_day_for_second_offer && $remaining_days > $number_of_day_for_third_offer :
                $price = $item->price;    //اخدت سعر المنتج من داتابيز وحطيتو بل برايس
                $value_Discount = $price * $second_Discount/100;
                    //عرفت متحول فاليو_ديسكاونت(قيمة الخصم) وقلت انو بساوي
                    //قيمة الخصم =السعر الاصلي ضرب (قيمة الخصم بل فترة التانية ) على 100
                $new_price = $price - $value_Discount;
                    //السعر الجديد هوة السعر القديم ناقص قيمة الخصم
                $item->new_price = $new_price;
                $item->save();

                break;

                case $remaining_days  <= $number_of_day_for_third_offer:
                $price = $item->price;
                $value_Discount = $price *$Third_Discount /100;
                $new_price = $price - $value_Discount;
                $item->new_price = $new_price;
                $item->save();

            }


        // $itemm = Item::get()->where('id',$id);
        // dd($item_update_price);
        return response()->json([
            'status'  =>'1',
            'details' => 'The item has been modified successfully',
            'data'   => $data,
            'new_price'=> $item->new_price,
        ]);}
    // _______________________________________________________________________________________________________
    public function deleteItem($id){
        $item = Item::where('id',$id)->where('user_id' , Auth::id())->first();

        if( $item == null)
        {
            return response()->json([
                'status' => '0',
                'details' => 'access denied' ]);
        }
        if ($item != null) {
        $item->delete();
        }
        return response()->json([
            'status'  =>'1',
            'details' => 'Item deleted successfully'
        ]);}  
        
    // _______________________________________________________________________________________________________
    public function discount_items_And_Show() {
            $items = Item::all();

            foreach($items as $item )
                {
                    $expiration_date = $item->expiration_date;   //تاريخ انتهاء الصلاحية
                    
                    $remaining_days = Carbon::now()->diffInDays(Carbon::parse($expiration_date),$absolute = false);
                    /*
                    هون طرح تاريخ انتهاء الصلاحية من تاريخ اليوم وهاد مو ثابت وكل يوم بيتغير
                    يعني كم يوم باقي ليخلص مدتتو للمنتج */
                    
                    $item->Number_Of_Remaining_Day=$remaining_days;
                    $item->save();

                        //خزنت الايام المتبقية من عمر المنتج بل داتا بيز وهاد منغير 

                            // 25:25   50:50   75:75   30000 7500  24/12/2021  21/3/2021 100
                        $first_Rate = $item->offer->Days1; // النسبة الاولى "اصغر نسبة" من الايام تبع عمرالمنتج مثلا لما يمضى مثلا 25 بالمية من عمر المنتج
                        $first_Discount = $item->offer->Discount1; //قيمة الخصم بالنسبة المئوية يليي بدو يصير للمنتج

                        $second_Rate = $item->offer->Days2;// النسبة الثانية  من الايام تبع عمرالمنتج مثلا لما يمضى مثلا 50 بالمية من عمر المنتج
                        $second_Discount = $item->offer->Discount2;//قيمة الخصم بالنسبة المئوية يليي بدو يصير للمنتج

                        $third_Rate = $item->offer->Days3;// النسبة التالتة  من الايام تبع عمرالمنتج مثلا لما يمضى مثلا 75 بالمية من عمر المنتج
                        $Third_Discount = $item->offer->Discount3;//قيمة الخصم بالنسبة المئوية يليي بدو يصير للمنتج

                        $Total_product_life= $item->Total_product_life; /*هون جبت عدد ايام المنتج الكلي  من الداتا بيز*/

                        $number_of_day_for_first_offer  =$Total_product_life-($Total_product_life * $first_Rate /100);    // 9-9 *25/100  6.75  9
                        $number_of_day_for_second_offer =$Total_product_life-($Total_product_life * $second_Rate/100);    // 9-(9*(50/100))  4.5
                        $number_of_day_for_third_offer  =$Total_product_life-($Total_product_life * $third_Rate /100);    //                2.25
                        if ($expiration_date == date ("j-n-Y") ||$remaining_days <= 0)   // ازا كان تاريخ انتهاء الصلاحية بساوي تاريخ اليوم
                        {
                            $Expired_Item = Item::where('expiration_date',$expiration_date)->get()->first();
                            if ($Expired_Item != null)
                            {
                                        // dd('d');
                                        $Expired_Item->delete();
                                    }
                        }
                        else
                        {
                            switch ($remaining_days)
                            {
                                case $remaining_days > $number_of_day_for_first_offer :
                                $item->new_price = $item->price;
                                $item->save();
                                break;

                                case $remaining_days <= $number_of_day_for_first_offer && $remaining_days > $number_of_day_for_second_offer :/*
                                ازا كان عدد الايام  الباقية اصغر من ايام اول فتر_عرض واكبر من تاني فترة_عرض*/
                                $price = $item->price;    //اخدت سعر المنتج من داتابيز وحطيتو بل برايس
                                $value_Discount = $price * $first_Discount /100;
                                        //عرفت متحول فاليو_ديسكاونت(قيمة الخصم) وقلت انو بساوي
                                    //قيمة الخصم =السعر الاصلي ضرب (قيمة الخصم بل فترة الاولى ) على 100
                                $new_price = $price - $value_Discount;
                                    //السعر الجديد هوة السعر القديم ناقص قيمة الخصم
                                $item->new_price = $new_price;
                                $item->save();
                                    //حفظ القيمة الجديدة بل داتا بيز
                                break;

                                case$remaining_days <= $number_of_day_for_second_offer && $remaining_days > $number_of_day_for_third_offer :
                                $price = $item->price;    //اخدت سعر المنتج من داتابيز وحطيتو بل برايس
                                $value_Discount = $price * $second_Discount/100;
                                    //عرفت متحول فاليو_ديسكاونت(قيمة الخصم) وقلت انو بساوي
                                    //قيمة الخصم =السعر الاصلي ضرب (قيمة الخصم بل فترة التانية ) على 100
                                $new_price = $price - $value_Discount;
                                    //السعر الجديد هوة السعر القديم ناقص قيمة الخصم
                                $item->new_price = $new_price;
                                $item->save();
                                break;

                                case $remaining_days  <= $number_of_day_for_third_offer:
                                $price = $item->price;
                                $value_Discount = $price *$Third_Discount /100;
                                $new_price = $price - $value_Discount;
                                $item->new_price = $new_price;
                                $item->save();
                            }
                        }     
                 }
                 $items = Item::all();
                 return response()->json([
                        'status'   => '1',
                        'details'  =>$items,
                    ]); }
    //________________________________________________________________________________________________________
    public function myproducts(){//باي
        $items = Item::where('user_id' , Auth::id())->get();
        return response()->json([
            'status'   => '1',
            'details'  =>$items
        ]);}
    //________________________________________________________________________________________________________
     public function Sort_ASC(){
        $items = Item::with('offer')->orderBy('price','ASC')->get();
        
        return response()->json([
            'status'  => '1',
            'details' => $items,
        ]);}
    // _______________________________________________________________________________________________________
    public function Sort_DESC(){
        $items = Item::with('offer')->orderBy('price','DESC')->get();

        return response()->json([
            'status'  => '1',
            'details' => $items,
        ]);}
    //________________________________________________________________________________________________________
    public function searchByName($name){
       
        $items = Item::with('offer')->where('title', 'like',"%"."$name"."%")->get();

        
        return response()->json([
            'status'   => '1',
            'details_item'  =>$items
          //  'details_offet'  =>$a->offer
        ]);}
    // _______________________________________________________________________________________________________
    public function searchByCATE($Catygory_id){
        $items = Item::with('offer')->where('categorie_id',$Catygory_id)->get();
        return response()->json([
            'status'   => '1',
            'details'  =>$items
        ]);}
    // _______________________________________________________________________________________________________
     public function search_Expir_Date($expir_date){
        $items = Item::with('offer')->where('expiration_date',$expir_date)->get();
        return response()->json([
            'status'   => '1',
            'details'  =>$items
        ]); }
    // _______________________________________________________________________________________________________
    public function Add_View($item_id){

        if(    Item::where('id',$item_id)->first()  ==null)
        { return response()->json([
            'status' => '0',
            'details'=>'item not found'
        ]);}

        $views=View::all();
        
            foreach($views as $view)
            {   
                    // if ($view==null)
                    //     { 
                    //     return response()->json([
                    //         'status' => '0',
                    //         'details'=>'item not found ',]);
                    //     }   

                    if($view->user_id==Auth::id()&&$view->item_id==$item_id)
                        { 
                            $item= Item::where('id', $item_id)->first();
                            
                            return response()->json([
                                'status' => '0',
                                'details'=>'you already show it ' ,
                                'views' => $item->views ]);       
                        }
            }
       $data=['item_id'=>$item_id,'user_id'=>Auth::id()];
       View::create($data);
       $Item_Views = View::all()->where('item_id',$item_id);
       $number_of_views=count($Item_Views);
       $item= Item::where('id', $item_id)->first();
       $item->views=$number_of_views;
       $item->save();  

      return response()->json([
         'status' => '1',
         'details'=>'view successflly ',
         'views' => $item->views ]); } 
    // _______________________________________________________________________________________________________
    public function AddLike($item_id){
      //  dd($item_id);

        if(    Item::where('id',$item_id)->first()  ==null)
        { return response()->json([
            'status' => '0',
            'details'=>'item not found'
        ]);}

        $likes=Like::all();
        foreach($likes as $like)
            {
                if($like->user_id==Auth::id() && $like->item_id==$item_id) 
                {
                    $item= Item::where('id', $item_id)->first();

                    return response()->json([
                    'status' => '0',
                    'details'=>'you already like it ',
                    'likes'=>$item->likes      
                  ]);
                }
            }
        $data_like=['item_id'=>$item_id,'user_id'=>Auth::id()];
        Like::create($data_like);

        $likes_item = Like::all()->where('item_id',$item_id);
        $number_of_Likes=count($likes_item);
        
        $item= Item::where('id', $item_id)->first();
        $item->likes=$number_of_Likes;
        $item->save();

       return response()->json([
        'status' => '1',
        'details'=>'like successflly ', 
        'likes' => $item->likes ]);}
    // _______________________________________________________________________________________________________
    public function UnLike($item_id){

        $like = Like::where('item_id',$item_id)->where('user_id',Auth::id())->first();

        if( $like == null)
        {
            $item= Item::where('id', $item_id)->first();

            return response()->json([
                'status' => '0',
                'details' => 'you already dont like it' ,
                 'likes' => $item->likes ]);

        }
        $like->delete();

        // item لنرجع عدد اللايكات  بعد الحذف لل 
        $likes_item = Like::all()->where('item_id',$item_id);
        $number_of_Likes=count($likes_item);
        
        $item= Item::where('id', $item_id)->first();
        $item->likes=$number_of_Likes;
        $item->save();

        return response()->json([
            'status'  =>'1',
            'details' => 'unlike successfully',
            'likes' => $item->likes
        ]);}
    // _______________________________________________________________________________________________________
    public function Get_Items_Liked(){
        $item_like_it = Like::where('user_id',Auth::id())->get();
       // dd($item_like_it->id);
        return response()->json([
            'status'  =>'1',
            'details' => ' items you like it is',
            'items_like_it' => $item_like_it ]);}
    // _______________________________________________________________________________________________________
    public function addComment($item_id,Request $request) {
         if(    Item::where('id',$item_id)->first()  ==null)
         { return response()->json([
             'status' => '0',
             'details'=>'item not found'
         ]);}
      
        $data_of_comment =
                [
                    'user_id'             => Auth::id(),
                    'Posted_by'           => Auth::user()->first_name." ".Auth::user()->last_name,
                    'item_id'             => $item_id,
                    'comment'             => $request->comment,                
                ];
        
      Comment::create($data_of_comment);

        return response()->json([
            'status' => '1',
            'details'=>'Your comment has been added'
        ]); }
    // _______________________________________________________________________________________________________
    public function removeComment($comm_id){
        if($comment = Comment::where('id',$comm_id)->where('user_id' , Auth::id())->first() === null){
            return response()->json([
                'status' => '0',
                'details' => 'access denied' ]);
        }
        $comment = Comment::where('id',$comm_id)->where('user_id' , Auth::id())->first();
            $comment->delete();
        return response()->json([
            'status' => '1',
            'details'=>'Your comment has been deleted'
        ]);}
    // _______________________________________________________________________________________________________
    public function ShowComments($item_id){
        $comments = Comment::where('item_id',$item_id)->get();
        //  dd($comments);
            return( response()->json([  'details'=> $comments   ]));}     
    // _______________________________________________________________________________________________________
}