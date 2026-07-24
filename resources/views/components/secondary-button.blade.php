<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-night-800 border border-night-700 rounded-md font-semibold text-xs text-paper uppercase tracking-widest shadow-sm hover:bg-night-700 focus:outline-none focus:ring-2 focus:ring-route-500 focus:ring-offset-2 focus:ring-offset-night-950 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
