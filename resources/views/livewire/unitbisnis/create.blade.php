<x-card class="flex-auto">
    <div class="flex flex-wrap items-center justify-between pb-3 mt-5 border-b lg:mt-0 sm:mt-8 border-zinc-200 dark:border-zinc-800 sm:flex-no-wrap">
        <div class="relative p-2">
            <div class="space-y-0.5">
                <h2 class="text-xl font-semibold tracking-tight dark:text-zinc-100">Update BM</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $unitbisnis->name }}</p>
            </div>
        </div>
    </div>
    <div class="flex justify-center">
        <form wire:submit="save" class="w-full max-w-lg">
            {{ $this->form }}
            <div class="w-full pt-6 text-right">
                <x-button type="submit">Save</x-button>
            </div>
        </form>
    </div>
</x-card>
