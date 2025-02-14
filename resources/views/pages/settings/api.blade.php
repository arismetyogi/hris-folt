<?php

use Livewire\Volt\Component;
use function Laravel\Folio\{middleware, name};

middleware('auth');
name('settings.api');

new class extends Component {
}

?>

<x-layouts.app>
    @volt('settings.api')
    <div class="relative">
        <x-app.settings-layout
            title="API Keys"
            description="Manage your API Keys"
        >
            <div class="mt-10 w-full max-w-lg">
                @livewire('api.api-token-manager')
            </div>
        </x-app.settings-layout>
    </div>
    @endvolt
</x-layouts.app>
