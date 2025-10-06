<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtworkController extends Controller
{
    public function index()
    {
        $artworks = Artwork::with('category')
            ->latest()
            ->paginate(15);

        return view('admin.artworks.index', compact('artworks'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.artworks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description_fr' => 'required|string',
            'description_en' => 'nullable|string',
            'description_wo' => 'nullable|string',
            'creation_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'medium' => 'nullable|string|max:255',
            'dimensions' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'audio_fr' => 'nullable|mimes:mp3,wav,ogg|max:10240',
            'audio_en' => 'nullable|mimes:mp3,wav,ogg|max:10240',
            'audio_wo' => 'nullable|mimes:mp3,wav,ogg|max:10240',
            'video' => 'nullable|mimes:mp4,avi,mov|max:51200',
            'historical_context' => 'nullable|string',
            'cultural_significance' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        // Générer un code QR unique
        $validated['qr_code'] = $this->generateUniqueQrCode();

        // Gérer l'upload de l'image
        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('artworks/images', 'public');
        }

        // Gérer l'upload des fichiers audio
        if ($request->hasFile('audio_fr')) {
            $validated['audio_path_fr'] = $request->file('audio_fr')->store('artworks/audio', 'public');
        }
        if ($request->hasFile('audio_en')) {
            $validated['audio_path_en'] = $request->file('audio_en')->store('artworks/audio', 'public');
        }
        if ($request->hasFile('audio_wo')) {
            $validated['audio_path_wo'] = $request->file('audio_wo')->store('artworks/audio', 'public');
        }

        // Gérer l'upload de la vidéo
        if ($request->hasFile('video')) {
            $validated['video_path'] = $request->file('video')->store('artworks/videos', 'public');
        }

        // Convertir les chaînes en tableaux pour les champs JSON
        if (!empty($validated['historical_context'])) {
            $validated['historical_context'] = array_filter(explode("\n", $validated['historical_context']));
        }
        if (!empty($validated['cultural_significance'])) {
            $validated['cultural_significance'] = array_filter(explode("\n", $validated['cultural_significance']));
        }

        Artwork::create($validated);

        return redirect()->route('admin.artworks.index')
            ->with('success', 'Œuvre d\'art créée avec succès!');
    }

    public function show(Artwork $artwork)
    {
        return view('admin.artworks.show', compact('artwork'));
    }

    public function edit(Artwork $artwork)
    {
        $categories = Category::all();
        return view('admin.artworks.edit', compact('artwork', 'categories'));
    }

    public function update(Request $request, Artwork $artwork)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description_fr' => 'required|string',
            'description_en' => 'nullable|string',
            'description_wo' => 'nullable|string',
            'creation_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'medium' => 'nullable|string|max:255',
            'dimensions' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'audio_fr' => 'nullable|mimes:mp3,wav,ogg|max:10240',
            'audio_en' => 'nullable|mimes:mp3,wav,ogg|max:10240',
            'audio_wo' => 'nullable|mimes:mp3,wav,ogg|max:10240',
            'video' => 'nullable|mimes:mp4,avi,mov|max:51200',
            'historical_context' => 'nullable|string',
            'cultural_significance' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        // Gérer l'upload de la nouvelle image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($artwork->image_path) {
                Storage::disk('public')->delete($artwork->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('artworks/images', 'public');
        }

        // Gérer l'upload des nouveaux fichiers audio
        if ($request->hasFile('audio_fr')) {
            if ($artwork->audio_path_fr) {
                Storage::disk('public')->delete($artwork->audio_path_fr);
            }
            $validated['audio_path_fr'] = $request->file('audio_fr')->store('artworks/audio', 'public');
        }
        if ($request->hasFile('audio_en')) {
            if ($artwork->audio_path_en) {
                Storage::disk('public')->delete($artwork->audio_path_en);
            }
            $validated['audio_path_en'] = $request->file('audio_en')->store('artworks/audio', 'public');
        }
        if ($request->hasFile('audio_wo')) {
            if ($artwork->audio_path_wo) {
                Storage::disk('public')->delete($artwork->audio_path_wo);
            }
            $validated['audio_path_wo'] = $request->file('audio_wo')->store('artworks/audio', 'public');
        }

        // Gérer l'upload de la nouvelle vidéo
        if ($request->hasFile('video')) {
            if ($artwork->video_path) {
                Storage::disk('public')->delete($artwork->video_path);
            }
            $validated['video_path'] = $request->file('video')->store('artworks/videos', 'public');
        }

        // Convertir les chaînes en tableaux pour les champs JSON
        if (!empty($validated['historical_context'])) {
            $validated['historical_context'] = array_filter(explode("\n", $validated['historical_context']));
        } else {
            $validated['historical_context'] = [];
        }

        if (!empty($validated['cultural_significance'])) {
            $validated['cultural_significance'] = array_filter(explode("\n", $validated['cultural_significance']));
        } else {
            $validated['cultural_significance'] = [];
        }

        $artwork->update($validated);

        return redirect()->route('admin.artworks.index')
            ->with('success', 'Œuvre d\'art mise à jour avec succès!');
    }

    public function destroy(Artwork $artwork)
    {
        // Supprimer les fichiers associés
        if ($artwork->image_path) {
            Storage::disk('public')->delete($artwork->image_path);
        }
        if ($artwork->audio_path_fr) {
            Storage::disk('public')->delete($artwork->audio_path_fr);
        }
        if ($artwork->audio_path_en) {
            Storage::disk('public')->delete($artwork->audio_path_en);
        }
        if ($artwork->audio_path_wo) {
            Storage::disk('public')->delete($artwork->audio_path_wo);
        }
        if ($artwork->video_path) {
            Storage::disk('public')->delete($artwork->video_path);
        }

        $artwork->delete();

        return redirect()->route('admin.artworks.index')
            ->with('success', 'Œuvre d\'art supprimée avec succès!');
    }

    public function toggleFeatured(Artwork $artwork)
    {
        $artwork->update(['is_featured' => !$artwork->is_featured]);

        $status = $artwork->is_featured ? 'ajoutée aux' : 'retirée des';
        return back()->with('success', "Œuvre {$status} coups de cœur!");
    }

    public function toggleActive(Artwork $artwork)
    {
        $artwork->update(['is_active' => !$artwork->is_active]);

        $status = $artwork->is_active ? 'activée' : 'désactivée';
        return back()->with('success', "Œuvre {$status}!");
    }

    private function generateUniqueQrCode()
    {
        do {
            $qrCode = strtoupper(Str::random(8));
        } while (Artwork::where('qr_code', $qrCode)->exists());

        return $qrCode;
    }
}