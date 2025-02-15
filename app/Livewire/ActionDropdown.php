<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class ActionDropdown extends Component
{
    public Model $model;
    public array $actions = [];

    public function mount(Model $model, array $actions)
    {
        $this->model = $model;
        $this->actions = $actions;
    }

    public function callAction($action, $params = [])
    {
        if (method_exists($this, $action)) {
            $this->$action(...$params);
        } else {
            $this->dispatch('action::' . $action, $this->model->id, ...$params);
        }
    }

    public function render()
    {
        return view('livewire.action-dropdown');
    }
}
