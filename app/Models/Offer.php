<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = 'offers';
    use  HasFactory;

    protected $fillable = [
        'item_id',
        'Days1',
        'Discount1',
        'Days2',
        'Discount2',
        'Days3',
        'Discount3'
    ];
    
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

}
