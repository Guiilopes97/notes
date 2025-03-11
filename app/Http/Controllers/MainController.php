<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        echo "I'n inside the app";

    }

    public function newNote(){
        echo "I'm create a new note";
    }

}
