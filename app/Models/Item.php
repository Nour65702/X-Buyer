<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use  HasFactory;
 
    protected $table = 'items';
    protected $fillable =
     [
    'categorie_id'
    ,'title'
    ,'user_id'
    ,'contact_information'
    ,'expiration_date'
    ,'quantity'
    ,'price'
    ,'img'  
    ,'likes'
    ,'views'
    ,'new_price'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
 /*___________________________________________________________________________________________________________________________________*/

    public function categories() {
        return $this->belongsTo(Category::class );
    }
 /*___________________________________________________________________________________________________________________________________*/
    public function offer()
    {
        return $this->hasone(Offer::class );
    }
 /*___________________________________________________________________________________________________________________________________*/

    public function comment()
    {
        return $this->hasmany(Comment::class );
    }

}