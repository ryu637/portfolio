<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Journal;
use Carbon\Carbon;
class ChartController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // ユーザーが指定した月を取得（デフォルトは今月）
        $selectedMonth = $request->input('month', date('Y-m'));
        $startOfMonth = Carbon::parse($selectedMonth)->startOfMonth();
        $endOfMonth = Carbon::parse($selectedMonth)->endOfMonth();

        // 指定した月の日ごとの文字数を計算
        $journals = Journal::where('user_id', $userId)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->get()
            ->groupBy('date')
            ->map(fn ($entries) => $entries->sum(
                fn ($journal) => mb_strlen($journal->highlights) +
                                 mb_strlen($journal->highlights_jp) +
                                 mb_strlen($journal->feelings) +
                                 mb_strlen($journal->feelings_jp) +
                                 mb_strlen($journal->learnings) +
                                 mb_strlen($journal->learnings_jp) +
                                 mb_strlen($journal->plans) +
                                 mb_strlen($journal->plans_jp)
            ));

        // グラフ用データ
        $labels = [];
        $data = [];
        $totalMonthlyCharacters = 0;
        $consecutiveDays = 0;
        $maxConsecutiveDays = 0;
        $previousEntryExists = false;

        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $formattedDate = $date->format('Y-m-d');
            $labels[] = $formattedDate;
            $dailyCount = $journals[$formattedDate] ?? 0;
            $data[] = $dailyCount;
            $totalMonthlyCharacters += $dailyCount;

            // 最大連続日数のカウント
            if ($dailyCount > 0) {
                $consecutiveDays = $previousEntryExists ? $consecutiveDays + 1 : 1;
                $previousEntryExists = true;
            } else {
                $maxConsecutiveDays = max($maxConsecutiveDays, $consecutiveDays);
                $consecutiveDays = 0;
                $previousEntryExists = false;
            }
        }

        // ループ終了後に、最大連続日数を確定
        $maxConsecutiveDays = max($maxConsecutiveDays, $consecutiveDays);

        return view('chart', compact('labels', 'data', 'totalMonthlyCharacters', 'maxConsecutiveDays', 'selectedMonth'));
    }
}
