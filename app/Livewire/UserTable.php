<?php

namespace App\Livewire;

use App\Models\UnitBisnis;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class UserTable extends PowerGridComponent
{
    use WithExport;
    public string $tableName = 'user-table';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::exportable('export')
                ->striped()
                ->columnWidth([
                    2 => 30,
                ])
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            PowerGrid::header()
                ->showToggleColumns()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return User::query()->with('unitBisnis');
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

    public function header(): array
    {
        return [
            Button::add('bulk-delete')
                ->slot('Bulk delete (<span x-text="window.pgBulkActions.count(\'' . $this->tableName . '\')"></span>)')
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('bulkDelete.' . $this->tableName, []),
        ];
    }


    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('username')
            ->add('email')
            ->add('branch_id', fn ($user) => intval($user->branch_id))
            ->add('is_active')
            ->add('created_at_formatted', fn(User $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->add('branch_name', function ($user) {
                $options = null;
                if (is_null($user->branch_id)) {
                    dd($user);
                }

                return Blade::render('< type="occurrence" :options=$options  :userId=$userId  :selected=$selected/>', ['options' => $options, 'userId' => intval($user->id), 'selected' => intval($user->branch_id)]);
            });
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id'),
            Column::make('Name', 'name')
                ->editOnClick(hasPermission: 'manage-users')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),

            Column::make('Username', 'username')
                ->sortable()
                ->searchable(),

            Column::make('Unit Bisnis', 'branch_name'),

            Column::add()
                ->title('Active')
                ->field('is_active')
                ->toggleable(hasPermission:'manage-users',trueLabel: 'active', falseLabel: 'blocked')
                ->sortable(),

            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datetimepicker('created_at'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId . ')');
    }

    public function actions(User $row): array
    {
        return [
            Button::add('edit')
                ->slot('edit')
                ->class('bg-blue-500 text-white font-bold py-2 px-2 rounded')
                ->dispatch('clickToEdit', ['userId' => $row->id, 'userName' => $row->name]),

            Button::add('delete')
                ->slot('delete')
                ->class('bg-red-500 text-white font-bold py-2 px-2 rounded')
                ->dispatch('clickToDelete', ['userId' => $row->id, 'userName' => $row->name]),
        ];
    }

    public function actionRules($row): array
    {
       return [

        ];
    }

    #[On('bulkDelete.{tableName}')]
    public function bulkDelete(): void
    {
        dd([
            'userIds'                 => $this->checkboxValues,
            'confirmationTitle'       => 'Delete user',
            'confirmationDescription' => 'Are you sure you want to delete this user?',
        ]);
    }

    public function editName(array $data): void
    {
        dd('You are editing', $data);
    }

    public function onUpdatedToggleable($id, $field, $value): void
    {
        User::query()->where('id', $id)->update([
            $field => $value,
        ]);
    }

    public function unitBisnisSelectOptions(): Collection
    {
        return UnitBisnis::all(['id', 'name'])
            ->mapWithKeys(function ($item) {
            return [
                $item->id => $item->name,
            ];
            });
    }

    #[On('unitBisnisChanged')]
    public function unitBisnisChanged($unitBisnisId, $userId): void
    {
        dd("category Id: {$unitBisnisId} for Dish id: {$userId}");
    }

}
