<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\OutputStyle;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Output\BufferedOutput;
use Illuminate\Filesystem\Filesystem;

Route::get('/', function () {
    return view('welcome');
});


Route::get("/check-db", function () {
    $check  =  Storage::exists("/var/www/html/storage/database/database.sqlite");
    if ($check) {
        return "Database exist";
    } else {
        return "False no database onn /var/www/html/storage/database/database.sqlite";
    }

    return $check;
});

Route::get("/get-path", function () {
    $contents = (new Filesystem)->allFiles('/var/www/html/storage');
    return $contents;
});

Route::get("/run-command", function () {
    //  $output = Artisan::handle('my:command', ['--argument' => 'value']);
    $rst = Artisan::call('migrate');
    return $rst;
});

Route::get('/db-connection', function () {
    $output = new BufferedOutput;
    $rst = Artisan::call('db:show',[], $output);
    return $output;
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
