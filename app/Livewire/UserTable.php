<?php

namespace App\Livewire;

use App\Enums\Permissions;
use App\Models\UnitBisnis;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use Livewire\Attributes\On;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\Facades\Rule;
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
            PowerGrid::exportable('users')
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
        return User::query()->with(['unitBisnis', 'roles', 'permissions']);
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
        $options = $this->branchSelectOptions();

        return PowerGrid::fields()
            ->add('id')
            ->add('#', fn($row, $index) => $index + 1)
            ->add('name')
            ->add('username')
            ->add('email')
            ->add('branch_id', fn($user) => intval($user->branch_id))
            ->add('roles', fn($user) => $user->getRoleNames()->first())
            ->add('permissions', fn($user) => $user->permissions
                ? ($user->getAllPermissions()->count() > 2
                ? $user->getAllPermissions()->first()->name . ' & ' . ($user->getAllPermissions()->count() - 1) . ' others'
                : $user->getAllPermissions()->implode('name', ' & '))
                : null)
            ->add('is_active')
            ->add('created_at_formatted', fn(User $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->add('unit_bisnis', fn($user) => e($user->unitBisnis->name ?? null))
            ->add('branch_name', function ($user) use ($options) {
                return Blade::render('<x-select type="occurrence" :options=$options :modelId=$userId :selected=$selected/>', ['options' => $options, 'userId' => intval($user->id), 'selected' => intval($user->branch_id)]);
            })
            ->add('action', function (User $model) {
                return view('livewire.action-dropdown', [
                    'model' => $model,
                    'actions' => $this->getActions(),
                ])->render();
            });
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->visibleInExport(false),
            Column::make('No', '#')->hidden()->visibleInExport(true),
            Column::make('Name', 'name')
                ->editOnClick(hasPermission: Permissions::ManageUsers->value)
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),

            Column::make('Username', 'username')
                ->editOnClick(hasPermission: Permissions::ManageUsers->value)
                ->sortable()
                ->searchable(),

            Column::make('Unit Bisnis', 'branch_name')->visibleInExport(false),

            Column::make('Branch', 'unit_bisnis')->hidden()->visibleInExport(true),

            Column::make('Roles', 'roles'),

            Column::make('Permissions', 'permissions'),

            Column::add()
                ->title('Active')
                ->field('is_active')
                ->toggleable(hasPermission: Permissions::ManageUsers->value, trueLabel: 'active', falseLabel: 'blocked')
                ->sortable(),

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
            Filter::datetimepicker('created_at'),
        ];
    }


    public function actionRules($row): array
    {
        return [
            Rule::checkbox()
                ->when(fn ($row) => $row->isSuperAdmin())
                ->hide(),

            Rule::rows()
                ->when(fn ($row) => $row->isSuperAdmin())
                ->hideToggleable(),
        ];
    }

    public function getActions(): array
    {
        return [
            'main' => [
                'edit' => ['type' => 'modal', 'label' => 'Edit', 'component' => 'users.create'],
                'updateRole' => ['type' => 'modal', 'label' => 'Update Role', 'component' => 'users.update-role'],
                'updatePermissions' => ['type' => 'modal', 'label' => 'Update Permissions', 'component' => 'users.update-permissions'],
            ],
            'danger' => [
                'deleteRow' => ['type' => 'action', 'component' => 'action-modal', 'model' => 'User', 'action' => 'delete', 'label' => 'Delete User', 'class' => 'text-red-700 hover:bg-red-100 hover:text-red-900'],
            ],
        ];
    }

    protected $listeners = [
        'refreshUsersTable' => '$refresh', //refresh table from event
        'record-deleted' => '$refresh',
        'record-updated' => '$refresh',
    ];

    #[On('bulkDelete.{tableName}')]
    public function bulkDelete(): void
    {
        $this->dispatch('openModal', 'bulk-delete-modal',
             [
                'checkboxValues' => $this->checkboxValues,
                'model' => 'User',
                'tableName' => $this->tableName,
            ]
        );
    }

    public function onUpdatedToggleable($id, $field, $value): void
    {
        User::query()->where('id', $id)->update([
            $field => $value,
        ]);
    }

    public function branchSelectOptions(): Collection
    {
        return UnitBisnis::all(['id', 'name'])
            ->mapWithKeys(function ($item) {
                return [
                    $item->id => $item->name,
                ];
            });
    }

    #[On('categoryChanged')]
    public function categoryChanged($branchId, $userId): void
    {
        User::query()->where('id', $userId)->update(['branch_id' => $branchId]);
    }

    public function rules(): array
    {
        return [
            'name.*' => ['required', 'string', 'min:3', 'max:130'],
            'username.*' => ['required', 'string', 'min:5', 'max:130', 'unique:users'],
            'email.*' => ['required', 'string','email', 'min:8', 'max:130', 'unique:users'],
        ];
    }

    public function onUpdatedEditable(string|int $id, string $field, string $value): void
    {
        User::query()->find($id)->update([
            $field => e($value),
        ]);
    }
}
