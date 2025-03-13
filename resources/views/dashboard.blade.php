@extends('layouts.app')

@section('title', 'Journal')

@section('content')
  <style>
    body{
        overflow-y: hidden; 
        background-color: #F5EFE7;

    }
    .container-1{
        background-image: url("{{asset('images/image 1.png')}}");
        background-size: cover; 
        background-position: center;
        height: 80vh;
        margin-top: 40px;
        width: 45%;;
        border-radius: 15px; 
        box-shadow: inset 0 0 30px rgba(0, 0, 0, 0.5); 
        margin-right: 35px;
        margin-left: 43px;

    }

    .container-2{
        background-image: url("{{asset('images/image 1.png')}}");
        background-size: cover; 
        background-position: center;
        height: 80vh;
        margin-top: 40px;
        width: 45%;;
        border-radius: 15px; 
        box-shadow: inset 0 0 30px rgba(0, 0, 0, 0.5); 
        margin-right: 50px;

    }
    .container-1:hover, .container-2:hover {
    transform: translateY(-5px); /* ✅ 少し浮き上がる */
}
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            width: 350px;
            margin: 0 auto;
        }
        .week-block {
            width: 50px;
            height: 28px;
            text-align: center;
            font-weight: bold;
        }
        .day-block {
            width: 50px;
            height: 50px;
        }

        .button-day {
    width: 45px;
    height: 45px;
    padding: 0;
    text-align: center;
    font-weight: bold;
    font-size: 16px;
    background: linear-gradient(135deg, #fff 0%, #f8dada 100%); /* グラデーション */
    border: 2px solid  #57471f;; /* 柔らかい赤色の枠線 */
    border-radius: 10px; /* 角を丸く */
    color: #57471f; /* 文字色を赤系に */
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
}

.button-day:hover {
    transform: translateY(-4px); /* 少し浮き上がる */
    box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2); /* 影を強調 */
    background: linear-gradient(135deg, #318ec1 0%, #337aaa 100%); /* ホバー時に色変化 */
    color: white; /* 文字色を白に */
    border: 2px solid #1938a8;
}



        .d-flex {
            display: flex;
        }
        .justify-content-between {
            justify-content: space-between;
        }
        .text-center {
            text-align: center;
        }
        .my-3 {
            margin-bottom: 1.5rem;
        }

        .is-past {
    background-color: #d6cccc; /* 過去の日付の背景色 */
}

img {
    width: 100%; /* 親要素の幅に合わせて画像の幅を調整 */
    height: auto; /* アスペクト比を維持して高さを自動調整 */
    object-fit: contain; /* 画像が親要素に収まるようにリサイズ */
}

.doctor{
    background-color: #d6cccc;
    border-radius: 15%;
}






    </style>
<div class="container">
    <div class="row">
        <div class="col-6 border container-1 ">
            <h1 class="d-flex justify-content-center">Welcome Back, pick!</h1>
            <div class="row">
                <div class="col-5 doctor ms-4" >
                <img src="{{ asset('images/image-removebg-preview (2) 1 (1).png')}}" alt="doctor">
                </div>
                <div class="col-6 mt-5">
                    <p class="d-flex justify-content-center">Let's reflect and improve today!</p>
                    <a href="{{ route('user.journal')}}" class="btn btn-outline-secondary d-flex justify-content-center">write a new journal entry</a>
                </div>
            </div>

            <div class="row">
                <div class="col-8 mt-5" >
                    <h3>Your writing progress this week</h3>
                    <p>Total Words Written: <span>{{ $totalCharacters }}</span> Words
                    </p>
                </div>
                <div class="col-4">
                    <img src="{{ asset('images/image 7image.png')}}" alt="book photo">
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <img src="{{ asset('images/image.png')}}" alt="blue fire photo">
                </div>
                <div class="col-8 mt-3">
                    <h3 class="ms-5">Days Streak</h3>
                    <p class="display-3" style="margin-left: 25%;">{{ $streak }} </p>
                </div>
            </div>
        </div>
        <div class="col-6 border container-2">
            <h1 style="font-size: 58px;" class="f-flex text-center">Your entries at a</h1>
            <h1 style="font-size: 58px;" class="f-flex text-center">Glance</h1>
            <div class="d-flex justify-content-between">
                <a href="{{ route('user.calendar', ['year' => $previousMonth->format('Y'), 'month' => $previousMonth->format('m')]) }}">前月</a>
                <div class="text-center">
                    <strong>{{ $thisMonth->format('Y年n月') }}</strong>
                </div>
                <a href="{{ route('user.calendar', ['year' => $nextMonth->format('Y'), 'month' => $nextMonth->format('m')]) }}">翌月</a>
            </div>
            
            <div class="my-3">
                <div class="calendar-grid">
                    @foreach(['(日)', '(月)', '(火)', '(水)', '(木)', '(金)', '(土)'] as $weekName)
                    <div class="week-block">{{ $weekName }}</div>
                @endforeach
                    @foreach($calendarDays as $calendarDay)
                    @if($calendarDay['show'])
                    <div class="day-block @if($calendarDay['isPast']) is-past @endif">
                        <a href="{{ route('user.journal_entries', ['date' => $calendarDay['date']->format('Y-m-d')]) }}">
                            <button class="button-day" type="button">
                                {{ $calendarDay['date']->format('j') }} <!-- forma(j)は日付を1桁または２桁で表示。最初のゼロは表示しない-->
                            </button>
                        </a>
                    </div>
                    @else
                    <div class="day-block"></div>
                    @endif
                @endforeach
                
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection