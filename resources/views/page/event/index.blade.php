@extends("layouts.app")

@section("content")
    <section class="text-secondary bg-white pt-20">
        <div class="container mx-auto p-4">
            <div>
                <div class="mb-6 flex items-center justify-between">
                    <h1 class="mb-6 text-3xl font-bold text-indigo-700">
                        Event List
                    </h1>

                    <a
                        href="{{ route("event.create") }}"
                        class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 4v16m8-8H4"
                            />
                        </svg>
                        Add New Event
                    </a>
                </div>

                @if (session("success"))
                    <div
                        class="mb-4 rounded-lg bg-green-100 p-4 text-green-700"
                        role="alert"
                    >
                        {{ session("success") }}
                    </div>
                @endif

                @if ($errors->any())
                    <div
                        class="mb-4 rounded-lg bg-red-100 p-4 text-red-700"
                        role="alert"
                    >
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y-2 divide-gray-200">
                        <thead class="ltr:text-left rtl:text-right">
                            <tr
                                class="*:font-medium *:text-gray-900 *:first:sticky *:first:bg-white"
                            >
                                <th class="px-3 py-2 whitespace-nowrap">
                                    thumbnail_path
                                </th>
                                <th class="px-3 py-2 whitespace-nowrap">
                                    Title
                                </th>
                                <th class="px-3 py-2 whitespace-nowrap">
                                    slug
                                </th>
                                <th class="px-3 py-2 whitespace-nowrap">
                                    Short Description
                                </th>
                                <th class="px-3 py-2 whitespace-nowrap">
                                    Description
                                </th>
                                <th class="px-3 py-2 whitespace-nowrap">
                                    Event Date
                                </th>
                                <th class="px-3 py-2 whitespace-nowrap">
                                    Location
                                </th>
                                <th class="px-3 py-2 whitespace-nowrap">
                                    Status
                                </th>
                                <th class="px-3 py-2 whitespace-nowrap">
                                    Event Category
                                </th>
                                <th class="px-3 py-2 whitespace-nowrap">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($events as $event)
                                <tr
                                    class="*:text-gray-900 *:first:sticky *:first:left-0 *:first:bg-white *:first:font-medium"
                                >
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        @if ($event->thumbnail_path)
                                            <img
                                                src="{{ asset("storage/" . $event->thumbnail_path) }}"
                                                alt="{{ $event->title }}"
                                                class="h-10 w-10 rounded-md object-cover"
                                            />
                                        @else
                                            <span
                                                class="inline-block h-10 w-10 rounded-full bg-gray-200"
                                            ></span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        {{ $event->title }}
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        {{ $event->slug }}
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        {{ $event->short_description }}
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        {{ $event->description }}
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        {{ $event->event_date }}
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        {{ $event->location }}
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        {{ $event->status }}
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        {{ $event->eventCategory->name ?? "-" }}
                                    </td>
                                    <th
                                        class="border-l border-gray-200 px-3 py-2 text-center whitespace-nowrap"
                                    >
                                        <span
                                            class="inline-flex cursor-pointer items-center gap-1 rounded-md border border-gray-300 px-2 py-1 text-sm hover:bg-gray-100"
                                            onclick="window.location.href='{{ route("event.edit", $event->id) }}'"
                                        >
                                            <svg
                                                class="h-4 w-4 text-blue-500"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a4 4 0 01-1.414.828l-4 1a1 1 0 01-1.263-1.263l1-4a4 4 0 01.828-1.414z"
                                                />
                                            </svg>
                                            <span
                                                class="font-semibold text-blue-600"
                                            >
                                                Edit
                                            </span>
                                        </span>
                                        <form
                                            action="{{ route("event.destroy", $event->id) }}"
                                            method="POST"
                                            class="ml-4 inline-flex items-center gap-1"
                                            onsubmit="return confirm('Are you sure you want to delete this event?');"
                                            style="display: inline"
                                        >
                                            @csrf
                                            @method("DELETE")
                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-1 rounded-md border border-gray-300 px-2 py-1 text-sm hover:bg-gray-100"
                                            >
                                                <svg
                                                    class="h-4 w-4 text-red-500"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12"
                                                    />
                                                </svg>
                                                <span
                                                    class="font-semibold text-red-600"
                                                >
                                                    Delete
                                                </span>
                                            </button>
                                        </form>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
