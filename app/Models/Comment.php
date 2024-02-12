<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = ['user_id','comment','item_id','Posted_by'];
    
    public function user() {
        return $this->belongsTo(User::class );
    }
 /*___________________________________________________________________________________________________________________________________*/
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}


