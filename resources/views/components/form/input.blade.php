@props(['name', 'label', 'type' => 'text', 'value' => null, 'required' => false, 'hint' => null])

<div>
    <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-gray-700">
        {{ $label }} @if ($required)<span class="text-red-500">*</span>@endif
    </label>

    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
           value="{{ $type === 'password' ? '' : old($name, $value) }}"
           @required($required)
           {{ $attributes->class([
               'w-full rounded-lg border px-3 py-2 text-sm outline-none transition focus:ring-2',
               'border-red-400 focus:border-red-500 focus:ring-red-100' => $errors->has($name),
               'border-gray-300 focus:border-brand-500 focus:ring-brand-100' => ! $errors->has($name),
           ]) }}>

    @if ($hint)
        <p class="mt-1 text-xs text-gray-500">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
