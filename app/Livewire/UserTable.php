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
            ->add('test')
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
            Column::make('ID', 'id'),
            Column::make('Name', 'name')
                ->editOnClick(hasPermission: Permissions::ManageUsers->value)
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->editOnClick(hasPermission: Permissions::ManageUsers->value)
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
                ->contentClasses('text-center'),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datetimepicker('created_at'),
        ];
    }

    public function actions($row): array
    {
        return [
//            Button::add('edit')
//                ->icon('o-pencil', [
//                    'class' => '!text-white',
//                ])
//                ->class('bg-blue-500 text-white font-bold py-2 px-2 rounded')
//                ->dispatch('clickToEdit', ['userId' => $row->id, 'userName' => $row->name]),
//
//            Button::add('delete')
//                ->icon('o-trash', [
//                    'class' => 'text-white',
//                ])
//                ->class('bg-red-500 text-white font-bold py-2 px-2 rounded')
//                ->dispatch('clickToDelete', ['userId' => $row->id]),
        ];
    }

    public function actionRules($row): array
    {
        return [

        ];
    }

    public function getActions(): array
    {
        return [
            'main' => [
                'edit' => ['type' => 'link', 'label' => 'Edit', 'route' => 'users.index'],
                'updateRole' => ['type' => 'link', 'label' => 'Update Role', 'route' => 'users.index'],
                'updatePermissions' => ['type' => 'link', 'label' => 'Update Permissions', 'route' => 'users.index'],
            ],
            'toggle' => [
                'toggleActive' => ['label' => 'Toggle Active Status'],
            ],
            'danger' => [
                'delete' => ['label' => 'Delete User', 'class' => 'text-red-700 hover:bg-red-100 hover:text-red-900'],
            ],
        ];
    }

    protected $listeners = [
        'action::toggleActive' => 'toggleActive',
        'action::delete' => 'delete',
    ];

    #[On('bulkDelete.{tableName}')]
    public function bulkDelete(): void
    {
        dd([
            'userIds' => $this->checkboxValues,
            'confirmationTitle' => 'Delete user',
            'confirmationDescription' => 'Are you sure you want to delete this user?',
        ]);
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

    public function rules()
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

    #[On('clickToEdit')]
    public function clickToEdit(int $userId, string $userName): void
    {
        $this->js("alert('Editing #{$userId} -  {$userName}')");
    }

    #[On('clickToDelete')]
    public function clickToDelete(int $userId): void
    {
        User::whereKey($userId)->delete();
    }
}
