<?php

namespace App\Livewire\Karyawans;

use App\Models\Apotek;
use App\Models\Area;
use App\Models\Band;
use App\Models\Bank;
use App\Models\EmployeeLevel;
use App\Models\EmployeeStatus;
use App\Models\GradeEselon;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\StatusDesc;
use App\Models\Subjabatan;
use App\Models\UnitBisnis;
use App\Models\Zip;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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
    public static function modalMaxWidth(): string
    {
        return '6xl';
    }
    public static function closeModalOnEscape(): bool
    {
        return false;
    }
    public static function closeModalOnClickAway(): bool
    {
        return false;
    }
    public static function closeModalOnEscapeIsForceful(): bool
    {
        return false;
    }
    public function mount(?int $id = null): void
    {
        $this->karyawan = $id ? Karyawan::with(['branch', 'apotek', 'area', 'band', 'bank', 'empLevel', 'empStatus', 'gradeEselon', 'jabatan', 'subjabatan', 'recruitment', 'zip', 'statusDesc'])->find($id) : null;

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
            'apotek_id' => $this->karyawan?->apotek_id ?? null,
            'sap_id' => $this->karyawan?->sap_id ?? null,
            'npp' => $this->karyawan?->npp ?? null,
            'name' => $this->karyawan?->name ?? null,
            'nik' => $this->karyawan?->nik ?? null,
            'date_of_birth' => $this->karyawan?->date_of_birth ?? null,
            'sex' => $this->karyawan?->sex ?? null,
            'address' => $this->karyawan?->address ?? null,
            'phone' => $this->karyawan?->phone ?? null,
            'religion' => $this->karyawan?->religion ?? null,
            'blood_type' => $this->karyawan?->blood_type ?? null,
            'zip_id' => $this->karyawan?->zip_id ?? null,
            'employee_status_id' => $this->karyawan?->employee_status_id ?? null,
            'jabatan_id' => $this->karyawan?->jabatan_id ?? null,
            'subjabatan_id' => $this->karyawan?->subjabatan_id ?? null,
            'band_id' => $this->karyawan?->band_id ?? null,
            'grade_eselon_id' => $this->karyawan?->grade_eselon_id ?? null,
            'area_id' => $this->karyawan?->area_id ?? null,
            'employee_level_id' => $this->karyawan?->employee_level_id ?? null,
            'saptitle_id' => $this->karyawan?->saptitle_id ?? null,
            'saptitle_name' => $this->karyawan?->saptitle_name ?? null,
            'date_hired' => $this->karyawan?->date_hired ?? null,
            'date_promoted' => $this->karyawan?->date_promoted ?? null,
            'date_last_mutated' => $this->karyawan?->date_last_mutated ?? null,
            'status_desc_id' => $this->karyawan?->status_desc_id ?? null,
            'bpjs_id' => $this->karyawan?->bpjs_id ?? null,
            'bpjstk_id' => $this->karyawan?->bpjstk_id ?? null,
            'insured_member_count' => $this->karyawan?->insured_member_count ?? null,
            'bpjs_class' => $this->karyawan?->bpjs_class ?? null,
            'contract_document_id' => $this->karyawan?->contract_document_id ?? null,
            'contract_sequence_no' => $this->karyawan?->contract_sequence_no ?? null,
            'contract_term' => $this->karyawan?->contract_term ?? null,
            'contract_start' => $this->karyawan?->contract_start ?? null,
            'contract_end' => $this->karyawan?->contract_end ?? null,
            'npwp' => $this->karyawan?->npwp ?? null,
            'status_pasangan' => $this->karyawan?->status_pasangan ?? null,
            'jumlah_tanggungan' => $this->karyawan?->jumlah_tanggungan ?? null,
            'pasangan_ditanggung_pajak' => $this->karyawan?->pasangan_ditanggung_pajak ?? null,
            'account_no' => $this->karyawan?->account_no ?? null,
            'account_name' => $this->karyawan?->account_name ?? null,
            'bank_id' => $this->karyawan?->bank_id ?? null,
            'recruitment_id' => $this->karyawan?->recruitment_id ?? null,
            'pants_size' => $this->karyawan?->pants_size ?? null,
            'shirt_size' => $this->karyawan?->shirt_size ?? null,
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
                                ->unique(ignoreRecord: true)
                                ->maxlength(16)
                                ->placeholder('19001030102200001')
                                ->rules('string|max:16|min:16')
                                ->reactive()
                                ->required()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    // Ensure only numeric values remain
                                    $set('nik', preg_replace('/\D/', '', $state));
                                }),
                            DatePicker::make('date_of_birth')
                                ->label('Tanggal Lahir')
                                ->required(),
                            TextInput::make('phone')
                                ->label('Nomor Telepon')
                                ->tel()
                                ->reactive()
                                ->prefix('+62')
                                ->placeholder('81234567890')
                                ->required(),
                            Select::make('sex')
                                ->label('Jenis Kelamin')
                                ->options(['L' => 'Laki-laki', 'P' => 'Perempuan'])
                                ->required()
                                ->live(onBlur: true)
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
                                ->placeholder('Pilih Kode Pos')
                                ->getSearchResultsUsing(function (string $search) {
                                    return Zip::query()
                                        ->where('code', 'like', "%{$search}%")
                                        ->orWhere('urban', 'like', "%{$search}%")
                                        ->orWhere('subdistrict', 'like', "%{$search}%")
                                        ->orWhere('city', 'like', "%{$search}%")
                                        ->limit(10) // Limit the number of results to avoid performance issues
                                        ->get()
                                        ->mapWithKeys(function ($zip) {
                                            return [
                                                $zip->id => "{$zip->code} - {$zip->urban}, {$zip->subdistrict}"
                                            ];
                                        });
                                })
                                ->live(onBlur: true)
                                ->reactive()
                                ->searchable(['code', 'city', 'subdistrict'])
                                ->nullable(),
                        ]),

                    Step::make('Professional Info')
                        ->columns(2)
                        ->schema([
                            Select::make('branch_id')
                                ->disabled(
                                    fn($livewire) => !auth()->user()->isSuperAdmin())
                                ->default(auth()->user()->branch_id)
                                ->formatStateUsing(fn($state) => $state ?? auth()->user()->branch_id)
                                ->options(UnitBisnis::all()->pluck('name', 'id'))
                                ->getSearchResultsUsing(function (string $search) {
                                    return UnitBisnis::query()
                                        ->whereAny(['name', 'code'], 'like', "%{$search}%")
                                        ->limit(10)
                                        ->get()
                                        ->mapWithKeys(fn($branch) => [
                                            $branch->id => "{$branch->code} - {$branch->name}",
                                        ]);
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
                                ->getSearchResultsUsing(function (string $search) {
                                    return Apotek::query()
                                        ->whereAny(['name','sap_id'], 'like', "%{$search}%")
                                        ->limit(10)
                                        ->get()
                                        ->mapWithKeys(fn($apotek) => [
                                            $apotek->id => "{$apotek->sap_id} - {$apotek->name}",
                                        ]);
                                })
                                ->live()
                                ->preload()
                                ->searchable()
                                ->label('Apotek')
                                ->placeholder('Pilih Apotek')
                                ->required(),
                            TextInput::make('sap_id')
                                ->label('ID SAP')
                                ->validationAttribute('ID SAP')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->type('text')
                                ->maxLength(13)
                                ->reactive()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    $set('sap_id', preg_replace('/\D/', '', $state));
                                })
                                ->rules(['required', 'regex:/^(\d{8}|\d{13})$/']),
                            TextInput::make('npp')
                                ->label('NPP')
                                ->validationAttribute('NPP')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->type('text')
                                ->maxLength(10)
                                ->placeholder('19990101A')
                                ->reactive()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    // Ensure the input only contains the expected format, removing invalid characters
                                    if (preg_match('/^\d{8}[A-Z]{1,2}$/', $state, $matches)) {
                                        $set('npp', $matches[0]); // Set the matched value back
                                    }
                                })
                                ->rules(['regex:/^\d{8}[A-Z]{1,2}$/']),
                            Select::make('employee_status_id')
                                ->options(EmployeeStatus::all()->pluck('name', 'id'))
                                ->label('Employee Status')
                                ->required(),
                            Select::make('jabatan_id')
                                ->options(Jabatan::all()->pluck('name', 'id'))
