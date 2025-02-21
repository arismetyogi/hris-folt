<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    <x-button wire:click="$dispatch('openModal','karyawans.create')">
        <x-phosphor-user-plus-duotone class="size-4"/>
        {{ __('New Karyawan') }}
    </x-button>
</div>
