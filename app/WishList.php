<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{

    protected $fillable = [
        'user_id', 'prod_id', 'prod_name', 'prod_price', 'prod_quantity', 'prod_slug', 'prod_image'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
