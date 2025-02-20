<?php

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;

middleware(['auth', 'verified', 'can:'.\App\Enums\Permissions::ManageDepartments->value]);
name('unitbisnis.index');

?>


<x-layouts.app>
    <x-app.heading
        title="Data Unit Bisnis"
        description="Manage Data Unit Bisnis."
        :border="false"
    />

    <div class="py-12">
        @livewire('unit-bisnis-table')
    </div>
</x-layouts.app>
