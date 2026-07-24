<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-paper border border-transparent rounded-md font-semibold text-xs text-night-950 uppercase tracking-widest hover:bg-white focus:bg-white active:bg-white focus:outline-none focus:ring-2 focus:ring-paper focus:ring-offset-2 focus:ring-offset-night-950 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
