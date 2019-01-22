<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class stockcard extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    public function scopeClerkCard($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    public function scopeProductCard($query, $product_id)
    {
        return $query->where('product_id', $product_id);
    }

    public function scopeCurrentBalance($query,$user_id, $product_id)
    {
        return $query->where('user_id', $user_id)->where('product_id', $product_id)->latest()->select('currentbalance')->first();
    }
}
