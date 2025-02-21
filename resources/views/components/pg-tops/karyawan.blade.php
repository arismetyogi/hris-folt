<x-button class="my-1" wire:click="$dispatch('openModal',{component: 'karyawans.create'})">
    <x-phosphor-user-plus-duotone class="size-4 mr-2"/>
    {{ __('New Karyawan') }}
</x-button>
