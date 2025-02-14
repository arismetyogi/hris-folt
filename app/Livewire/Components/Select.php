<?php

namespace App\Livewire\Components;

use Illuminate\Support\Collection;
use Livewire\Component;

class Select extends Component
{
    public function __construct(public Collection $options, public int $modelId, public string $selected)
    {
    }

    public function render()
    {
        return view('components.select');
    }
}
