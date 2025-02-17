<?php

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use LivewireUI\Modal\ModalComponent;
use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;

middleware(['auth', 'verified', 'can:' . \App\Enums\Permissions::ManageUsers->value]);
name('users.edit');

new class extends ModalComponent implements HasForms {
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
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
            ])->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();
        $this->validate();
        $this->save();
    }
}
?>

<div>
    {{ $this->form }}

</div>

