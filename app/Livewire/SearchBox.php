<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;

class SearchBox extends Component
{

    public $search = '';


    public function updatedSearch() {
        $this->dispatch('search', search: $this->search);
    }

    public function updateSearch() {
        $this->dispatch('search', search: $this->search);
    }

    public function updatedCategory() {
        $this->dispatch('category', search: $this->category);
    }

    public function render(Request $request)
    {
        return view('livewire.search-box', compact('request'));
    }
}
