<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $guarded = [];
    public $timestamps = false;

    public function product()
    {
        return $this->hasOne('App\Models\Skateboard', 'id', 'product_id')->first();
    }

    public function color()
    {
        return $this->hasOne('App\Models\Color', 'id', 'color_id')->first();
    }
}
