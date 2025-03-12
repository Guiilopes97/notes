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
        $notes = User::find($id)
                            ->notes()
                            ->whereNull('deleted_at')
                            ->orderBy('id', 'desc')
                            ->get()
                            ->toArray();

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

        if($id === null){
            return redirect()->route("home");
        }

        // load note
        $note = Note::find($id);

        // show edit note view
        return view("edit_note", ["note" => $note]);
    }

    public function editNoteSubmit(Request $request){
        
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
        
        // check if note_id exists
        if(!$request->has("note_id")){
            return redirect()->route("home");
        }

        // decrypt note_id
        $id = Operations::decryptId($request->get("note_id"));

        if($id === null){
            return redirect()->route("home");
        }

        // load note
        $note = Note::find($id);

        // update note
        $note->title = $request->get("text_title");
        $note->text = $request->get("text_note");
        $note->save();

        // redirect to home
        return redirect()->route("home");

    }

    public function deleteNote($id){

        $id = Operations::decryptId($id);
        
        if($id === null){
            return redirect()->route("home");
        }

        // load note
        $note = Note::find($id);

        // show delete note confirmation view
        return view("delete_note", ["note" => $note]);
        
    }

    public function deleteNoteConfirm($id){

        // check if $id is encrypted
        $id = Operations::decryptId($id);

        if($id === null){
            return redirect()->route("home");
        }
        
        // load note
        $note = Note::find($id);

        // 1. hard delete
        // $note->delete();
        
        // 2. soft delete
        // $note->deleted_at = date("Y-m-d H:i:s");
        // $note->save();
        
        // 3. soft delete (propert in model)
        $note->delete();

        // 4. hard delete (propert in model)
        // $note->forceDelete();

        
        // redirect to home
        return redirect()->route("home");
    }

}
