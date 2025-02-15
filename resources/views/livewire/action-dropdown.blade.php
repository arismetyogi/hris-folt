<div x-data="{ open: false }" class="relative inline-block text-left">
    <div>
        <button @click="open = !open" type="button"
                class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-zinc-700 dark:hover:bg-zinc-800 dark:text-gray-100"
                id="options-menu" aria-haspopup="true" x-bind:aria-expanded="open">
            Actions
            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                 aria-hidden="true">
                <path fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd"/>
            </svg>
        </button>
    </div>

    <div x-show="open" @click.away="open = false"
         class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 z-50"
         role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
        @foreach($actions as $group => $groupActions)
            <div class="py-1" role="none">
                @foreach($groupActions as $action => $config)
                    <button wire:click="callAction('{{ $action }}', {{ json_encode($config['params'] ?? []) }})"
                            class="block w-full text-left px-4 py-2 text-sm {{ $config['class'] ?? 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}"
                            role="menuitem">
                        {{ $config['label'] }}
                    </button>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
