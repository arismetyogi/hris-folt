@props(['selected', 'modelId', 'options'])
<div>
    <select wire:change="categoryChanged($event.target.value, {{ $modelId }})">
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
