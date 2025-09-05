<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()   { return Note::latest()->get(); }

    public function store(Request $r) {
        $data = $r->validate(['title'=>'required|string|max:255','content'=>'nullable|string']);
        return Note::create($data);
    }

    public function show(Note $note) { return $note; }

    public function update(Request $r, Note $note) {
        $data = $r->validate(['title'=>'required|string|max:255','content'=>'nullable|string']);
        $note->update($data);
        return $note;
    }
    
    public function destroy(Note $note) {
        $note->delete();
        return response()->noContent();
    }
}
