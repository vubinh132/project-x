<?php

namespace App\Http\Controllers;

use App\Models\ActivityHistory;
use Illuminate\Http\Request;
use App\Models\Diary;
use Log;
use App\Models\Note;


class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $id = $request->get('id') ? $request->get('id') : 1;
        $content = '';
        $names = Note::get()->pluck('name', 'id');

        if ($id) {
            $note = Note::where('id', $id)->firstOrFail();
            $content = $note->content;
        }
        return view('notes.index', compact('id', 'content', 'names'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        $requestData = $request->all();

        $note = Note::where('id', $requestData['id'])->first();

        $note->update(['content' => $requestData['content']]);

        return redirect('notes?id=' . $requestData['id']);
    }


}
