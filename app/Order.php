<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * Get the products of the order.
     */
    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }
}
