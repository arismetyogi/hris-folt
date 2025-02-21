<?php

namespace App\Livewire\Karyawans;

use App\Models\Bank;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Subjabatan;
use App\Models\UnitBisnis;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\View\View;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public ?Karyawan $karyawan = null;
    public $editMode = false;

    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function mount(?int $id = null): void
    {
        $this->karyawan = $id ? Karyawan::with(['branch', 'apotek'])->find($id) : null;

        if (!$this->karyawan && $id) {
            abort(404, 'Karyawan not found');
        }

        $this->data = $this->getKaryawanData();
        $this->form->fill($this->data);
    }

    private function getKaryawanData(): array
    {
        return [
            'branch_id' => $this->karyawan?->branch_id ?? null,
            'name' => $this->karyawan?->name ?? null,
            'nik' => $this->karyawan?->nik ?? null,
            'npwp' => $this->karyawan?->npwp ?? null,
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Personal Info')
                        ->columns(2)
                        ->schema([
                            TextInput::make('name')
                                ->label('Nama')
                                ->validationAttribute('Nama')
                                ->validationMessages(['required'=>'Kolom :attribute tidak boleh kosong'])
                                ->required(),
                            TextInput::make('nik')
                                ->label('NIK')
                                ->validationAttribute('NIK')
                                ->required(),
                            TextInput::make('npp')
                                ->label('NPP')
                                ->validationAttribute('NPP')
                                ->required(),
                        ]),

                    Step::make('Professional Info')
                        ->columns(2)
                        ->schema([
                            Select::make('branch_id')
                                ->options(UnitBisnis::all()->pluck('name', 'id'))
                                ->label('Unit Bisnis')
                                ->placeholder('Pilih Unit Bisnis')
                                ->required(),
                            Select::make('jabatan_id')
                                ->options(Jabatan::all()->pluck('name', 'id'))
                                ->label('Position')
                                ->required(),
                            Select::make('subjabatan_id')
                                ->options(Subjabatan::all()->pluck('name', 'id'))
                                ->label('Sub Jabatan')
                                ->required(),
                            TextInput::make('sap_id')
                                ->label('ID SAP')
                                ->required()
                                ->numeric(),
                        ]),

                    Step::make('Contract Details')
                        ->columns(2)
                        ->schema([
                            Select::make('contract_document_id')
                                ->label('No Kontrak'),
                            TextInput::make('contract_sequence_no')
                                ->label('Kontrak Ke-')
                                ->numeric(),
                            DatePicker::make('contract_start')
                                ->label('Awal Kontrak'),
                            DatePicker::make('contract_end')
                                ->label('Akhir Kontrak'),
                        ]),
                    Step::make('Bank Account Details')
                        ->columns(2)
                        ->schema([
                            Select::make('bank_id')
                                ->options(Bank::all()->pluck('name', 'id'))
                                ->label('Bank Name')
                                ->required(),
                            TextInput::make('account_no')
                                ->label('Account Number')
                                ->required()
                                ->numeric(),
                            TextInput::make('account_name')
                                ->label('Account Holder')
                                ->required(),
                        ]),
                ])
                    ->columns(8)
                    ->key('karyawan_wizard')
                    ->nextAction(fn ($get, $set) => Action::make('next')
                        ->label('Next ➝')
                        ->color('primary')
                        ->extraAttributes([
                            'class' => 'bg-blue-500 hover:bg-blue-700 text-white dark:bg-gray-700 dark:hover:bg-gray-600 transition',
                        ])
                    )
                    ->previousAction(fn ($get, $set) => Action::make('previous')
                        ->label('← Back')
                        ->color('secondary')
                        ->extraAttributes([
                            'class' => 'bg-gray-300 hover:bg-gray-400 dark:bg-gray-700 dark:hover:bg-gray-600 text-black dark:text-white transition',
                        ])
                    ),
            ])->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();
        $this->validate();

        if ($this->karyawan) {
            // Update existing karyawan
            $this->karyawan->update($state);
        } else {
            // Create new karyawan
            Karyawan::create($state);
        }

        $this->closeModal();
        $this->dispatch('refreshKaryawanTable');
    }

    public function render(): View
    {
        return view('livewire.karyawans.create');
    }
}
