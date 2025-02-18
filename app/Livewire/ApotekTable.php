<?php

namespace App\Livewire;

use App\Models\Apotek;
use App\Models\Province;
use App\Models\UnitBisnis;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;

final class ApotekTable extends PowerGridComponent
{
    public string $tableName = 'apotek-table';

    public bool $showFilters = true;

    public function boot(): void
    {
        config(['livewire-powergrid.filter' => 'outside']);
    }
    public function setUp(): array
    {
        return [
            PowerGrid::exportable('master_apotek')
                ->columnWidth([
                    2 => 30,
                ])
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            PowerGrid::header()
                ->withoutLoading()
                ->showToggleColumns()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Apotek::query()->with(['unitBisnis', 'zip', 'karyawans', 'province']);
    }

    public function relationSearch(): array
    {
        return [
            'unitBisnis' => [
                'name',
                'code'
            ]
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('#', function ($row, $index) {
                $currentPage = $this->page ?? 1; // Get the current page, default to 1
                $perPage = data_get($this->filters, 'perPage', 10);; // Set your per-page value (adjust if needed)

                return ($currentPage - 1) * $perPage + ($index + 1);
            })
            ->add('sap_id')
            ->add('name')
            ->add('province_name')
            ->add('branch_id', fn($apotek) => intval($apotek->branch_id))
            ->add('branch_name', fn($apotek) => e($apotek->unitBisnis->name ?? null))
            ->add('store_type')
            ->add('operational_date', fn(Apotek $model) => Carbon::createFromDate($model->operational_date)->format('d/m/Y'))
            ->add('address', function ($apotek) {
                $href = ($apotek->latitude && $apotek->longitude)
                    ? 'https://www.google.com/maps?q=' . $apotek->latitude . ',' . $apotek->longitude
                    : '#';
                $target = ($href !== '#') ? ' target="_blank"' : '';
                $address = ($apotek->address != "-") ? $apotek->address : ($apotek->latitude . ',' . $apotek->longitude);

                return '<a class="flex items-center gap-2" href="' . $href . '"' . $target . ' rel="noopener noreferrer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    <p class="text-xs break-words whitespace-normal max-w-48">' . htmlspecialchars($address) . '</p>
                </a>';
            })
            ->add('latitude')
            ->add('longitude')
            ->add('phone')
            ->add('zip', fn($apotek) => e($apotek->zip->code ?? null))
            ->add('created_at_formatted', fn(Apotek $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),
            Column::make('Branch', 'branch_name', 'branch_id')
                ->sortable()
                ->searchable(),
            Column::make('Store Type', 'store_type'),
            Column::make('Operational Date', 'operational_date')
                ->sortable(),
            Column::make('Address', 'address'),
            Column::make('Phone', 'phone'),
            Column::make('Zip Code  ', 'zip'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('branch_name', 'branch_id')
                ->dataSource(UnitBisnis::all())
                ->optionValue('id')
                ->optionLabel('name'),
            Filter::select('province_name', 'province_name')
                ->dataSource(Province::all())
                ->optionValue('id')
                ->optionLabel('name'),
            Filter::datepicker('operational_date'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    public function actions(Apotek $row): array
    {
        return [
            Button::add('edit')
                ->slot('Edit: ' . $row->id)
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
