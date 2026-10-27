{{-- $options berbentuk [value => label] --}}
@props(['name', 'label', 'options' => [], 'value' => null, 'required' => false, 'placeholder' => '-- Pilih --', 'hint' => null])

@php($selected = (string) old($name, $value))

<div>
    <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-gray-700">
        {{ $label }} @if ($required)<span class="text-red-500">*</span>@endif
    </label>

    <select id="{{ $name }}" name="{{ $name }}" @required($required)
        {{ $attributes->class([
            'w-full rounded-lg border bg-white px-3 py-2 text-sm outline-none transition focus:ring-2',
            'border-red-400 focus:border-red-500 focus:ring-red-100' => $errors->has($name),
            'border-gray-300 focus:border-brand-500 focus:ring-brand-100' => ! $errors->has($name),
        ]) }}>
        <option value="">{{ $placeholder }}</option>
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected($selected === (string) $optionValue)>{{ $optionLabel }}</option>
        @endforeach
    </select>

    @if ($hint)
        <p class="mt-1 text-xs text-gray-500">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
