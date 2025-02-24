<?php

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;

middleware(['auth', 'verified', 'can:'.\App\Enums\Permissions::ManagePayrolls->value]);
name('payrolls.index');

?>


<x-layouts.app>
    <x-app.heading
        title="Payrolls"
        description="Manage Data Payroll"
        :border="false"
    />

    <div class="py-12">
        @livewire('payroll-table')
    </div>
</x-layouts.app>
