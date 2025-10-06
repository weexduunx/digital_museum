<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
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
}
