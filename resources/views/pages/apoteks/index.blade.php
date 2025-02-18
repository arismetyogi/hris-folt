<?php

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;

middleware(['auth', 'verified', 'can:'.\App\Enums\Permissions::ManageDepartments->value]);
name('apoteks.index');

?>


<x-layouts.app>
    <x-app.heading
        title="Data Apotek"
        description="Manage Apotek."
        :border="false"
    />

    <div class="py-12">
        @livewire('apotek-table')
    </div>
</x-layouts.app>
