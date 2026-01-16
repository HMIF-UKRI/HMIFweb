@extends('layouts.app')

@section('content')
    <section class="flex min-h-screen items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 pt-20">
        <div class="text-dark container mx-auto rounded-xl bg-white p-8 shadow-lg">
            <h1 class="mb-6 text-center text-3xl font-bold text-indigo-700">
                Create New Event
            </h1>

            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-700" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-700" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data"
                class="grid grid-cols-1 gap-4 space-y-6">
                @csrf
                @method('POST')
                <div>
                    <label for="title" class="mb-1 block font-semibold text-gray-700">
                        Event Name
                    </label>
                    <input type="text"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        id="title" name="title" required placeholder="Enter event name" value="{{ old('title') }}" />
                </div>
                <div>
                    <label for="short_description" class="mb-1 block font-semibold text-gray-700">
                        Short Description
                    </label>
                    <input type="text"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        id="short_description" name="short_description" required placeholder="Enter event name"
                        value="{{ old('short_description') }}" />
                </div>
                <div>
                    <label for="description" class="mb-1 block font-semibold text-gray-700">
                        Description
                    </label>
                    <textarea
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        id="description" name="description" rows="4" required placeholder="Enter event description">
    {{ old('description') }}</textarea>
                </div>
                <div>
                    <label for="event_date" class="mb-1 block font-semibold text-gray-700">
                        Date
                    </label>
                    <input type="date"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        id="event_date" name="event_date" required value="{{ old('event_date') }}" />
                </div>
                <div>
                    <label for="location" class="mb-1 block font-semibold text-gray-700">
                        Location
                    </label>
                    <input type="text"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        id="location" name="location" required placeholder="Enter event location"
                        value="{{ old('location') }}" />
                </div>
                <div>
                    <label for="status" class="mb-1 block font-semibold text-gray-700">
                        Status
                    </label>
                    <select id="status" name="status"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        required>
                        <option value="" disabled selected>
                            Select event status
                        </option>
                        <option value="berlangsung" {{ old('status') == 'berlangsung' ? 'selected' : '' }}>
                            Berlangsung
                        </option>
                        <option value="rutin" {{ old('status') == 'rutin' ? 'selected' : '' }}>
                            Rutin
                        </option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>
                            Selesai
                        </option>
                        <option value="dibatalkan" {{ old('status') == 'dibatalkan' ? 'selected' : '' }}>
                            Dibatalkan
                        </option>
                    </select>
                </div>
                <div>
                    <label for="event_category_id" class="mb-1 block font-semibold text-gray-700">
                        Event Category
                    </label>
                    <select id="event_category_id" name="event_category_id"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        required>
                        <option value="" disabled selected>
                            Select event category
                        </option>
                        @foreach ($eventCategories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('event_category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="image" class="mb-1 block font-semibold text-gray-700">
                        Event Image
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <label for="image"
                            class="flex cursor-pointer flex-col items-center rounded border border-gray-300 p-4 text-gray-900 shadow-sm sm:p-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m0-3-3-3m0 0-3 3m3-3v11.25m6-2.25h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75" />
                            </svg>

                            <span class="mt-4 font-medium">
                                Upload event image
                            </span>

                            <span
                                class="mt-2 inline-block rounded border border-gray-200 bg-gray-50 px-3 py-1.5 text-center text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-100">
                                Browse files
                            </span>

                            <input type="file" id="image" name="thumbnail_path" accept="image/*" class="sr-only"
                                aria-label="Upload Image" value="{{ old('thumbnail_path') }}" />
                        </label>
                    </div>
                </div>
                <button type="submit"
                    class="w-full rounded-lg bg-indigo-600 px-4 py-2 font-semibold text-white shadow transition hover:bg-indigo-700">
                    Create Event
                </button>
            </form>
        </div>
    </section>
@endsection
