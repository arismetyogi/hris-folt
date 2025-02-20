<?php

namespace App\Livewire;

use App\Models\Karyawan;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class KaryawanTable extends PowerGridComponent
{
    public string $tableName = 'karyawan-table-zuuajy-table';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Karyawan::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('branch_id')
            ->add('apotek_id')
            ->add('sap_id')
            ->add('npp')
            ->add('nik')
            ->add('name')
            ->add('date_of_birth_formatted', fn (Karyawan $model) => Carbon::parse($model->date_of_birth)->format('d/m/Y'))
            ->add('sex')
            ->add('address')
            ->add('phone')
            ->add('religion')
            ->add('blood_type')
            ->add('zip_id')
            ->add('employee_status_id')
            ->add('jabatan_id')
            ->add('subjabatan_id')
            ->add('band_id')
            ->add('grade_eselon_id')
            ->add('area_id')
            ->add('employee_level_id')
            ->add('saptitle_id')
            ->add('saptitle_name')
            ->add('date_hired_formatted', fn (Karyawan $model) => Carbon::parse($model->date_hired)->format('d/m/Y'))
            ->add('date_promoted_formatted', fn (Karyawan $model) => Carbon::parse($model->date_promoted)->format('d/m/Y'))
            ->add('date_last_mutated_formatted', fn (Karyawan $model) => Carbon::parse($model->date_last_mutated)->format('d/m/Y'))
            ->add('status_desc_id')
            ->add('bpjs_id')
            ->add('bpjstk_id')
            ->add('insured_member_count')
            ->add('bpjs_class')
            ->add('contract_document_id')
            ->add('contract_sequence_no')
            ->add('contract_term')
            ->add('contract_start_formatted', fn (Karyawan $model) => Carbon::parse($model->contract_start)->format('d/m/Y'))
            ->add('contract_end_formatted', fn (Karyawan $model) => Carbon::parse($model->contract_end)->format('d/m/Y'))
            ->add('npwp')
            ->add('status_pasangan')
            ->add('jumlah_tanggungan')
            ->add('pasangan_ditanggung_pajak')
            ->add('account_no')
            ->add('account_name')
            ->add('bank_id')
            ->add('recruitment_id')
            ->add('pants_size')
            ->add('shirt_size')
            ->add('created_at_formatted', fn (Karyawan $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Branch id', 'branch_id'),
            Column::make('Apotek id', 'apotek_id'),
            Column::make('Sap id', 'sap_id')
                ->sortable()
                ->searchable(),

            Column::make('Npp', 'npp')
                ->sortable()
                ->searchable(),

            Column::make('Nik', 'nik')
                ->sortable()
                ->searchable(),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Date of birth', 'date_of_birth_formatted', 'date_of_birth')
                ->sortable(),

            Column::make('Sex', 'sex')
                ->sortable()
                ->searchable(),

            Column::make('Address', 'address')
                ->sortable()
                ->searchable(),

            Column::make('Phone', 'phone')
                ->sortable()
                ->searchable(),

            Column::make('Religion', 'religion')
                ->sortable()
                ->searchable(),

            Column::make('Blood type', 'blood_type')
                ->sortable()
                ->searchable(),

            Column::make('Zip id', 'zip_id'),
            Column::make('Employee status id', 'employee_status_id'),
            Column::make('Jabatan id', 'jabatan_id'),
            Column::make('Subjabatan id', 'subjabatan_id'),
            Column::make('Band id', 'band_id'),
            Column::make('Grade eselon id', 'grade_eselon_id'),
            Column::make('Area id', 'area_id'),
            Column::make('Employee level id', 'employee_level_id'),
            Column::make('Saptitle id', 'saptitle_id')
                ->sortable()
                ->searchable(),

            Column::make('Saptitle name', 'saptitle_name')
                ->sortable()
                ->searchable(),

            Column::make('Date hired', 'date_hired_formatted', 'date_hired')
                ->sortable(),

            Column::make('Date promoted', 'date_promoted_formatted', 'date_promoted')
                ->sortable(),

            Column::make('Date last mutated', 'date_last_mutated_formatted', 'date_last_mutated')
                ->sortable(),

            Column::make('Status desc id', 'status_desc_id'),
            Column::make('Bpjs id', 'bpjs_id')
                ->sortable()
                ->searchable(),

            Column::make('Bpjstk id', 'bpjstk_id')
                ->sortable()
                ->searchable(),

            Column::make('Insured member count', 'insured_member_count'),
            Column::make('Bpjs class', 'bpjs_class'),
            Column::make('Contract document id', 'contract_document_id')
                ->sortable()
                ->searchable(),

            Column::make('Contract sequence no', 'contract_sequence_no'),
            Column::make('Contract term', 'contract_term'),
            Column::make('Contract start', 'contract_start_formatted', 'contract_start')
                ->sortable(),

            Column::make('Contract end', 'contract_end_formatted', 'contract_end')
                ->sortable(),

            Column::make('Npwp', 'npwp')
                ->sortable()
                ->searchable(),

            Column::make('Status pasangan', 'status_pasangan')
                ->sortable()
                ->searchable(),

            Column::make('Jumlah tanggungan', 'jumlah_tanggungan'),
            Column::make('Pasangan ditanggung pajak', 'pasangan_ditanggung_pajak')
                ->sortable()
                ->searchable(),

            Column::make('Account no', 'account_no')
                ->sortable()
                ->searchable(),

            Column::make('Account name', 'account_name')
                ->sortable()
                ->searchable(),

            Column::make('Bank id', 'bank_id'),
            Column::make('Recruitment id', 'recruitment_id'),
            Column::make('Pants size', 'pants_size')
                ->sortable()
                ->searchable(),

            Column::make('Shirt size', 'shirt_size')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
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
        $this->js('alert('.$rowId.')');
    }

    public function actions(Karyawan $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit: '.$row->id)
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id])
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
