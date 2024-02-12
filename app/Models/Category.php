<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Item;

class Category extends Model
{
    
    protected $table = 'categories';
    protected $fillable = ['categorie_name','id'];

    public function items() {
        return $this->hasMany(Item::class );
    }
}
