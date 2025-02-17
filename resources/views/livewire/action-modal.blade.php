<div class="p-6 text-center bg-slate-100/90 dark:bg-slate-800/90">
    <h2 class="text-lg font-bold text-slate-800 dark:text-slate-100 ">
        {{ $confirmationMessage }}
    </h2>
    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
        This action cannot be undone.
    </p>

    <div class="mt-4 flex justify-center space-x-4">
        <x-danger-button
            wire:click="execute"
            class="px-4 py-2 bg-red-600 text-slate100 rounded hover:bg-red-700">
            {{ $confirmButtonLabel }}
        </x-danger-button>
        <x-secondary-button
            wire:click="$dispatch('closeModal')"
            class="px-4 py-2 bg-slate-300 text-slate-700 rounded hover:bg-slate-400">
            Cancel
        </x-secondary-button>
    </div>
</div>
