<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-rust-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-rust-600 active:bg-rust-600 focus:outline-none focus:ring-2 focus:ring-rust-500 focus:ring-offset-2 focus:ring-offset-night-950 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
