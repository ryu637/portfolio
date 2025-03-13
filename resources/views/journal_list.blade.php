@extends('layouts.app')

@section('title', 'Journal List')

@section('content')
<style>
    body{
        background-color: #F5EFE7;
        overflow: hidden;
        
    }
    .list-container{
        background-image: url("{{ asset('images/image 1.png') }}");
        background-size: 120% auto; 
        background-position: center;
        height: 80vh;
        margin-top: 40px;
        width: 1200px;
        border-radius: 15px; 
        box-shadow: inset 0 0 30px rgba(0, 0, 0, 0.5); 
    }
     .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between; /* 両端揃え */
            align-content: flex-start; /* 上から順に配置 */
            height: 600px; /* 高さを固定（調整可） */
            gap: 10px;
            padding: 20px;
        }
        
        .item{
            background-color: rgba(216, 196, 182, 0.5);
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
            border-radius: 15px;
            width: 48%;
        }
        .char-count-container {
    display: flex;
    gap: 10px;
    font-size: 14px;
}

       
        
        .btn{
            box-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
            margin-right: 40px;
            margin-bottom: 20px;
            border-radius: 30px;
            padding: 0 20px;
        }
     
        
</style>
<div class="list-container container">
    <div class="row">
        <div class="col-6">Your Journal Entries</div>
        <div class="col-6">Your Thoughts Matter - Keep Expressing, Keep Learning</div>
    </div>

    @foreach ($paginatedJournals as $week => $journals)
        <h2 class="text-center mt-4">{{ \Carbon\Carbon::parse($week)->format('Y年m月d日D') }} 〜 
            {{ \Carbon\Carbon::parse($week)->endOfWeek()->format('Y年m月d日D') }}</h2>
        
        <div class="card-container">
            @foreach ($journals as $journal)
            @php
            // 全ての項目の文字数を合計
            $totalChars = mb_strlen($journal->highlights ?? '') 
                        + mb_strlen($journal->feelings ?? '') 
                        + mb_strlen($journal->learnings ?? '') 
                        + mb_strlen($journal->plans ?? '');
        @endphp
                <div class="item">
                    <h1>{{ \Carbon\Carbon::parse($journal->date)->format('Y年m月d日 D') }}</h1>
                    <div class="char-count-container">
                    <p>文字数: {{ $totalChars }}</p> 
                        <p>ハイライト: {{ mb_strlen($journal->highlights ?? '') }}</p>
                        <p>気持ち: {{ mb_strlen($journal->feelings ?? '') }}</p>
                        <p>学び: {{ mb_strlen($journal->learnings ?? '') }}</p>
                        <p>計画: {{ mb_strlen($journal->plans ?? '') }}</p>
                    </div>
                    <a href="{{ route('user.journal.show', ['date' => $journal->date] )}}" class="btn btn-outline-secondary float-end">view more</a>
                </div>
            @endforeach
        </div>
    @endforeach
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $paginatedJournals->links() }}
</div>

@endsection