<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class BulkDeleteModal extends ModalComponent
{
    public $checkboxValues = [];
    public $model;
    public $tableName;

    public function mount($checkboxValues = [], $model = '', $tableName = ''): void
    {
        $this->checkboxValues = is_array($checkboxValues) ? $checkboxValues : [];
        $this->model = $model;
        $this->tableName = $tableName;
    }

    public function execute(): void
    {
        $modelClass =  'App\\Models\\' . $this->model;

        if (class_exists($modelClass)) {
            $modelClass::whereIn('id', $this->checkboxValues)->delete();
            $this->closeModal();
            session()->flash('message', "{$this->tableName} records deleted successfully.");
            $this->dispatch('refreshUsersTable');
        }
    }

    public function render(): View
    {
        return view('livewire.bulk-delete-modal');
    }
}
