<x-card class="flex-auto">
    <div
        class="flex flex-wrap items-center justify-between pb-3 mt-5 border-b lg:mt-0 sm:mt-8 border-zinc-200 dark:border-zinc-800 sm:flex-no-wrap">
        <div class="relative p-2">
            <div class="space-y-0.5">
                <h2 class="text-xl font-semibold tracking-tight dark:text-zinc-100">Update User</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $user->name }}</p>
            </div>
        </div>
    </div>
    <div class="flex justify-center">

        <form wire:submit="save">
            <div class="grid grid-cols-6 gap-4 sm:grid-cols-4">
                <!-- Details -->
                <div class="col-span-6 sm:col-span-4 flex flex-col items-center justify-center text-center">
                    <img class="size-32 rounded-full" src="{{ $user->profile_photo_url }}"
                         alt="{{ $user->username }}"/>
                </div>
                <div class="pt-6 w-full">
                    {{ $this->form }}
                </div>
            </div>

            <div class="mt-9 flex mb-3 justify-center font-semibold">
                <x-button class="ms-3" wire:loading.attr="disabled">
                    {{ __('Save') }}
                </x-button>
            </div>
        </form>

    </div>
</x-card>
