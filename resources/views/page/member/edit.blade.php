@extends("layouts.app")

@section("content")
    <section
        class="flex min-h-screen items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 pt-20"
    >
        <div
            class="text-secondary container mx-auto rounded-xl bg-white p-8 shadow-lg"
        >
            <h1 class="mb-6 text-center text-3xl font-bold text-indigo-700">
                Edit Member
            </h1>

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

            <form
                action="{{ route("member.update", $member->id) }}"
                method="POST"
                enctype="multipart/form-data"
                class="grid grid-cols-1 gap-4 space-y-6"
            >
                @csrf
                @method("PUT")
                <div>
                    <label
                        for="name"
                        class="mb-1 block font-semibold text-gray-700"
                    >
                        Name
                    </label>
                    <input
                        type="text"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        id="name"
                        name="name"
                        required
                        placeholder="Enter member name"
                        value="{{ old("name", $member->name) }}"
                    />
                </div>
                <div>
                    <label
                        for="student_id_number"
                        class="mb-1 block font-semibold text-gray-700"
                    >
                        NPM
                    </label>
                    <input
                        type="text"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        id="student_id_number"
                        name="student_id_number"
                        required
                        placeholder="Enter your NPM"
                        value="{{ old("student_id_number", $member->student_id_number) }}"
                    />
                </div>
                <div>
                    <label
                        for="image"
                        class="mb-1 block font-semibold text-gray-700"
                    >
                        Image
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        @if ($member->image)
                            <div>
                                <img
                                    src="{{ asset("storage/" . $member->image) }}"
                                    alt="Current Image"
                                    class="mb-2 h-24 w-24 rounded object-cover"
                                />
                                <div class="text-xs text-gray-500">
                                    Current Image
                                </div>
                            </div>
                        @endif

                        <label
                            for="image"
                            class="flex cursor-pointer flex-col items-center rounded border border-gray-300 p-4 text-gray-900 shadow-sm sm:p-6"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="size-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m0-3-3-3m0 0-3 3m3-3v11.25m6-2.25h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75"
                                />
                            </svg>

                            <span class="mt-4 font-medium">
                                Upload new file (optional)
                            </span>

                            <span
                                class="mt-2 inline-block rounded border border-gray-200 bg-gray-50 px-3 py-1.5 text-center text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-100"
                            >
                                Browse files
                            </span>

                            <input
                                type="file"
                                id="image"
                                name="image"
                                accept="image/*"
                                class="sr-only"
                                aria-label="Upload Image"
                            />
                        </label>
                    </div>
                </div>
                <div>
                    <label
                        for="position"
                        class="mb-1 block font-semibold text-gray-700"
                    >
                        Position
                    </label>
                    <input
                        type="text"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        id="position"
                        name="position"
                        required
                        placeholder="Enter your position"
                        value="{{ old("position", $member->position) }}"
                    />
                </div>
                <div>
                    <label
                        for="organization_period_id"
                        class="mb-1 block font-semibold text-gray-700"
                    >
                        Pilih Periode Organisasi / Kabinet
                    </label>
                    <select
                        id="organization_period_id"
                        name="organization_period_id"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        required
                    >
                        <option value="" disabled>
                            Pilih Periode Organisasi / Kabinet
                        </option>
                        @foreach ($organizationPeriods as $period)
                            <option
                                value="{{ $period->id }}"
                                {{ old("organization_period_id", $member->organization_period_id) == $period->id ? "selected" : "" }}
                            >
                                {{ $period->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label
                        for="department_id"
                        class="mb-1 block font-semibold text-gray-700"
                    >
                        Organization
                    </label>
                    <select
                        id="department_id"
                        name="department_id"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 transition focus:ring-2 focus:ring-indigo-400 focus:outline-none"
                        required
                    >
                        <option value="" disabled>Pilih Bidang</option>
                        @foreach ($departments as $department)
                            <option
                                value="{{ $department->id }}"
                                {{ old("department_id", $member->department_id) == $department->id ? "selected" : "" }}
                            >
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button
                    type="submit"
                    class="w-full rounded-lg bg-indigo-600 px-4 py-2 font-semibold text-white shadow transition hover:bg-indigo-700"
                >
                    Update Member
                </button>
            </form>
        </div>
    </section>
@endsection
