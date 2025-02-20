<?php

namespace App\Livewire\Karyawans;

use App\Models\Apotek;
use App\Models\Karyawan;
use App\Models\UnitBisnis;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public ?Karyawan $karyawan = null;

    public function mount(?int $id): void
    {
        $this->karyawan = $id ? Karyawan::with(['branch','apotek'])->find($id) : null;

        if (!$this->apotek && $id) {
            abort(404, 'Karyawan not found');
        }

        $this->data = $this->getKaryawanData();
        $this->form->fill($this->data);
    }

    private function getKaryawanData(): array
    {
        return [
            'bramch_id' => $this->karyawan?->branch_id ?? null,
            'name' => $this->karyawan?->name ?? null,
            'nik' => $this->karyawan?->nik ?? null,
            'npwp' => $this->karyawan?->npwp ?? null,
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('branch_id')
                    ->label('Unit Bisnis')
                    ->required(),
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
    public function render()
    {
        return view('livewire.karyawans.create');
    }
}
