<div class="p-6 text-center bg-slate-100/90 dark:bg-slate-800/90">
    <h2 class="text-lg font-bold text-slate-800 dark:text-slate-100 ">
        {{ __('Are you sure you want to delete the selected records?') }}
    </h2>
    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
        This action cannot be undone.
    </p>
    <div class="mt-4 flex justify-center space-x-4">
        <x-secondary-button wire:click="$dispatch('closeModal')" class="btn btn-secondary">Cancel</x-secondary-button>
        <x-danger-button wire:click="execute" class="btn btn-danger">Delete</x-danger-button>
    </div>
</div>
