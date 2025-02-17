@props(['selected', 'modelId', 'options'])
<div>
    <select wire:change="categoryChanged($event.target.value, {{ $modelId }})" class="dark:bg-zinc-800 dark:text-zinc-50 border-none rounded-lg">
        @foreach ($options as $id => $name)
            <option
                value="{{ $id }}"
                @if ($id == $selected)
                    selected="selected"
                @endif
            >
                {{ $name }}
            </option>
        @endforeach
    </select>
</div>
