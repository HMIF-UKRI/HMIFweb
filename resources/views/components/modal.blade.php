@props(['name', 'show' => false, 'maxWidth' => '2xl'])

@php
    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        '3xl' => 'sm:max-w-3xl',
        '4xl' => 'sm:max-w-4xl',
        '5xl' => 'sm:max-w-5xl',
        '6xl' => 'sm:max-w-6xl',
        '7xl' => 'sm:max-w-7xl',
    ][$maxWidth];
@endphp

<div x-data="{
    show: @js($show),
    focusables() {
        let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
        return [...$refs.panel.querySelectorAll(selector)].filter(el => !el.hasAttribute('disabled'))
    },
    firstFocusable() { return this.focusables()[0] },
    lastFocusable() { return this.focusables().slice(-1)[0] },
    nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
    prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
    nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
    prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1 },
}" x-init="$watch('show', value => {
    if (value) {
        document.body.classList.add('overflow-hidden');
        {{ $attributes->has('focusable') ? 'setTimeout(() => firstFocusable()?.focus(), 100)' : '' }}
    } else {
        document.body.classList.remove('overflow-hidden');
    }
})"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null"
    x-on:keydown.escape.window="show = false">
    <template x-teleport="body">
        <div x-show="show" class="fixed inset-0 overflow-y-auto p-3 sm:p-5 md:p-6" x-cloak
            style="z-index: 999999; display: {{ $show ? 'block' : 'none' }};">
            <div x-show="show" class="fixed inset-0 transform transition-all" style="z-index: 999999;"
                x-on:click="show = false"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div class="absolute inset-0 bg-gray-950/70 backdrop-blur-md"></div>
            </div>

            <div class="relative flex min-h-full items-start justify-center py-4" style="z-index: 1000000;">
                <div x-show="show" x-ref="panel"
                    x-on:close.stop="show = false"
                    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable()?.focus()"
                    x-on:keydown.shift.tab.prevent="prevFocusable()?.focus()"
                    class="relative w-full {{ $maxWidth }} max-h-[calc(100vh-2rem)] overflow-y-auto overscroll-contain rounded-3xl border border-white/10 bg-gray-950 shadow-[0_0_50px_rgba(0,0,0,0.5)] transform transition-all"
                    style="z-index: 1000001;"
                    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-8 scale-95">
                    <div class="pointer-events-none absolute inset-0 z-0 opacity-[0.03]"
                        style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>

                    <div class="relative z-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
