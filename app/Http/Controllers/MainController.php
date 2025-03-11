<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        // load user notes
        $id = session("user.id");
        $notes = User::find($id)->notes()->get()->toArray();

        // show home view
        return view("home", ["notes"=> $notes]);

    }

    public function newNote(){
        echo "I'm create a new note";
    }

    public function editNote($id){
        
        $id = Operations::decryptId($id);

        echo "edit note: $id <br>"; 
        // return view("edit", ["note"=>$note]);
    }

    public function deleteNote($id){

        $id = Operations::decryptId($id);
        User::find(session("user.id"))->notes()->find($id)->delete();

        return redirect()->route("home");
        
    }

}
