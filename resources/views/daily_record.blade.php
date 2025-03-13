@extends('layouts.app')

@section('title', 'Journal Entries')

@section('content')
<style>
body {
    overflow-y: hidden; 
    background-color: #F5EFE7;
}

.container-1 {
    background-image: url("{{ asset('images/image 1.png') }}");
    background-size: cover; 
    background-position: center;
    height: 80vh;
    margin-top: 40px;
    width: 100%;
    border-radius: 15px; 
    box-shadow: inset 0 0 30px rgba(0, 0, 0, 0.5); 
    margin-right: 35px;
    margin-left: 43px;
}

/* Form Styling */
.form-container {
    width: 45%;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    font-size: 1rem;
    color: #333;
    margin-bottom: 8px;
    font-weight: bold;
}

.form-input, .form-textarea {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border-radius: 10px;
    border: 1px solid #ddd;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.form-input:focus, .form-textarea:focus {
    border-color: #6C5B3B;
    outline: none;
}

.form-textarea {
    height: 120px;
}

/* Button Styles */
.btn {
    padding: 12px 20px;
    border-radius: 10px;
    font-size: 1.1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-submit {
    background-color: #6C5B3B;
    color: white;
    border: none;
    width: 100%;
    margin-bottom: 15px;
}

.btn-submit:hover {
    background-color: #5a4a35;
}

.btn-secondary {
    background-color: #ddd;
    color: #333;
    border: none;
    width: 100%;
}

.btn-secondary:hover {
    background-color: #bbb;
}

/* Remove background color and simplify the design */
.entry-list {
    margin-top: 50px;
    overflow-y: auto;
    height: 75%;
}

.entry-item {
    margin-bottom: 15px;
    padding: 15px;
    border-left: 4px solid #6C5B3B; /* A simple line to the left for emphasis */
    background-color: #fff; /* Keep the white background for readability */
    border-radius: 8px; /* Soft rounded corners */
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); /* Light shadow to separate from the background */
}

/* Entry Time */
.entry-time {
    font-size: 1.1rem;
    font-weight: bold;
    color: #6C5B3B;
    margin-bottom: 10px;
}

/* Entry Content */
.entry-content {
    font-size: 1rem;
    color: #333;
}

/* No entries message */
.no-entries {
    font-size: 1.2rem;
    color: #6C5B3B;
    font-weight: bold;
    margin-top: 40px;
}


    </style>
<div class="container">
    <div class="row container-1">
        <div class="col-6 form-container">
            <h1 class="text-center mb-5 mt-5">{{ $date }} の記録</h1>
            <form action="{{ route('user.journal.store') }}" method="POST">
                @csrf
                <input type="hidden" name="date" value="{{ $date }}">
        
                <div class="form-group">
                    <label for="time" class="form-label">時間:</label>
                    <input type="time" name="time" required class="form-input" value="{{  \Carbon\Carbon::now()->format('H:i') }}">
                </div>
        
                <div class="form-group">
                    <label for="content" class="form-label">内容:</label>
                    <textarea name="content" required class="form-textarea"></textarea>
                </div>
        
                <button type="submit" class="btn btn-submit">記録を追加</button>
            </form>
        
            <a href="{{ route('user.diary')}}" class="btn btn-secondary mt-3">カレンダーに戻る</a>
            {{-- <a href="{{ route('user.calendar', ['year' => \Carbon\Carbon::parse($date)->format('Y'), 'month' => \Carbon\Carbon::parse($date)->format('m')]) }}" class="btn btn-secondary mt-3">カレンダーに戻る</a> --}}
        </div>
        
        <div class="col-6">
            @if ($entries->isEmpty())
                <p class="text-center no-entries">この日に記録はありません。</p>
            @else
                <div class="entry-list">
                    @foreach ($entries as $entry)
                        <div class="entry-item">
                            <h5 class="entry-time mb-1">{{ $entry->time }}</h5>
                            <p class="entry-content" contenteditable="false" data-id="{{ $entry->id }}">{{ $entry->content }}</p>
                            <button class="btn btn-edit">Edit</button>
                            <button data-bs-toggle="modal" data-bs-target="#delete-{{ $entry->id }}">
                                detail
                            </button>
                            @include('modal.delete',['id' => $entry->id])
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".btn-edit").forEach(button => {
                button.addEventListener("click", function() {
                    let entryContent = this.previousElementSibling;
                    let entryId = entryContent.dataset.id;
                    
                    if (entryContent.contentEditable === "true") {
                        // 編集モード終了
                        entryContent.contentEditable = "false";
                        this.textContent = "Edit";
        
                        // 保存処理
                        fetch("/update-entry", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                id: entryId,
                                content: entryContent.innerText
                            })
                        })
                        .then(response => response.json())
                        .then(data => console.log("Updated:", data))
                        .catch(error => console.error("Error:", error));
        
                    } else {
                        // 編集モード開始
                        entryContent.contentEditable = "true";
                        entryContent.focus();
                        this.textContent = "Save";
                    }
                });
            });
        });
        </script>
        
        
    </div>

</div>


@endsection
