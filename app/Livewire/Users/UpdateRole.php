<?php

namespace App\Livewire\Users;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\View\View;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Role;

class UpdateRole extends ModalComponent implements HasForms
{
    use InteractsWithForms;
    public ?User $user = null;
    public ?array $data = [];

    public $roles = [];
    public $selectedRole='';

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

    public function mount(?int $id): void
    {
        $this->user = $id ? User::find($id) : null;

        if (!$this->user && $id) {
            abort(404, 'User not found');
        }

        $this->data = $this->getUserData();
        $this->form->fill($this->data);

        $this->roles = Role::all();
    }

    private function getUserData(): array
    {
        return [
            'name' => $this->user->name,
            'branch_id' => $this->user->branch->name ?? null,
            'role' => $this->user->getRoleNames()->first() ?? null,
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
                Select::make('role')
                    ->options(Role::all()->pluck('name', 'id'))
                    ->label('Role'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $validated =  $this->validate([
            'selectedRole' => ['sometimes'],
        ]);

        $this->user->syncRoles($this->selectedRole);

        ($validated['selectedRole'])
            ? session()->flash('message','Role berhasil diberikan!')
            : session()->error(title: 'Role gagal diberikan!', position: 'toast-top toast-end', timeout: 2000);
        $this->closeModal();
        // refresh Users Page after saving
        $this->dispatch('refreshUsersTable');
    }
    public function render(): View
    {
        return view('livewire.users.update-role');
    }
}
