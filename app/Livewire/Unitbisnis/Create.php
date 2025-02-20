<?php

namespace App\Livewire\Unitbisnis;

use App\Models\UnitBisnis;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
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
    public ?UnitBisnis $unitbisnis = null;

    public function mount(?int $id): void
    {
        $this->unitbisnis = $id ? UnitBisnis::find($id) : null;

        if (!$this->unitbisnis && $id) {
            abort(404, 'Unit Bisnis not found');
        }

        $this->data = $this->getUnitBisnisData();
        $this->form->fill($this->data);
    }

    private function getUnitBisnisData(): array
    {
        return [
            'name' => $this->unitbisnis?->name ?? null,
            'code' => $this->unitbisnis?->code ?? null,
            'address' => $this->unitbisnis?->address ?? null,
            'flag' => $this->unitbisnis?->flag ?? null,
            'email' => $this->unitbisnis?->email ?? null,
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label('Kode SAP')
                    ->integer()
                    ->required(),
                TextInput::make('name')
                    ->label('Nama BM')
                    ->required(),
                TextInput::make('address')
                    ->label('Alamat')
                    ->required(),
                Radio::make('flag')
                    ->label('Flag BM')
                    ->options([
                        '1' => 'Aktif',
                        '0' => 'Non Aktif',
                    ])
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();
        $this->validate();

        if ($this->unitbisnis) {
            // Update existing unitbisnis
            $this->unitbisnis->update($state);
        } else {
            // Create new unitbisnis
            UnitBisnis::create($state);
        }

        $this->closeModal();
        $this->dispatch('refreshUnitBisnisTable');
    }

    public function render(): View
    {
        return view('livewire.unitbisnis.create');
    }
}
