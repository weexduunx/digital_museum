<?php

namespace App\Livewire;

use App\Models\Artwork;
use Livewire\Component;

class ArtworkCard extends Component
{
    public Artwork $artwork;

    public function mount(Artwork $artwork)
    {
        $this->artwork = $artwork;
    }

    public function render()
    {
        return view('livewire.artwork-card');
    }
}
