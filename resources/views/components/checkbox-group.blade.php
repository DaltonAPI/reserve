@props(['name', 'id', 'options', 'selected' => []])

<div {{ $attributes }}>

    <div class="flex flex-wrap">
        @foreach($options as $value => $label)
            <label class="inline-flex items-center mr-4 mb-2">
                <input type="checkbox" name="{{ $name }}[]" id="{{ $id }}_{{ $loop->index }}" value="{{ $value }}" {{ in_array($value, $selected) ? 'checked' : '' }} class="form-checkbox h-4 w-4 text-primary-600 transition duration-150 ease-in-out" />
                <span class="ml-2 text-sm">{{ $label }}</span>
            </label>
        @endforeach
    </div>
    @error($name)
    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
