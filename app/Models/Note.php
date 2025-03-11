<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    // The attributes that are mass assignable.
    public function user(){
        return $this->belongsTo(User::class);
    }
}
