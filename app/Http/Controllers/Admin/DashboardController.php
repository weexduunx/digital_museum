<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_artworks' => Artwork::count(),
            'active_artworks' => Artwork::active()->count(),
            'featured_artworks' => Artwork::featured()->count(),
            'total_categories' => Category::count(),
        ];

        $recent_artworks = Artwork::with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_artworks'));
    }
}