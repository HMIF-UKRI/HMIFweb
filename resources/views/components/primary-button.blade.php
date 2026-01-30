<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-2 bg-red-600 border border-transparent rounded-lg font-black text-[10px] text-white uppercase tracking-[0.2em] hover:bg-red-700 hover:shadow-[0_0_15px_rgba(220,38,38,0.4)] focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-950 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