//                                ->relationship('jabatan', 'name')
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
                            Select::make('grade_eselon_id')
                                ->label('Grade Eselon')
                                ->options(GradeEselon::all()->pluck('grade', 'id'))
                                ->getSearchResultsUsing(function (string $search) {
                                    return GradeEselon::query()
                                        ->where('grade', 'like', "%{$search}%")
                                        ->orWhere('eselon', 'like', "%{$search}%")
                                        ->get()
                                        ->mapWithKeys(fn(GradeEselon $record) => [$record->id => "{$record->grade} - {$record->eselon}"]);
                                })
                                ->required(),
                            Select::make('area_id')
                                ->options(Area::all()->pluck('name', 'id'))
                                ->label('Area')
                                ->required(),
                            Select::make('employee_level_id')
                                ->options(EmployeeLevel::all()->pluck('name', 'id'))
                                ->label('Level Pegawai')
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
                            Select::make('status_desc_id')
                                ->options(StatusDesc::all()->pluck('name', 'id'))
                                ->label('Deskripsi Status')
                                ->required(),
                        ]),

                    Step::make('Contract Details')
                        ->columns(2)
                        ->schema([
                            TextInput::make('contract_document_id')
                                ->label('No Kontrak'),
                            TextInput::make('contract_sequence_no')
                                ->label('Kontrak Ke-')
                                ->minValue(1)
                                ->maxValue(3)
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
                                ->unique(ignoreRecord: true)
                                ->required()
                                ->type('text')
                                ->reactive()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    // Ensure only numeric values remain
                                    $set('account_no', preg_replace('/\D/', '', $state));
                                }),
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

                    Step::make('Tax Details')
                        ->columns(2)
                        ->schema([
                            TextInput::make('npwp')
                                ->label('NPWP')
                                ->validationAttribute('NPWP')
                                ->type('text')
                                ->maxLength(16)
                                ->unique(ignoreRecord: true)
                                ->reactive()
                                ->required()
                                ->afterStateUpdated(function (callable $set, $state) {
                                    // Ensure only numeric values remain
                                    $set('npwp', preg_replace('/\D/', '', $state));
                                }),
                            Select::make('status_pasangan')
                                ->label('Status Pasangan')
                                ->options(['TK' => 'TK', 'K0' => 'K0', 'K1' => 'K1', 'K2' => 'K2', 'K3' => 'K3'])
                                ->required(),
                            TextInput::make('jumlah_tanggungan')
                                ->numeric()
                                ->maxValue(3)
                                ->label('Jumlah Tanggungan')
                                ->required(),
                            Toggle::make('pasangan_ditanggung_pajak')
                                ->label('Pasangan Ditanggung Pajak')
                                ->required(),
                            Section::make('Informasi Seragam')
                                ->schema([
                                    Select::make('pants_size')
                                        ->label('Pants Size')
                                        ->options(function (callable $get) {
                                            $sex = $get('sex');

                                            $options = [];
                                            // Return different options based on the selected sex
                                            if ($sex === 'L') {
                                                // Generate options for male (e.g., 28 - 40 inches)
                                                for ($i = 28; $i <= 45; $i += 1) {
                                                    $options[$i] = "{$i} Inch";
                                                }
                                            } elseif ($sex === 'P') {
                                                // Generate options for female (e.g., UK sizes 6 - 18)
                                                for ($i = 6; $i <= 20; $i += 1) {
                                                    $options[$i] = "UK {$i}";
                                                }
                                            }

                                            return $options;
                                        })
                                        ->reactive()
                                        ->required(),
                                    Select::make('shirt_size')
                                        ->label('Shirt Size')
                                        ->options(['XS' => 'XS', 'S' => 'S', 'M' => 'M', 'L' => 'L', 'XL' => 'XL', 'XXL' => 'XXL', '3XL' => '3XL', '4XL' => '4XL', '5XL' => '5XL', '6XL+' => '6XL+'])
                                        ->required(),
                                ])
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
        $this->dispatch('record-updated');
    }

    public function render(): View
    {
        return view('livewire.karyawans.create');
    }
}
