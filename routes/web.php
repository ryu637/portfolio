<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ChartController;
use App\Http\Middleware\EnsureTokenIsValid;



Auth::routes();
Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); 
Route::middleware(['user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/journal', [DiaryController::class, 'calendar'])->name('calendar');
    Route::get('/calendar', [DiaryController::class, 'calendar'])->name('diary');
    Route::get('/journal/journal', [JournalController::class, 'index'])->name('journal');
    Route::post('/journal/store', [JournalController::class, 'store'])->name('store');
    Route::Delete('/journal/delete/{id}', [JournalController::class, 'delete'])->name('delete.journal');
    Route::get('/journal/list', [DiaryController::class, 'list'])->name('list');
    Route::get('/journal/{date}', [DiaryController::class, 'showEntries'])->name('journal_entries');
    Route::POST('/journal/record', [DiaryController::class, 'store'])->name('journal.store');
    Route::POST('/journal/{id}/update', [JournalController::class, 'update'])->name('journal.update');
    Route::get('/journal/{date}/show', [JournalController::class, 'showByDate'])->name('journal.show');
    Route::get('/chart',[ChartController::class, 'index'])->name('chart');
    Route::delete('/delete/{id}/code', [DiaryController::class, 'delete'])->name('delete');
});


