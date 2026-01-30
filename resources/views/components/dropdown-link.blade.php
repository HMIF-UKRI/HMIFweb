<a
    {{ $attributes->merge(['class' => 'block w-full px-4 py-2 text-start text-[10px] font-bold uppercase tracking-widest leading-5 text-gray-400 hover:bg-white/5 hover:text-red-500 focus:outline-none focus:bg-white/5 transition duration-150 ease-in-out']) }}>
    {{ $slot }}
</a>
