@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-[11px] font-bold italic text-red-500 space-y-1 mt-2']) }}>
        @foreach ((array) $messages as $message)
            <li class="flex items-center gap-1">
                <ion-icon name="alert-circle-outline"></ion-icon>
                {{ $message }}
            </li>
        @endforeach
    </ul>
@endif
