<?php

namespace App\Livewire\Users;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\View\View;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public ?User $user = null;

    public function mount(?int $id): void
    {
        $this->user = $id ? User::find($id) : null;

        if (!$this->user && $id) {
            abort(404, 'User not found');
        }

        $this->data = $this->getUserData();
        $this->form->fill($this->data);
    }

    private function getUserData(): array
    {
        return [
            'name' => $this->user?->name ?? '',
            'username' => $this->user?->username ?? '',
            'email' => $this->user?->email ?? '',
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                TextInput::make('username')
                    ->label('Username')
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->required(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();
        $this->validate();

        if ($this->user) {
            // Update existing user
            $this->user->update($state);
        } else {
            // Create new user
            User::create($state);
        }

        $this->closeModal();
        $this->dispatch('refreshUsersTable');
    }

    public function render(): View
    {
        return view('livewire.users.create');
    }
}
