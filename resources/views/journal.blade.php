@extends('layouts.app')

@section('title', 'Journal')


<style>
    body { 
        overflow: hidden; 
    
    }
    .sidebar {
        width: 150px;
        background-color: #F3F3F3;
        height: 100vh;
        overflow-y: auto;
        padding: 15px;
        border-right: 1px solid #ccc;
    }
    .note-item {
        padding: 10px;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .note-item:hover, .note-item.active { background-color: #a6996a; }
    .main-content {
        flex-grow: 1;
        display: flex;
    }
    .note-editor {
        width: 60%;
        padding: 20px;
        border-right: 1px solid #ccc;
        background: white;
        height: 90vh;
        overflow-y: auto;
    }
    .title-input, .content-textarea {
        border: none;
        width: 100%;
        outline: none;
        resize: none;
    }
    .title-input { font-size: 24px; font-weight: bold; }
    .content-textarea { font-size: 16px; }
    .note-details {
        width: 40%;
        background-color: #F8F8F8;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .timeline {
        display: flex;
        flex-direction: column;
        gap: 12px;
        max-height: 80vh;
        overflow-y: auto;
    }
    .timeline-item {
        padding: 10px;
        border-radius: 8px;
        background: #fff;
        box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1);
    }
    .fixed-submit-btn {
        position: fixed;
        bottom: 30px;
        right: 600px;
    }
    .date-input {
        border: 2px solid #007bff;
        border-radius: 5px;
        padding: 5px;
        font-size: 16px;
        width: 100%;
        max-width: 250px;
        outline: none;
        display: block;
    }
</style>

@section('content')
<div class="d-flex">
    <!-- サイドバー -->
    <div class="sidebar">
        <h4 class="mb-3">Notes</h4>
        <form action="{{ route('user.store') }}" method="POST">
            @csrf
            <button type="submit"><i class="fa-solid fa-plus"></i></button>
        </form>
        <div id="notes-list">
            @foreach($journals as $journal)
                <a href="{{ route('user.journal.show', ['date' => $journal->date]) }}" 
                   class="note-item {{ $latestJournal && $latestJournal->id === $journal->id ? 'active' : '' }}">
                    {{ $journal->date }}
                </a>
            @endforeach
        </div>
    </div>
    
    <!-- メインコンテンツ -->
    <div class="main-content">
        <div class="note-editor">
            @if($latestJournal)
                <form action="{{ route('user.journal.update', $latestJournal->id) }}" method="POST">
                    @csrf
                    <input type="date" name="date" class="date-input" value="{{ $latestJournal->date }}">
                    @foreach(['highlights' => "Today's Highlights", 'feelings' => "How I Felt", 'learnings' => "What I Learned or Realized", 'plans' => "Plans for Tomorrow"] as $key => $label)
                        <label for="{{ $key }}">{{ $label }}:</label>
                        <textarea name="{{ $key }}" class="content-textarea">{{ $latestJournal->$key }}</textarea>
                        <label for="{{ $key }}_jp">({{ __('translations.' . $key) }})</label>
                        <textarea name="{{ $key }}_jp" class="content-textarea">{{ $latestJournal->{$key.'_jp'} }}</textarea>
                    @endforeach
                    <button type="submit" class="btn btn-outline-secondary fixed-submit-btn">Submit</button>
                </form>
                <button data-bs-toggle="modal" data-bs-target="#delete-{{ $latestJournal->id }}" class="btn btn-outline-secondary fixed-submit-btn mb-5">detail</button>
                @include('modal.JournalDelate')
            @else
                <p>No journal entries yet. Click "+" to add a new one.</p>
            @endif
        </div>

        <!-- 右側: タイムライン -->
        <div class="note-details">
            <div class="details-title">Day Activity</div>
            <div class="timeline">
                @forelse ($recordDates as $recordDate)
                    <div class="timeline-item">
                        <div class="timeline-text">
                            <p class="timeline-time">{{ \Carbon\Carbon::parse($recordDate->time)->format('H:i') }}</p>
                            <p>{{ $recordDate->content }}</p>
                        </div>
                        <div>
                            <button class="btn btn-edit">Edit</button>
                            <button data-bs-toggle="modal" data-bs-target="#delete-{{ $recordDate->id }}">detail</button>
                            @include('modal.delete', ['id' => $recordDate->id])
                        </div>
                    </div>
                @empty
                    <div>この日の記録はなし</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection