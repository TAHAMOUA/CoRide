@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-ink-400']) }}>
    {{ $value ?? $slot }}
</label>
