<?php

namespace App\Livewire;

use App\Enums\Roles;
use App\Models\Payroll;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class PayrollTable extends PowerGridComponent
{
    public string $tableName = 'payroll-table';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::exportable('data-payroll')
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
        $user = auth()->user();
        if ($user->hasRole(Roles::SuperAdmin->value)) {
            return Payroll::query()->with('karyawan:id,nama');
        } else {
            return Payroll::query()->with('karyawan')->whereHas('karyawan', function ($query) use ($user) {
                $query->where('branch_id', $user->branch_id);
            });
        }
    }

    public function relationSearch(): array
    {
        return [
            'karyawan' => [
                'name', 'npp', 'sap_id'
            ]
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('bln_thn')
            ->add('karyawan_id', fn(Payroll $model) => $model->karyawan?->name ?? '')
            ->add('1050_honorarium')
            ->add('uang_saku_mb')
            ->add('3000_lembur')
            ->add('2580_tunj_lain')
            ->add('ujp')
            ->add('4020_sumbangan_cuti_tahunan')
            ->add('6500_pot_wajib_koperasi')
            ->add('6540_pot_pinjaman_koperasi')
            ->add('6590_pot_ykkkf')
            ->add('6620_pot_keterlambatan')
            ->add('6630_pinjaman_karyawan')
            ->add('6700_pot_bank_mandiri')
            ->add('6701_pot_bank_bri')
            ->add('6702_pot_bank_btn')
            ->add('6703_pot_bank_danamon')
            ->add('6704_pot_bank_dki')
            ->add('6705_pot_bank_bjb')
            ->add('6750_pot_adm_bank_mandiri')
            ->add('6751_pot_adm_bank_bri')
            ->add('6752_pot_adm_bank_bjb')
            ->add('6900_pot_lain')
            ->add('created_at_formatted', fn(Payroll $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->add('action', function (Payroll $model) {
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
            Column::make('Bulan Tahun','bln_thn'),
            Column::make('Nama Karyawan','karyawan_id'),
            Column::make('Honorarium','1050_honorarium'),
            Column::make('Uang Saku MB','uang_saku_mb'),
            Column::make('Lembur','3000_lembur'),
            Column::make('Tunj. Lain','2580_tunj_lain'),
            Column::make('UJP','ujp'),
            Column::make('Sumb. Cuti Tahunan','4020_sumbangan_cuti_tahunan')
                ->hidden()
                ->visibleInExport(true),
            Column::make('Pot. Wajib Koperasi','6500_pot_wajib_koperasi')
                ->hidden()
                ->visibleInExport(true),
            Column::make('Pot. Pin  j. Koperasi','6540_pot_pinjaman_koperasi'),
            Column::make('Pot. YKKKF','6590_pot_ykkkf'),
            Column::make('Pot. Keterlambatan','6620_pot_keterlambatan'),
            Column::make('Pinj. Karyawan','6630_pinjaman_karyawan'),
            Column::make('Pot. Bank Mandiri','6700_pot_bank_mandiri'),
            Column::make('Pot. Bank BRI','6701_pot_bank_bri'),
            Column::make('Pot. Bank BTN','6702_pot_bank_btn'),
            Column::make('Pot. Bank Danamon','6703_pot_bank_danamon'),
            Column::make('Pot. Bank DKI','6704_pot_bank_dki'),
            Column::make('Pot. Bank BJB','6705_pot_bank_bjb'),
            Column::make('Adm. Bank Mandiri','6750_pot_adm_bank_mandiri'),
            Column::make('Adm. Bank BRI','6751_pot_adm_bank_bri'),
            Column::make('Adm. Bank BJB','6752_pot_adm_bank_bjb'),
            Column::make('Pot. Lain','6900_pot_lain'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
//
        ];
    }

    public function getActions(): array
    {
        return [
            'main' => [
                'edit' => ['type' => 'modal', 'label' => 'Edit', 'component' => 'payrolls.create', 'function' => 'edit'],
            ],
            'danger' => [
                'deleteRow' => ['type' => 'action', 'component' => 'action-modal', 'model' => 'Karyawan', 'action' => 'delete', 'label' => 'Delete Payroll', 'class' => 'text-red-700 hover:bg-red-100 hover:text-red-900', 'function' => 'delete'],
            ],
        ];
    }

    protected $listeners = [
        //refresh table from events
        'record-deleted' => '$refresh',
        'record-updated' => '$refresh',
    ];
}
