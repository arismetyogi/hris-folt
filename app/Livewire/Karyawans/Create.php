<?php

namespace App\Livewire\Karyawans;

use App\Models\Apotek;
use App\Models\Band;
use App\Models\Bank;
use App\Models\EmployeeStatus;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Subjabatan;
use App\Models\UnitBisnis;
use App\Models\Zip;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
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
        return '6xl';
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
                        ->description('Personal Informations')
                        ->columns(2)
                        ->schema([
                            TextInput::make('name')
                                ->label('Nama')
                                ->validationAttribute('Nama')
                                ->validationMessages(['required' => 'Kolom :attribute tidak boleh kosong'])
                                ->required(),
                            TextInput::make('nik')
                                ->label('NIK')
                                ->validationAttribute('NIK')
                                ->unique(Karyawan::class, 'nik', ignoreRecord: true)
                                ->maxlength(16)
                                ->placeholder('19001030102200001')
                                ->rules('string|max:16|min:16')
                                ->reactive()
                                ->required()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    // Ensure only numeric values remain
                                    $set('nik', preg_replace('/\D/', '', $state));
                                }),
                            TextInput::make('npwp')
                                ->label('NPWP')
                                ->validationAttribute('NPWP')
                                ->required()
                                ->type('text')
                                ->maxLength(16)
                                ->reactive()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    // Ensure only numeric values remain
                                    $set('npwp', preg_replace('/\D/', '', $state));
                                }),
                            DatePicker::make('date_of_birth')
                                ->label('Tanggal Lahir')
                                ->required(),
                            TextInput::make('phone')
                                ->label('Nomor Telepon')
                                ->tel()
                                ->prefix('+62')
                                ->placeholder('81234567890')
                                ->required(),
                            Select::make('sex')
                                ->label('Jenis Kelamin')
                                ->options(['L' => 'Laki-laki', 'P' => 'Perempuan'])
                                ->required()
                                ->live()
                                ->afterStateUpdated(function ($set, $state) {
                                    // Reset the 'pants_size' field when 'sex' changes
                                    $set('pants_size', null);
                                }),
                            Select::make('religion')
                                ->label('Agama')
                                ->options([
                                    'islam' => 'Islam',
                                    'kristen' => 'Kristen',
                                    'katolik' => 'Katolik',
                                    'hindu' => 'Hindu',
                                    'budha' => 'Budha',
                                    'konghucu' => 'Konghucu',
                                    'lainnya' => 'Lainnya',
                                ])
                                ->required(),
                            Select::make('blood_type')
                                ->label('Golongan Darah')
                                ->options([
                                    'A' => 'A',
                                    'B' => 'B',
                                    'AB' => 'AB',
                                    'O' => 'O',
                                ]),
                            TextInput::make('address')
                                ->label('Alamat')
                                ->required()
                                ->placeholder('Jl. Budi Utomo No. 1, Pasar Baru')
                                ->maxLength(255)
                                ->columnSpan(2),
                            Select::make('zip_id')
                                ->label('Kode Pos')
                                ->getSearchResultsUsing(function (string $search) {
                                    return Zip::query()
                                        ->whereAny(['code', 'urban', 'subdistrict'], 'like', "%{$search}%")
                                        ->limit(10) // Limit the number of results to avoid performance issues
                                        ->get()
                                        ->mapWithKeys(function ($zip) {
                                            return [
                                                $zip->id => "{$zip->code} - {$zip->urban}, {$zip->subdistrict}"
                                            ];
                                        });
                                })
                                ->searchable(),
                        ]),

                    Step::make('Professional Info')
                        ->columns(2)
                        ->schema([
                            Select::make('branch_id')
                                ->disabled(
                                    fn($livewire) => !(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                                )
                                ->default(auth()->user()->branch_id)
                                ->getSearchResultsUsing(function (string $search) {
                                    return UnitBisnis::query()
                                        ->whereAny(['name', 'code'], 'like', "%{$search}%")
                                        ->limit(10)
                                        ->get()
                                        ->mapWithKeys(function ($branch) {
                                            return [
                                                $branch->id => "{$branch->id}",
                                            ];
                                        });
                                })
                                ->searchable()
                                ->live()
                                ->preload()
                                ->afterStateUpdated(
                                    fn(Set $set) => $set('apotek_id', null))
                                ->label('Unit Bisnis')
                                ->placeholder('Pilih Unit Bisnis')
                                ->required(),
                            Select::make('apotek_id')
                                ->options(
                                    fn(Get $get) => Apotek::query()
                                        ->where('branch_id', $get('branch_id'))
                                        ->pluck('name', 'id')
                                )
                                ->live()
                                ->preload()
                                ->searchable()
                                ->label('Apotek')
                                ->placeholder('Pilih Apotek')
                                ->required(),
                            TextInput::make('sap_id')
                                ->label('ID SAP')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->type('text')
                                ->maxLength(13)
                                ->afterStateUpdated(function (callable $set, $state) {
                                    // Ensure only numeric values remain
                                    $set('sap_id', preg_replace('/\D/', '', $state));
                                })
                                ->rules(['required', 'regex:/^(\d{8}|\d{13})$/']),
                            TextInput::make('npp')
                                ->label('NPP')
                                ->validationAttribute('NPP')
                                ->unique(ignoreRecord: true)
                                ->live()
                                ->type('text')
                                ->maxLength(10)
                                ->placeholder('19990101A')
                                ->rules(['regex:/^\d{8}[A-Z]{1,2}$/'])
                                ->required(),
                            Select::make('employee_status_id')
                                ->options(EmployeeStatus::all()->pluck('name', 'id'))
                                ->label('Employee Status')
                                ->required(),
                            Select::make('jabatan_id')
                                ->options(Jabatan::all()->pluck('name', 'id'))
                                ->label('Position')
                                ->required(),
                            Select::make('subjabatan_id')
                                ->options(Subjabatan::all()->pluck('name', 'id'))
                                ->label('Sub Jabatan')
                                ->required(),
                            Select::make('band_id')
                                ->options(Band::all()->pluck('name', 'id'))
                                ->label('Band')
                                ->required(),
                            Select::make('gradeeselon_id')
                                ->label('Grade Eselon')
                                ->relationship('gradeeselon', 'id')
                                ->getOptionLabelFromRecordUsing(
                                    fn($record) => "{$record->grade} - {$record->eselon}")
                                ->preload()
                                ->required(),
                            Select::make('area_id')
                                ->label('Area')
                                ->relationship('area', 'name')
                                ->required(),
                            Select::make('emplevel_id')
                                ->label('Level Pegawai')
                                ->relationship('emplevel', 'name')
                                ->required(),
                            TextInput::make('saptitle_id')
                                ->label('Kode Jab SAP')
                                ->unique(ignoreRecord: true)
                                ->type('text')
                                ->maxLength(50)
                                ->required(),
                            TextInput::make('saptitle_name')
                                ->label('Nama Jab SAP')
                                ->placeholder('PELAKSANA PENUNJANG LAYANAN FARMASI')
                                ->required()
                                ->columnSpan(2)
                                ->maxLength(255),
                            DatePicker::make('date_hired')
                                ->label('Tanggal Mulai Bekerja')
                                ->required(),
                            DatePicker::make('date_promoted')
                                ->label('Tanggal Diangkat')
                                ->required(),
                            DatePicker::make('date_last_mutated')
                                ->label('Tanggal Mutasi Terakhir')
                                ->required(),
                            Select::make('descstatus_id')
                                ->label('Deskripsi Status')
                                ->relationship('descstatus', 'name')
                                ->required(),
                        ]),

                    Step::make('Contract Details')
                        ->columns(2)
                        ->schema([

                        ]),

                    Step::make('Contract Details')
                        ->columns(2)
                        ->schema([
                            TextInput::make('contract_document_id')
                                ->label('No Kontrak'),
                            TextInput::make('contract_sequence_no')
                                ->label('Kontrak Ke-')
                                ->rules('min:1|max:3')
                                ->numeric(),
                            DatePicker::make('contract_start')
                                ->label('Awal Kontrak'),
                            DatePicker::make('contract_end')
                                ->after('contract_start')
                                ->label('Akhir Kontrak'),
                        ]),
                    Step::make('Insurance & Bank Details')
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
                            TextInput::make('bpjs_id')
                                ->label('No BPJS')
                                ->unique(ignoreRecord: true)
                                ->placeholder('0001234567890')
                                ->required()
                                ->type('text')
                                ->reactive()
                                ->maxLength(13)
                                ->rules('string|max:13|min:13')
                                ->afterStateUpdated(function (callable $set, $state) {
                                    // Ensure only numeric values remain
                                    $set('bpjs_id', preg_replace('/\D/', '', $state));
                                }),
                            TextInput::make('bpjs_class')
                                ->label('Kelas BPJS')
                                ->integer()
                                ->minValue(1)
                                ->maxValue(3)
                                ->required()
                                ->rules(['integer', 'min:1', 'max:3']),
                            TextInput::make('insured_member_count')
                                ->label('Jumlah Tanggungan')
                                ->integer()
                                ->minValue(0)
                                ->maxValue(4)
                                ->required()
                                ->rules(['integer', 'min:0', 'max:4']),
                            TextInput::make('bpjstk_id')
                                ->label('No BPJSTK')
                                ->unique(ignoreRecord: true)
                                ->placeholder('0001234567890')
                                ->required()
                                ->type('text')
                                ->maxLength(16)
                                ->reactive()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    // Ensure only numeric values remain
                                    $set('bpjstk_id', preg_replace('/\D/', '', $state));
                                })
                        ]),
                ])
                    ->columns(8)
                    ->key('karyawan_wizard')
                    ->nextAction(fn($get, $set) => Action::make('next')
                        ->label('Next ➝')
                        ->color('primary')
                        ->extraAttributes([
                            'class' => 'bg-blue-500 hover:bg-blue-700 text-white dark:bg-gray-700 dark:hover:bg-gray-600 transition',
                        ])
                    )
                    ->previousAction(fn($get, $set) => Action::make('previous')
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
