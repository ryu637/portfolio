@extends('layouts.app')

@section('title', 'Chart')

@section('content')
<style>
    body{
        overflow-y: hidden; 
        background-color: #F5EFE7;
    }

    #chart-container {
        width: 100%;
        max-width: 700px;
        height: 350px; /* ✅ 高さ指定 */
        
    }
    
    #lineChart {
        width: 100%;
        height: 100%; /* ✅ 親要素の高さに合わせる */
        border-radius: 15px;
        background-color: #e9e3db;

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

    .message{
        text-align: center;
        margin-top: 10px;
    }



</style>
<div class="list-container container">
    <div class="row">
        <div class="col-7">
            <h2>月ごとの文字数推移</h2>
            
            <!-- 月選択フォーム -->
            <form action="{{ route('user.chart') }}" method="GET">
                <label for="month">表示する月を選択:</label>
                <input type="month" name="month" id="month" value="{{ request('month', date('Y-m')) }}">
                <button type="submit">表示</button>
            </form>
            <div id="chart-container">
                <canvas id="lineChart"></canvas>
            </div>
            
        </div>
        <div class="col-4">
            <div style="margin-left: 100px; margin-top: 150px;">
                <p>選択した月: {{ $selectedMonth }}</p>
                <p>合計文字数: {{ $totalMonthlyCharacters }} 文字</p>
                <p>最大連続日数: {{ $maxConsecutiveDays }} 日</p>
            </div>
        </div>

</div>
<div class="message">
    <h1>You're Doing Better Than You Think</h1>
    <p>Every journal entry is proof of your progress. Keep writing, keep improving, and trust the process!</p>
</div>
    
    </div>
    <script>
    const labels = @json($labels);
    const dataValues = @json($data);
</script>

@endsection