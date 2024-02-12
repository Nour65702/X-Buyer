<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;
    protected $table = 'view';
    protected $fillable =  [ 'user_id','item_id' ];

    public function user() 
    {
        return $this->belongsTo(User::class );
    }
 /*___________________________________________________________________________________________________________________________________*/
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
