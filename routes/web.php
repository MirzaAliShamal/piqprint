<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessionController;

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


require __DIR__.'/auth.php';

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/generate-qr', [HomeController::class, 'generateQr'])->name('generate.qr');

Route::get('/session/{uniqueId}', [HomeController::class, 'session'])->name('session');

Route::prefix('/session/{uniqueId}')->middleware('check.session')->group(function () {
    Route::get('/end', [SessionController::class, 'end'])->name('end');
    Route::get('/photos', [SessionController::class, 'photos'])->name('photos');
    Route::post('/upload', [SessionController::class, 'upload'])->name('upload');
    Route::get('/photo/{photoId}', [SessionController::class, 'photo'])->name('photo');
    Route::post('/edited/{photoId}', [SessionController::class, 'edited'])->name('edited');
    Route::get('/checkout', [SessionController::class, 'checkout'])->name('checkout');
});

