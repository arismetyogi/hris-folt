<?php

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;

middleware(['auth', 'verified', 'can:'.\App\Enums\Permissions::ManageUsers->value]);
name('users.index');

?>


<x-layouts.app>
    <x-app.heading
        title="Users"
        description="Manage Users."
        :border="false"
    />

    <div class="py-12">
    @livewire('user-table')
    </div>
</x-layouts.app>
