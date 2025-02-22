<?php

namespace App\Livewire;

use App\Models\Apotek;
use App\Models\Karyawan;
use App\Models\UnitBisnis;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class KaryawanTable extends PowerGridComponent
{
    use WithExport;

    public string $tableName = 'karyawans-table';

    public function boot(): void
    {
        config(['livewire-powergrid.filter' => 'outside']);
    }

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::exportable('master_apotek')
                ->columnWidth([
                    2 => 30,
                ])
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            PowerGrid::header()
                ->includeViewOnTop('components.pg-tops.karyawan')
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Karyawan::query()->with(['branch:id,name', 'apotek:id,name', 'area:id,name', 'band:id,name', 'bank:id,name', 'empLevel:id,name', 'empStatus:id,name', 'gradeEselon:id,grade,eselon', 'jabatan:id,name', 'subjabatan:id,name', 'statusDesc:id,name', 'recruitment:id,name', 'zip:id,code']);
    }

    public function relationSearch(): array
    {
        return [
            'branch' => [
                'name',
                'code'
            ],
            'apotek' => [
                'name',
                'code'
            ],
            'gradeEselon' => [
                'grade', 'eselon'
            ],
            'jabatan' => [
                'name',
            ],
            'subjabatan' => [
                'name',
            ]
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('branch_id', fn(Karyawan $model) => $model->branch?->name ?? '')
            ->add('apotek_id', fn(Karyawan $model) => $model->apotek?->name ?? '')
            ->add('sap_id')
            ->add('npp')
            ->add('nik')
            ->add('name')
            ->add('date_of_birth_formatted', fn(Karyawan $model) => Carbon::parse($model->date_of_birth)->format('d/m/Y'))
            ->add('sex')
            ->add('address')
            ->add('phone')
            ->add('religion')
            ->add('blood_type')
            ->add('zip_id', fn(Karyawan $model) => $model->zip?->code ?? '')
            ->add('employee_status_id', fn(Karyawan $model) => $model->empStatus?->name ?? '')
            ->add('jabatan_id', fn(Karyawan $model) => $model->jabatan?->name ?? '')
            ->add('subjabatan_id', fn(Karyawan $model) => $model->subjabatan?->name ?? '')
            ->add('band_id', fn(Karyawan $model) => $model->band?->name ?? '')
            ->add('grade_eselon_id', fn(Karyawan $model) => $model->gradeEselon?->name ?? '')
            ->add('area_id', fn(Karyawan $model) => $model->area?->name ?? '')
            ->add('employee_level_id', fn(Karyawan $model) => $model->empLevel?->name ?? '')
            ->add('saptitle_id')
            ->add('saptitle_name')
            ->add('date_hired_formatted', fn(Karyawan $model) => Carbon::parse($model->date_hired)->format('d/m/Y'))
            ->add('date_promoted_formatted', fn(Karyawan $model) => Carbon::parse($model->date_promoted)->format('d/m/Y'))
            ->add('date_last_mutated_formatted', fn(Karyawan $model) => Carbon::parse($model->date_last_mutated)->format('d/m/Y'))
            ->add('status_desc_id', fn(Karyawan $model) => $model->statusDesc?->name ?? '')
            ->add('bpjs_id')
            ->add('bpjstk_id')
            ->add('insured_member_count')
            ->add('bpjs_class')
            ->add('contract_document_id')
            ->add('contract_sequence_no')
            ->add('contract_term')
            ->add('contract_start_formatted', fn(Karyawan $model) => Carbon::parse($model->contract_start)->format('d/m/Y'))
            ->add('contract_end_formatted', fn(Karyawan $model) => Carbon::parse($model->contract_end)->format('d/m/Y'))
            ->add('npwp')
            ->add('status_pasangan')
            ->add('jumlah_tanggungan')
            ->add('pasangan_ditanggung_pajak')
            ->add('account_no')
            ->add('account_name')
            ->add('bank_id', fn(Karyawan $model) => $model->bank?->name ?? '')
            ->add('recruitment_id', fn(Karyawan $model) => $model->recruitment?->name ?? '')
            ->add('pants_size')
            ->add('shirt_size')
            ->add('created_at_formatted', fn(Karyawan $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->add('action', function (Karyawan $model) {
                return view('livewire.action-dropdown', [
                    'model' => $model,
                    'actions' => $this->getActions(),
                ])->render();
            });
    }

    public function columns(): array
    {
        return [
            Column::make('Actions', 'action')
                ->visibleInExport(false)
                ->contentClasses('text-center'),

            Column::make('Unit Bisnis', 'branch_id'),
            Column::make('Apotek', 'apotek_id'),
            Column::make('ID SAP', 'sap_id')
                ->sortable()
                ->searchable(),

            Column::make('NPP', 'npp')
                ->sortable()
                ->searchable(),

            Column::make('NIK', 'nik')
                ->hidden()
                ->visibleInExport(true)
                ->sortable()
                ->searchable(),

            Column::make('Nama', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Date of birth', 'date_of_birth_formatted', 'date_of_birth')
                ->sortable(),

            Column::make('Gender', 'sex')
                ->sortable()
                ->searchable(),

            Column::make('Address', 'address')
                ->hidden()
                ->visibleInExport(true)
                ->sortable()
                ->searchable(),

            Column::make('Phone', 'phone')
                ->hidden()
                ->visibleInExport(true)
                ->sortable()
                ->searchable(),

            Column::make('Religion', 'religion')
                ->hidden()
                ->visibleInExport(true)
                ->sortable()
                ->searchable(),

            Column::make('Blood type', 'blood_type')
                ->hidden()
                ->visibleInExport(true)
                ->sortable()
                ->searchable(),

            Column::make('Kode Pos', 'zip_id')
                ->hidden()
                ->visibleInExport(true),
            Column::make('Status Pegawai', 'employee_status_id')
                ->hidden()
                ->visibleInExport(true),
            Column::make('Jabatan', 'jabatan_id'),
            Column::make('Subjabatan', 'subjabatan_id'),
            Column::make('Band', 'band_id')
                ->hidden()
                ->visibleInExport(true),
            Column::make('Grade Eselon', 'grade_eselon_id')
                ->hidden()
                ->visibleInExport(true),
            Column::make('Area', 'area_id')
                ->hidden()
                ->visibleInExport(true),
            Column::make('Level Pegawai', 'employee_level_id')
                ->hidden()
                ->visibleInExport(true),
            Column::make('ID Jab SAP', 'saptitle_id')
                ->hidden()
                ->visibleInExport(true)
                ->sortable()
                ->searchable(),

            Column::make('Nama Jab SAP', 'saptitle_name')
                ->sortable()
                ->searchable(),

            Column::make('Tanggal Diterima', 'date_hired_formatted', 'date_hired')
                ->hidden()
                ->visibleInExport(true)
                ->sortable(),

            Column::make('Tanggal Diangkat', 'date_promoted_formatted', 'date_promoted')
                ->hidden()
                ->visibleInExport(true)
                ->sortable(),

            Column::make('Tgl Mutasi Terakhir', 'date_last_mutated_formatted', 'date_last_mutated')
                ->sortable(),

            Column::make('Deskripsi Status', 'status_desc_id')
                ->hidden()
                ->visibleInExport(true),
            Column::make('ID BPJS', 'bpjs_id')
                ->sortable()
                ->searchable(),

            Column::make('ID BPJSTK', 'bpjstk_id')
                ->sortable()
                ->searchable(),

            Column::make('Jumlah Tanggungan', 'insured_member_count')
                ->hidden()
                ->visibleInExport(true),
            Column::make('Kelas BPJS', 'bpjs_class')
                ->hidden()
                ->visibleInExport(true),
            Column::make('No Kontrak', 'contract_document_id')
                ->hidden()
                ->visibleInExport(true)
                ->sortable()
                ->searchable(),

            Column::make('Kontrak ke-', 'contract_sequence_no')
                ->hidden()
                ->visibleInExport(true),
            Column::make('Masa Kontrak', 'contract_term')
                ->hidden()
                ->visibleInExport(true),
            Column::make('Awal Kontrak', 'contract_start_formatted', 'contract_start')
                ->hidden()
                ->visibleInExport(true)
                ->sortable(),

            Column::make('Berakhir Kontrak', 'contract_end_formatted', 'contract_end')
                ->sortable(),

            Column::make('NPWP', 'npwp')
                ->sortable()
                ->searchable(),

            Column::make('Status Pasangan', 'status_pasangan')
                ->sortable()
                ->searchable(),

            Column::make('Jumlah Tanggungan Pajak', 'jumlah_tanggungan'),
            Column::make('Pasangan Ditanggung Pajak', 'pasangan_ditanggung_pajak')
                ->hidden()
                ->visibleInExport(true)
                ->sortable()
                ->searchable(),

            Column::make('No Rekening', 'account_no')
                ->hidden()
                ->visibleInExport(true)
                ->sortable()
                ->searchable(),

            Column::make('Nama Rekening', 'account_name')
                ->hidden()
                ->visibleInExport(true)
                ->sortable()
                ->searchable(),

            Column::make('Bank', 'bank_id')
                ->hidden()
                ->visibleInExport(true),
            Column::make('Rekrutmen', 'recruitment_id')
                ->hidden()
                ->visibleInExport(true),
            Column::make('Ukuran Celana/Rok', 'pants_size')
                ->sortable()
                ->searchable(),

            Column::make('Ukuran Baju', 'shirt_size')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('branch_name', 'branch_id')
                ->dataSource(UnitBisnis::all())
                ->optionValue('id')
                ->optionLabel('name'),
            Filter::select('apotek_name', 'apotek_id')
                ->dataSource(Apotek::all())
                ->optionValue('id')
                ->optionLabel('name'),
            Filter::datepicker('date_hired'),
            Filter::datepicker('date_promoted'),
            Filter::datepicker('date_last_mutated'),
            Filter::datepicker('contract_start'),
            Filter::datepicker('contract_end'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    public function getActions(): array
    {
        return [
            'main' => [
                'edit' => ['type' => 'modal', 'label' => 'Edit', 'component' => 'karyawans.create', 'function' => 'edit'],
            ],
            'danger' => [
                'deleteRow' => ['type' => 'action', 'component' => 'action-modal', 'model' => 'Karyawan', 'action' => 'delete', 'label' => 'Delete Karyawan', 'class' => 'text-red-700 hover:bg-red-100 hover:text-red-900', 'function' => 'delete'],
            ],
        ];
    }

    protected $listeners = [
        //refresh table from events
        'record-deleted' => '$refresh',
        'record-updated' => '$refresh',
    ];
}
