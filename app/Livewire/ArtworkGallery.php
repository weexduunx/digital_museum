<?php

namespace App\Livewire;

use App\Models\Artwork;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class ArtworkGallery extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = null;
    public $showFeaturedOnly = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategory' => ['except' => null],
        'showFeaturedOnly' => ['except' => false],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function updatingShowFeaturedOnly()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'selectedCategory', 'showFeaturedOnly']);
        $this->resetPage();
    }

    public function render()
    {
        $artworks = Artwork::with('category')
            ->active()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('artist', 'like', '%' . $this->search . '%')
                      ->orWhere('description_fr', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedCategory, function ($query) {
                $query->where('category_id', $this->selectedCategory);
            })
            ->when($this->showFeaturedOnly, function ($query) {
                $query->featured();
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::withCount('artworks')->get();

        return view('livewire.artwork-gallery', [
            'artworks' => $artworks,
            'categories' => $categories,
        ]);
    }
}
