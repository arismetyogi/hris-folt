<?php

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;

middleware(['auth', 'verified']);
name('users.index');

?>


<x-layouts.app>
    <x-app.heading
        title="Users"
        description="Manage Users."
        :border="false"
    />

    @livewire('user-table')
</x-layouts.app>
