<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;

class Operations
{
    public static function decryptId($value){

        // check if $value is encrypted
        try {

            $value = decrypt($value);

        } catch (DecryptException $e) {   

            return null;

        }

        return $value;
    }
}