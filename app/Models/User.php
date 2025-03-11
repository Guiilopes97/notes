<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // User has many notes relationship
    public function notes(){
        return $this->hasMany(Note::class);
    }
}
