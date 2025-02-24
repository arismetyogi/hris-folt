<x-card class="flex-auto">
    <div
        class="flex items-center justify-between pb-3 mt-5 border-b lg:mt-0 sm:mt-8 border-zinc-200 dark:border-zinc-800">
        <div class="p-2">
            <div class="space-y-0.5">
                <h2 class="text-xl font-semibold tracking-tight dark:text-zinc-100">{{ $this->karyawan ? 'Update Karyawan' : 'Tambah Karyawan' }}</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $karyawan->name ?? null }}</p>
            </div>
        </div>
    </div>
    <div class="flex justify-center gap-2">
        <form wire:submit="save" class="w-full">
            {{ $this->form }}
            <div class="w-full pt-6 text-right">
                <x-secondary-button wire:click="$dispatch('closeModal')">Cancel</x-secondary-button>
                <x-button type="submit">Save</x-button>
            </div>
        </form>
    </div>
</x-card>
