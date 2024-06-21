<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\OutputStyle;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Output\BufferedOutput;

Route::get('/', function () {
    return view('welcome');
});


Route::get("/check-db", function () {
    $check  =  Storage::has("/var/www/html/storage/database/database.sqlite");

    return $check;
});

Route::get("/run-command", function () {
    //  $output = Artisan::handle('my:command', ['--argument' => 'value']);
    $rst = Artisan::call('migrate');
    return $rst;
});

Route::get("/run-handle", function () {
    //  $output = Artisan::handle('my:command', ['--argument' => 'value']);
    $output = new BufferedOutput;
    $rst = Artisan::handle('migrate', $output);
    return $output;
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
