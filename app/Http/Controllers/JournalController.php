<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\JournalRequest;
use App\Models\Journal;
use App\Models\Record;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 

class JournalController extends Controller
{
    public function index(){
        $journals = Journal::orderBy('created_at', 'desc')->get(); //sql では,SELECT * FROM users ORDER BY created_at DESC;
                                                                   //desc(descending)は並び順をを新しい順で並べ替える。ー＞古い順は"asc"
        $latestJournal = $journals->first();                        //firstは最新の情報をデータを取得する。この場合は新しい順に並べ替えた、一番新しいデータを取得する
        $recordDates = Record::orderBy('created_at','desc')->where('date',$latestJournal->date)->get();


        return view('journal', compact('journals', 'latestJournal','recordDates'));
    }

    public function showByDate($date)
    {

        
        $journals = Journal::orderBy('created_at', 'desc')->get();
        $latestJournal = Journal::where('date', $date)->first();
        $recordDates = Record::orderBy('created_at','desc')->where('date',$latestJournal->date)->get();
    
        return view('journal', compact('journals', 'latestJournal','recordDates'));
    }
    

    

    public function store(JournalRequest $request){

        $userId = Auth::id(); // ログイン中のユーザーID
        $date = Carbon::now()->toDateString(); // 今日の日付（YYYY-MM-DD）
    
        // 既に同じ日付のジャーナルが存在するか確認
        $existingJournal = Journal::where('user_id', $userId)
                                  ->where('date', $date)
                                  ->first();
    
        if ($existingJournal) {
            return redirect()->route('user.journal')->with('error', 'You have already created a journal for today.');
        }
        
        Journal::create([
            'user_id' => $userId,
            'date' => $date, // YYYY-MM-DD 形式で保存
            'highlights' => $request->highlights,
            'highlights_jp' => $request->highlights_jp,
            'feelings' =>  $request->feelings,
          'feelings_jp' => $request->feelings_jp,
            'learnings' => $request->learnings,
            'learnings_jp' => $request->learnings_jp,
            'plans' => $request->plans,
            'plans_jp' => $request->plans_jp
        ]);

        return redirect()->route('user.journal');
    }

    public function update(JournalRequest $request, $id){
        $journal = Journal::findOrFail($id); //journal::find($id)はなるでもエラーが出ないでなるを確かめるためのコードを書かなければならない

        $journal->update([
            'date' =>  $request->date,
            'highlights' => $request->highlights,
            'highlights_jp' => $request->highlights_jp,
            'feelings' =>  $request->feelings,
          'feelings_jp' => $request->feelings_jp,
            'learnings' => $request->learnings,
            'learnings_jp' => $request->learnings_jp,
            'plans' => $request->plans,
            'plans_jp' => $request->plans_jp
        ]);

        return redirect()->route('user.journal');
    }

    public function delete($id){
        $project = Journal::findOrFail($id);
        $date = $project->date;

        Journal::where('id', $project->id)->delete();

        $project->delete();
        return redirect()->route('user.journal');
    }
}
