<?php
use App\Http\Controllers\PollController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/polls', [PollController::class, 'index'])->name('polls.index');
    Route::get('/polls/create', [PollController::class, 'create'])->name('polls.create');
    Route::get('/polls/show/{slug}', [PollController::class, 'show'])->name('polls.show');
    Route::post('/polls', [PollController::class, 'store'])->name('polls.store');
    Route::get('/polls/{poll}/edit', [PollController::class, 'edit'])->name('polls.edit');
    Route::put('/polls/{poll}', [PollController::class, 'update'])->name('polls.update');
    Route::delete('/polls/{poll}', [PollController::class, 'destroy'])->name('polls.destroy');

     // Poll results
     Route::get('/polls/{slug}/results', [PollController::class, 'results'])->name('polls.results');

    // Export
    Route::get('/polls/{slug}/export/excel', [ExportController::class, 'exportExcel'])->name('polls.export.excel');
    Route::get('/polls/{slug}/export/csv', [ExportController::class, 'exportCsv'])->name('polls.export.csv');
});
// Public poll routes (no auth required)
Route::get('/poll/{slug}', [PollController::class, 'show'])->name('polls.show');
Route::post('/poll/{slug}/vote', [VoteController::class, 'store'])->name('polls.vote');
Route::get('/poll/{slug}/thankyou', [VoteController::class, 'thankyou'])->name('polls.thankyou');


require __DIR__.'/auth.php';
