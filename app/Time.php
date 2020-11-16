<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Time extends Model
{
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->hasOne('App\Category');
    }
    public function secToHR($seconds) {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        if (strlen($minutes) < 2){
        $minutes = $minutes ."0";
      }
        return "$hours:$minutes";
      }
}