<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        // load user notes
        $id = session("user.id");
        $notes = User::find($id)->notes()->orderBy('id', 'desc')->get()->toArray();

        // show home view
        return view("home", ["notes"=> $notes]);

    }

    public function newNote(){

        // Show new note view
        return view("new_note");

    }

    public function newNoteSubmit(Request $request){

        // validate request
        $request->validate(
            // validation rules
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000',
            ],
            // custom validation messages
            [
                'text_title.required' => 'O título é obrigatório',
                'text_title.min' => 'O título deve ter no mínimo :min caracteres',
                'text_title.max' => 'O título deve ter no máximo :max caracteres',

                'text_note.required' => 'A nota é obrigatório',
                'text_note.min' => 'A nota deve ter no mínimo :min caracteres',
                'text_note.max'=> 'A nota deve ter no máximo :max caracteres',
            ]
        );

        // get user id
        $id = session("user.id");

        //  create new note
        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->get("text_title");
        $note->text = $request->get("text_note");
        $note->save();

        // redirect to home
        return redirect()->route("home");
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
