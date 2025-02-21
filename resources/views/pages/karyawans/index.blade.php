<?php

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;

middleware(['auth', 'verified', 'can:'.\App\Enums\Permissions::ManageEmployees->value]);
name('karyawans.index');

?>


<x-layouts.app>
    <x-app.heading
        title="Karyawan"
        description="Manage Data Karyawan"
        :border="false"
    />

    <div class="py-12">
        @livewire('karyawan-table')
    </div>
</x-layouts.app>
