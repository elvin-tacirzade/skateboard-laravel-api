<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skateboard extends Model
{
    use HasFactory;

    protected $table = 'skateboard';
    protected $guarded = [];
    public $timestamps = false;

    public function type()
    {
        return $this->hasOne('App\Models\Type', 'id', 'type_id')->first();
    }
}
