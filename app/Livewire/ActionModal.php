<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class ActionModal extends ModalComponent
{
    public $model;
    public $id;
    public $action;
    public $attribute;
    public $confirmationMessage;
    public $confirmButtonLabel;

    /**
     * Mount the modal with required data.
     */
    public function mount($model, $id, $action = 'delete', $attribute = null): void
    {
        $this->model = $model;
        $this->id = $id;
        $this->action = $action;
        $this->attribute = $attribute;

        // Set modal messages dynamically
        if ($action === 'delete') {
            $this->confirmationMessage = "Are you sure you want to delete this $model?";
            $this->confirmButtonLabel = "Delete";
        } elseif ($action === 'toggle') {
            $this->confirmationMessage = "Are you sure you want to change the status?";
            $this->confirmButtonLabel = "Confirm";
        }
    }

    /**
     * Perform the specified action.
     */
    public function execute(): void
    {
        $modelClass = 'App\\Models\\' . $this->model;

        if (!class_exists($modelClass)) {
            return;
        }

        $record = $modelClass::findOrFail($this->id);

        if ($this->action === 'delete') {
            $record->delete();
            $this->dispatch('toast', ['type' => 'success', 'message' => 'User Deleted Successfully']);
            $this->dispatch('record-deleted', $this->id);
        } elseif ($this->action === 'toggle' && $this->attribute) {
            $record->update([$this->attribute => !$record->{$this->attribute}]);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'User Deleted Successfully']);
            $this->dispatch('record-updated', $this->id);
        }

        $this->closeModal();
    }

    public function render(): View
    {
        return view('livewire.action-modal');
    }
}
