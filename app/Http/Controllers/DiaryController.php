<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Record;
use App\Models\Journal;



class DiaryController extends Controller
{


    public function calendar(Request $request)
    {
        // Get the year and month from the request or use today's date
        //$request->input('year") and ('month')はviewで設定されている。これは今現在の月と年よりも後か目の設定がされていて、それをrouteで送られている。詳しくはviewを確認
        //carbon:;today()->format('Y')その日の年と月を取得している
        $year = $request->input('year') ?? Carbon::today()->format('Y');//??はも左辺でなければ、右辺が実行される。
        $month = $request->input('month') ?? Carbon::today()->format('m');
        
        // Create the Carbon object for the first day of the given month
        $calendarYm = Carbon::create($year, $month, 1, 0, 0, 0);
        //createを使用すると、何年、何月、何日の日付の作成できる。３番目は日付。４番目は時間、５番目は分、６番目は秒

        $calendarDays = [];

        // Add previous month's dates if the first day is not Sunday
        if ($calendarYm->dayOfWeek != 0) {//calendarYm->dayOfWeekは、０日曜日１月曜日２火曜日３水曜日４木曜日５金曜日６土曜日。つまりここでは日曜日でなければ、、、となる。
            $calendarStartDay = $calendarYm->copy()->subDays($calendarYm->dayOfWeek);
            //calendarYmの曜日を取得し、その日付１からcalendar上でマナスする。これで前の月の日曜日がわかり、最初の空欄を」埋めることがでいる」
            for ($i = 0; $i < $calendarYm->dayOfWeek; $i++) {
                $calendarDays[] = ['date' => $calendarStartDay->copy()->addDays($i), 'show' => false, 'status' => false];
                
            }
        }

        // Add current month's dates
        for ($i = 0; $i < $calendarYm->daysInMonth; $i++) {
            $currentDay = $calendarYm->copy()->addDays($i);
            $calendarDays[] = [
                'date' => $currentDay,
                'show' => true,
                'status' => $currentDay->greaterThanOrEqualTo(Carbon::now()) ? true : false,
                'isPast' => $currentDay->lessThan(Carbon::now()) 
            ];
        }

        // Add next month's dates if the last day is not Saturday
        if ($calendarYm->copy()->endOfMonth()->dayOfWeek != 6) {
            for ($i = $calendarYm->copy()->endOfMonth()->dayOfWeek + 1; $i < 7; $i++) {
                $calendarDays[] = ['date' => $calendarYm->copy()->addDays($i), 'show' => false, 'status' => false];
            }
        }

       

        
        
        
        
        
        $userId = auth()->id(); // ログインユーザーのIDを取得
        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        // ユーザーのジャーナルを日付順に取得
        $journals = Journal::where('user_id', $userId)
        ->orderBy('date', 'desc')
        ->pluck('date')
        ->toArray();
        
        $streak = 0;
        $today = Carbon::today();
        
        foreach ($journals as $index => $date) {
            $journalDate = Carbon::parse($date);
            
            if ($index == 0 && !$journalDate->isSameDay($today) && !$journalDate->isSameDay($today->subDay())) {
                break;
            }
            
            if ($index == 0 || $journalDate->diffInDays(Carbon::parse($journals[$index - 1])) == 1) {
                $streak++;
            } else {
                break;
            }
        }
        
        $startOfWeek = Carbon::now()->startOfWeek()->toDateString();
    $endOfWeek = Carbon::now()->endOfWeek()->toDateString();

    // 今週のジャーナルを取得
    $weeklyJournals = Journal::where('user_id', $userId)
        ->whereBetween('date', [$startOfWeek, $endOfWeek])
        ->get();

    // 文字数を合計
    $totalCharacters = $weeklyJournals->sum(function ($journal) {
        return mb_strlen($journal->highlights ?? '') +
               mb_strlen($journal->highlights_jp ?? '') +
               mb_strlen($journal->feelings ?? '') +
               mb_strlen($journal->feelings_jp ?? '') +
               mb_strlen($journal->learnings ?? '') +
               mb_strlen($journal->learnings_jp ?? '') +
               mb_strlen($journal->plans ?? '') +
               mb_strlen($journal->plans_jp ?? '');
    });
 
        return view('dashboard', [
            'calendarDays' => $calendarDays,
            'previousMonth' => $calendarYm->copy()->subMonth(),
            'nextMonth' => $calendarYm->copy()->addMonth(),
            'thisMonth' => $calendarYm,
            'streak' => $streak,
            'totalCharacters' => $totalCharacters,
        ]);


        
    
}

    public function list()
{
    $journals = Journal::orderBy('date', 'asc')->get(); // すべてのジャーナルを取得

    // 週ごとにグループ化（週の開始日をキーにする）
    $groupedJournals = $journals->groupBy(function ($journal) {
        return Carbon::parse($journal->date)->startOfWeek()->format('Y-m-d');
    });

    // ページネーションを適用（1週間単位）
    $perPage = 1; // 1ページに1週間分を表示
    $currentPage = request()->input('page', 1);
    $sliced = $groupedJournals->slice(($currentPage - 1) * $perPage, $perPage);
    
    $paginatedJournals = new \Illuminate\Pagination\LengthAwarePaginator(
        $sliced, 
        $groupedJournals->count(), 
        $perPage, 
        $currentPage, 
        ['path' => request()->url()]
    );

    return view('journal_list', compact('paginatedJournals'));
}


    
//-------
    public function showEntries($date)
{
    $entries = Record::where('user_id', auth()->id())
        ->whereDate('date', $date)
        ->orderBy('time', 'asc')
        ->get();

    return view('daily_record', compact('entries', 'date'));
}

public function store(Request $request)
{
    $request->validate([
        'date' => 'required|date',
        'time' => 'required',
        'content' => 'required',
    ]);

    Record::create([
        'user_id' => auth()->id(),
        'date' => $request->date,
        'time' => $request->time,
        'content' => $request->content,
    ]);

    return redirect()->route('user.journal_entries', ['date' => $request->date]);
}


public function update(Request $request)
    {
        $entry = Record::find($request->id);
        
        if (!$entry) {
            return response()->json(['message' => 'Entry not found'], 404);
        }

        $entry->content = $request->content;
        $entry->save();

        return response()->json(['message' => 'Updated successfully']);
    }

    public function delete(Request $request, $id){
        $project = Record::findOrFail($id);
        $date = $project->date;

        Record::where('id', $project->id)->delete();

        $project->delete();

            return redirect()->route('user.journal',compact('date'));

            }

}
