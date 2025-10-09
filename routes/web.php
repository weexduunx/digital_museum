<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtworkController;
use OpenAI\Laravel\Facades\OpenAI;

// Health check for Fly.io
Route::get('/health', function () {
    return response('OK', 200);
});

// Test OpenAI - À SUPPRIMER après débogage
Route::get('/test-openai', function () {
    try {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                ['role' => 'user', 'content' => 'Dis bonjour en JSON avec la clé "message"'],
            ],
        ]);

        return response()->json([
            'success' => true,
            'response' => $response->choices[0]->message->content,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }
});

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

Route::get('/visite-virtuelle', [ArtworkController::class, 'virtualTour'])->name('virtual.tour');

// Routes d'authentification
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Routes d'administration (protégées par authentification)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Gestion des œuvres d'art
    Route::resource('artworks', App\Http\Controllers\Admin\ArtworkController::class);
    Route::post('artworks/{artwork}/toggle-featured', [App\Http\Controllers\Admin\ArtworkController::class, 'toggleFeatured'])->name('artworks.toggle-featured');
    Route::post('artworks/{artwork}/toggle-active', [App\Http\Controllers\Admin\ArtworkController::class, 'toggleActive'])->name('artworks.toggle-active');
    Route::post('artworks/analyze-image', [App\Http\Controllers\Admin\ArtworkController::class, 'analyzeImage'])->name('artworks.analyze-image');

    // Gestion des catégories
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
});
