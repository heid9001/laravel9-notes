<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Http\Requests\UpdateNote;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotesController extends Controller
{
    public function view() {
        return view('notes.view');
    }

    public function paging() {
//        $pagination = DB::table('notes')
//            ->where('user_id', Auth::user()->id)
//            ->paginate(2)
//        ;
//        return $pagination;

        return Note::where('user_id', Auth::user()->id)
                        ->where('user_id', Auth::user()->id)
                        ->paginate(2);
    }

    public function list() {
        return response()->json([
            'notes' => Auth::user()->notes
        ]);
    }

    public function create(NoteRequest $request) {
        $data = $request->validated();
        return response()->json(Note::create([...$data, 'user_id' => Auth::user()->id])->toArray());
    }

    public function delete(int $id) {
        $note = Note::findOrFail($id);
        $note->delete();
        return response()->json($note);
    }

    public function update(UpdateNote $request) {
        $data = $request->validated();
        $note = Note::findOrFail($data['id'])->fill($data);
        $note->save();
        return response()->json($note);
    }
}
