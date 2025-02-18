<?php

namespace App\Livewire\Users;

use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Permission;

class UpdatePermissions extends ModalComponent implements HasForms
{
    use InteractsWithForms;
    public ?User $user = null;
    public ?array $data = [];

    public $permissions = [];

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function mount(?int $id): void
    {
        $this->user = $id ? User::with(['unitBisnis', 'permissions'])->find($id) : null;

        if (!$this->user && $id) {
            abort(404, 'User not found');
        }

        $this->data = $this->getUserData();
        $this->form->fill($this->data);

        $this->permissions = Permission::all();
    }

    private function getUserData(): array
    {
        return [
            'name' => $this->user->name,
            'branch_id' => $this->user->unitBisnis->name ?? null,
            'permissions' => $this->user->getAllPermissions()->pluck('name')->toArray() ?? null,
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->disabled()
                    ->label('Name'),
                TextInput::make('branch_id')
                    ->disabled()
                    ->label('Unit Bisnis'),
                CheckboxList::make('permissions')
                    ->options(Permission::all()->pluck('name', 'name'))
                    ->label('Role')
                    ->default($this->user->permissions->pluck('name')),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $validated =  $this->validate([
            'data.permissions' => ['required'],
        ]);

        $this->user->syncPermissions($validated['data']['permissions']);

        ($validated['data']['permissions'])
            ? session()->flash('message','Role berhasil diberikan!')
            : session()->flash('danger', 'Role gagal diberikan!');
        $this->closeModal();
        // refresh Users Page after saving
        $this->dispatch('refreshUsersTable');
    }

    public function render()
    {
        return view('livewire.users.update-permissions');
    }
}
