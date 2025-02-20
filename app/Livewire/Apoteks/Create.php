<?php

namespace App\Livewire\Apoteks;

use App\Models\Apotek;
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
    public ?Apotek $apotek = null;

    public function mount(?int $id): void
    {
        $this->apotek = $id ? Apotek::with('branch')->find($id) : null;

        if (!$this->apotek && $id) {
            abort(404, 'Apotek not found');
        }

        $this->data = $this->getApotekData();
        $this->form->fill($this->data);
    }

    private function getApotekData(): array
    {
        return [
            'name' => $this->apotek?->name ?? null,
            'store_type' => $this->apotek?->store_type ?? null,
            'branch_id' => $this->apotek?->branch_id ?? null,
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                Select::make('store_type')
                    ->options([
                        'BASIC_HEALTH' => 'Basic Health',
                        'SUPER_STORE' => 'Super Store',
                        'HEALTH_AND_CARE' => 'Health & Care',
                        'MEDICAL' => 'Medical',
                        'CHILD' => 'Child',
                        'NEW' => 'New',
                        null => 'None',
                        ])
                    ->label('Type Store')
                    ->required(),
                Select::make('branch_id')
                    ->options(UnitBisnis::all()->pluck('name', 'id'))
                    ->label('Unit Bisnis')
                    ->required(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();
        $this->validate();

        if ($this->apotek) {
            // Update existing apotek
            $this->apotek->update($state);
        } else {
            // Create new apotek
            Apotek::create($state);
        }

        $this->closeModal();
        $this->dispatch('refreshApotekTable');
    }

    public function render(): View
    {
        return view('livewire.apoteks.create');
    }
}
