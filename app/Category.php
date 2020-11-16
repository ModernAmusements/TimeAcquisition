<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    protected $guarded = [];

    public function time() {
        return $this->belongsTo('App\Time');
    }

}
