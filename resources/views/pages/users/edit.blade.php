<?php

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;

middleware(['auth', 'verified', 'can:'.\App\Enums\Permissions::ManageUsers->value]);
name('users.edit');

?>
