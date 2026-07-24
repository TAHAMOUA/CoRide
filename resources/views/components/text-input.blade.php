@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-night-800 border-night-700 text-paper placeholder:text-ink-400/60 focus:border-route-500 focus:ring-route-500 rounded-md shadow-sm']) }}>
