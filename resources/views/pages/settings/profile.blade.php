<?php

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Features;
use Livewire\Attributes\Computed;
use function Laravel\Folio\{middleware, name};
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Volt\Component;

middleware('auth');
name('settings.profile');

new class extends Component implements HasForms {
    use InteractsWithForms;
    use \Livewire\WithFileUploads;

    public ?array $data = [];
    public $avatar;
    public $avatarPreview;

    public function mount(): void
    {
        $this->form->fill();
        $this->avatarPreview = auth()->user()->profile_photo_url ?? null;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->rules('required|string')
                    ->default(auth()->user()->name),
                \Filament\Forms\Components\TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->rules('required|string')
                    ->default(auth()->user()->username),
                \Filament\Forms\Components\TextInput::make('email')
                    ->label('Email Address')
                    ->required()
                    ->rules('sometimes|required|email|unique:users,email,' . auth()->user()->id)
                    ->default(auth()->user()->email),
            ])
            ->statePath('data');
    }

    public function updatedAvatar(): void
    {
        $this->validate();

        $this->avatarPreview = $this->avatar->temporaryUrl();
    }

    public function save(): void
    {
        $state = $this->form->getState();
        $this->validate();

        if ($this->avatar != null) {
            $this->saveNewUserAvatar();
        }

        $this->saveFormFields($state);

        Notification::make()
            ->title('Successfully saved your profile settings')
            ->success()
            ->send();

        $this->dispatch('refresh-avatar');
    }

    private function saveNewUserAvatar(): void
    {
        $this->validate([
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $user = auth()->user();

        if ($this->avatar) {
            // Delete old avatar if exists
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Store new avatar
            $path = $this->avatar->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
            $user->save();
        }

        // This will update/refresh the avatar in the sidebar
//        $this->js('window.dispatchEvent(new CustomEvent("refresh-avatar"));');
        $this->dispatch('refresh-avatar');
    }

    private function saveFormFields($state): void
    {
        auth()->user()->name = $state['name'];
        auth()->user()->email = $state['email'];
        auth()->user()->save();
        $this->dispatch('refresh-avatar');
    }

    public function deleteAvatar(): void
    {
        $user = auth()->user();

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
            $user->forceFill([
                'profile_photo_path' => null,
            ])->save();
        }

        $this->dispatch('refresh-avatar');
    }

    public function getProfilePhotoUrlProperty()
    {
        return auth()->user()->profile_photo_url;
    }

    #[Computed]
    public function canManageProfilePhotos(): bool
    {
        return class_exists(\Laravel\Jetstream\Jetstream::class) &&
            method_exists(\Laravel\Jetstream\Jetstream::class, 'managesProfilePhotos') &&
            \Laravel\Jetstream\Jetstream::managesProfilePhotos();
    }

}
?>

<x-layouts.app>

    <x-app.settings-layout
        title="Settings"
        description="Manage your account avatar, name, email, and more.">

        @volt('settings.profile')
        <div class="relative w-full">
            <form wire:submit="save" class="w-fulll max-w-lg">
                <div class="relative flex flex-col mt-5 lg:px-10">
                    <div x-data="{ avatarPreview: @entangle('avatarPreview') }"
                         class="flex justify-center items-center">
                        <!-- Hidden File Input -->
                        <input type="file" id="avatar" class="hidden" wire:model.live="avatar" x-ref="avatar"
                               x-on:change="
                const reader = new FileReader();
                reader.onload = (e) => { avatarPreview = e.target.result; };
                reader.readAsDataURL($refs.avatar.files[0]);
           "/>

                        <!-- Avatar Frame -->
                        <div class="relative w-24 h-24">
                            <!-- Delete Avatar Button -->
                            @if ($this->canManageProfilePhotos && Auth::user()->profile_photo_path)
                                <button type="button" wire:click="deleteAvatar"
                                        class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                    ✕
                                </button>
                            @endif

                            <!-- Avatar Image (Click to Change) -->
                            <div class="rounded-full w-24 h-24 bg-cover bg-no-repeat bg-center cursor-pointer"
                                 x-bind:style="'background-image: url(\'' + (avatarPreview || '{{ $this->profilePhotoUrl }}') + '\');'"
                                 x-on:click.prevent="$refs.avatar.click()">
                            </div>
                        </div>

                        <x-input-error for="avatar" class="mt-2"/>
                    </div>
                    <div class="w-full mt-8">
                        {{ $this->form }}
                    </div>
                    <div class="w-full pt-6 text-right">
                        <x-button submit>Save</x-button>
                    </div>
                </div>

            </form>

            <div class="mt-10 w-full max-w-lg">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>
        </div>


        @endvolt
    </x-app.settings-layout>

</x-layouts.app>
