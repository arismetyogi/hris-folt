<?php

namespace App\Livewire;

use App\Models\UnitBisnis;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class UnitBisnisTable extends PowerGridComponent
{
    use WithExport;

    public string $tableName = 'unit-bisnis-table';

    public function setUp(): array
    {
        return [
            PowerGrid::exportable('master_bm')
                ->columnWidth([
                    2 => 30,
                ])
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return UnitBisnis::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('code')
            ->add('name')
            ->add('address')
            ->add('flag')
            ->add('email')
            ->add('entity_code')
            ->add('entity_name')
            ->add('created_at_formatted', fn (UnitBisnis $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->add('action', function (UnitBisnis $model) {
                return view('livewire.action-dropdown', [
                    'model' => $model,
                    'actions' => $this->getActions(),
                ])->render();
            });
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),
            Column::make('Code', 'code'),
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Address', 'address')
                ->sortable()
                ->searchable(),

            Column::make('Flag', 'flag')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),

            Column::make('Entity code', 'entity_code'),
            Column::make('Entity name', 'entity_name')
                ->sortable()
                ->searchable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Actions', 'action')
                ->visibleInExport(false)
                ->contentClasses('text-center'),
        ];
    }

    public function filters(): array
    {
        return [
            //
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    public function getActions(): array
    {
        return [
            'main' => [
                'edit' => ['type' => 'modal', 'label' => 'Edit', 'component' => 'unitbisnis.create', 'function' => 'edit'],
            ],
            'danger' => [
                'deleteRow' => ['type' => 'action', 'component' => 'action-modal', 'model' => 'UnitBisnis', 'action' => 'delete', 'label' => 'Delete BM', 'class' => 'text-red-700 hover:bg-red-100 hover:text-red-900', 'function' => 'delete'],
            ],
        ];
    }

    protected $listeners = [
        'refreshUnitBisnisTable' => '$refresh', //refresh table from event
        'record-deleted' => '$refresh',
        'record-updated' => '$refresh',
    ];
}
