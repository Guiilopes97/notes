<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;

    // The attributes that are mass assignable.
    public function user(){
        return $this->belongsTo(User::class);
    }
}
