<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ArtworkController extends Controller
{
    public function show($qr_code)
    {
        $artwork = Artwork::with('category')
            ->where('qr_code', $qr_code)
            ->where('is_active', true)
            ->firstOrFail();

        return view('artwork.show', compact('artwork'));
    }

    public function generateQrCode($qr_code)
    {
        $artwork = Artwork::where('qr_code', $qr_code)
            ->where('is_active', true)
            ->firstOrFail();

        $url = route('artwork.show', $qr_code);

        return response(
            QrCode::format('svg')
                  ->size(200)
                  ->margin(2)
                  ->generate($url),
            200,
            [
                'Content-Type' => 'image/svg+xml',
                'Cache-Control' => 'public, max-age=3600',
            ]
        );
    }

    public function virtualTour()
    {
        $artworks = Artwork::with('category')
            ->where('is_active', true)
            ->get()
            ->map(function ($artwork) {
                return [
                    'id' => $artwork->id,
                    'title' => $artwork->title,
                    'artist' => $artwork->artist,
                    'description' => $artwork->description,
                    'image_path' => $artwork->image_path ? asset('storage/' . $artwork->image_path) : null,
                    'audio_path' => $artwork->audio_path ? asset('storage/' . $artwork->audio_path) : null,
                    'category' => [
                        'name' => $artwork->category->name,
                        'color' => $artwork->category->color,
                    ],
                    'qr_code' => $artwork->qr_code,
                    'is_featured' => $artwork->is_featured,
                ];
            });

        return view('virtual-tour', compact('artworks'));
    }
}
