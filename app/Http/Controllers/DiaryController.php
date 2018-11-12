<?php
namespace App\Http\Controllers;

use App\Models\ActivityHistory;
use Illuminate\Http\Request;
use App\Models\Diary;
use Log;


class DiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $date = $request->get('date');
        $content = '';

        if ($date) {
            $diary = Diary::where('date', $date)->first();
            if ($diary) {
                $content = $diary->content;
            }
        }
        return view('diary.index', compact('date', 'content'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'content' => 'html_required'
        ]);

        $requestData = $request->all();

        $diary = Diary::where('date', $requestData['date'])->first();

        if ($diary) {
            $diary->update(['content' => $requestData['content']]);
        } else {
            Diary::create($requestData);
        }

        return redirect('diary?date=' . $requestData['date']);
    }


}
