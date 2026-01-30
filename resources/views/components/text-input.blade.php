@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-white focus:border-red-600 outline-none transition-all']) }}>
