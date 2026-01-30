<button
    {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-6 py-2 bg-white/5 border border-white/10 rounded-lg font-black text-[10px] text-gray-300 uppercase tracking-[0.2em] shadow-sm hover:bg-white/10 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-950 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
