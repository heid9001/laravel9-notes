<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function(){
    if($user = Auth::user()) {
        return new \Illuminate\Http\JsonResponse([
            'status' => 'ok',
            'email' => $user->email,
            'tokens' => $user->tokens()->count(),
            'remember' => Auth::viaRemember()
        ]);
    }
    return new \Illuminate\Http\JsonResponse([
        'status' => 'auth failed'
    ]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // notes
    Route::get('/notes/list', [NotesController::class, 'list'])->name('notes.list');
    Route::get('/notes', [NotesController::class, 'view'])->name('notes.view');
    Route::post('/notes', [NotesController::class, 'create'])->name('notes.new');
    Route::delete('/notes/{id}', [NotesController::class, 'delete'])->name('notes.delete');
    Route::patch('/notes/{id}', [NotesController::class, 'update'])->name('notes.update');

    Route::get('/notes/paging', [NotesController::class, 'paging'])->name('notes.paging');
});

require __DIR__.'/auth.php';
