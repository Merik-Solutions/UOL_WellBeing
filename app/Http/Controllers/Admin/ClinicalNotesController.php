<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class ClinicalNotesController extends Controller
{
    public function index(){
        $data['clinical_notes'] = Note::orderBy('id','DESC')->get();
        return view('admin.clinical_notes.index', $data);
    }
    
    public function getNote($id){
        $data['note'] = Note::find($id);
        return view('admin.clinical_notes.modal.note_details', $data);
    }
}
