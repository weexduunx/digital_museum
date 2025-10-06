<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtworkController;

Route::get('/', function () {
    return view('gallery');
})->name('home');

Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');

Route::get('/artwork/{qr_code}', [ArtworkController::class, 'show'])->name('artwork.show');

Route::get('/qr/{qr_code}', [ArtworkController::class, 'show'])->name('qr.scan');

Route::get('/qr-code/{qr_code}', [ArtworkController::class, 'generateQrCode'])->name('qr.generate');

Route::get('/qr-gallery', function () {
    return view('qr-gallery');
})->name('qr.gallery');
