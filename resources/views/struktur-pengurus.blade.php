@extends("layouts.app")

@section("content")
    <section class="bg-white py-16">
        <img
            src="{{ asset("images/banner.png") }}"
            alt="banner"
            width="20"
            height="20"
            class="min-h-64 w-full bg-center bg-no-repeat object-cover shadow-2xl shadow-red-500"
            draggable="false"
        />

        <div class="container mx-auto px-4">
            <img
                src="{{ asset("images/kabinet-digiswara.png") }}"
                alt="kabinet-digiswara"
                class="mx-auto mb-8 w-[80%]"
                draggable="false"
            />

            <div class="mb-12 flex w-full items-center">
                <span
                    class="h-1 flex-1 rounded-full bg-gradient-to-r from-transparent to-red-300 dark:to-red-600"
                ></span>

                <span
                    class="shrink-0 bg-gradient-to-r from-red-300 to-red-600 bg-clip-text px-4 text-lg font-bold tracking-wider text-transparent uppercase md:text-2xl"
                >
                    STRUKTUR PENGURUS
                </span>

                <span
                    class="to-red-30 h-1 flex-1 rounded-full bg-gradient-to-l from-transparent dark:to-red-600"
                ></span>
            </div>

            {{-- PENGURUS --}}
            <div class="flex flex-col items-center justify-center px-6">
                {{-- Implementasi Frontend --}}
                {{--
                    @foreach ($members as $index => $member)
                    <div
                    class="{{ $index % 2 == 0 ? "md:flex-row" : "md:flex-row-reverse" }} relative mb-8 flex w-full flex-1 flex-col md:gap-12 lg:gap-28 lg:px-12"
                    >
                    <img
                    src="{{ asset($member->image) }}"
                    alt=""
                    width="20"
                    height="20"
                    class="z-50 h-auto w-full bg-cover bg-center object-cover md:w-1/2 lg:w-full"
                    draggable="false"
                    />
                    <div class="text-secondary text-justify">
                    <p>
                    Lorem ipsum dolor, sit amet consectetur
                    adipisicing elit. Velit, nihil illo? Fugiat
                    dolorum omnis accusantium quisquam itaque beatae
                    ea voluptate porro molestias minima obcaecati
                    veritatis pariatur corrupti excepturi suscipit
                    doloribus facere similique, cupiditate nobis
                    explicabo sequi accusamus facilis voluptatem!
                    Cum sequi hic nulla, est dignissimos rem quo
                    commodi atque ratione?
                    </p>
                    </div>
                    
                    @if ($index % 2 == 0)
                    <img
                    src="{{ asset("images/garis-1.png") }}"
                    alt=""
                    width="20"
                    height="20"
                    class="absolute right-40 -bottom-8 hidden w-[56%] md:block lg:right-64"
                    draggable="false"
                    />
                    @else
                    <img
                    src="{{ asset("images/garis-1.png") }}"
                    alt=""
                    width="20"
                    height="20"
                    class="absolute -bottom-8 left-40 hidden w-[56%] scale-x-[-1] md:block lg:left-64"
                    draggable="false"
                    />
                    @endif
                    </div>
                    @endforeach
                --}}

                <div
                    class="relative mb-8 flex w-full flex-1 flex-col md:flex-row md:gap-12 lg:gap-28 lg:px-12"
                >
                    {{-- Acong --}}
                    <img
                        src="{{ asset("images/pengurus/acong.png") }}"
                        alt=""
                        width="20"
                        height="20"
                        class="z-50 h-auto w-full bg-cover bg-center object-contain md:w-1/2 lg:w-full"
                        draggable="false"
                    />
                    <div class="text-secondary text-justify">
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Illum perferendis rerum mollitia inventore, ad
                            quasi perspiciatis ipsam. Similique facilis
                            architecto neque. Voluptatibus, in ipsa laudantium,
                            provident distinctio neque voluptatem repellendus
                            cupiditate magnam similique, assumenda aut ut sed
                            nam obcaecati itaque tempora. Nulla quod repellendus
                            debitis totam molestias temporibus alias eveniet.
                        </p>
                    </div>
                    <img
                        src="{{ asset("images/garis-1.png") }}"
                        alt=""
                        width="20"
                        height="20"
                        class="absolute right-40 -bottom-8 hidden w-[56%] md:block lg:right-64"
                        draggable="false"
                    />
                </div>

                <div
                    class="relative mb-8 flex w-full flex-1 flex-col-reverse md:flex-row md:gap-12 lg:gap-28 lg:px-12"
                >
                    {{-- IKHSAN --}}
                    <div class="text-secondary text-justify">
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Illum perferendis rerum mollitia inventore, ad
                            quasi perspiciatis ipsam. Similique facilis
                            architecto neque. Voluptatibus, in ipsa laudantium,
                            provident distinctio neque voluptatem repellendus
                            cupiditate magnam similique, assumenda aut ut sed
                            nam obcaecati itaque tempora. Nulla quod repellendus
                            debitis totam molestias temporibus alias eveniet.
                        </p>
                    </div>
                    <img
                        src="{{ asset("images/pengurus/ikhsan.png") }}"
                        alt=""
                        width="20"
                        height="20"
                        class="z-50 h-auto w-full bg-cover bg-center object-contain md:w-1/2 lg:w-full"
                        draggable="false"
                    />
                    <img
                        src="{{ asset("images/garis-1.png") }}"
                        alt=""
                        width="20"
                        height="20"
                        class="absolute -bottom-8 left-40 hidden w-[56%] scale-x-[-1] md:block lg:left-64"
                        draggable="false"
                    />
                </div>
                <div
                    class="relative mb-8 flex w-full flex-1 flex-col md:flex-row md:gap-12 lg:gap-28 lg:px-12"
                >
                    {{-- Tania --}}
                    <img
                        src="{{ asset("images/pengurus/tania.png") }}"
                        alt=""
                        width="20"
                        height="20"
                        class="z-50 h-auto w-full bg-cover bg-center object-contain md:w-1/2 lg:w-full"
                        draggable="false"
                    />
                    <div class="text-secondary text-justify">
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Illum perferendis rerum mollitia inventore, ad
                            quasi perspiciatis ipsam. Similique facilis
                            architecto neque. Voluptatibus, in ipsa laudantium,
                            provident distinctio neque voluptatem repellendus
                            cupiditate magnam similique, assumenda aut ut sed
                            nam obcaecati itaque tempora. Nulla quod repellendus
                            debitis totam molestias temporibus alias eveniet.
                        </p>
                    </div>
                    <img
                        src="{{ asset("images/garis-1.png") }}"
                        alt=""
                        width="20"
                        height="20"
                        class="absolute right-40 -bottom-8 hidden w-[56%] md:block lg:right-64"
                        draggable="false"
                    />
                </div>
                <div
                    class="relative mb-8 flex w-full flex-1 flex-col-reverse md:flex-row md:gap-12 lg:gap-28 lg:px-12"
                >
                    {{-- Raka --}}
                    <div class="text-secondary text-justify">
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Illum perferendis rerum mollitia inventore, ad
                            quasi perspiciatis ipsam. Similique facilis
                            architecto neque. Voluptatibus, in ipsa laudantium,
                            provident distinctio neque voluptatem repellendus
                            cupiditate magnam similique, assumenda aut ut sed
                            nam obcaecati itaque tempora. Nulla quod repellendus
                            debitis totam molestias temporibus alias eveniet.
                        </p>
                    </div>
                    <img
                        src="{{ asset("images/pengurus/raka.png") }}"
                        alt=""
                        width="20"
                        height="20"
                        class="z-50 h-auto w-full bg-cover bg-center object-contain md:w-1/2 lg:w-full"
                        draggable="false"
                    />
                    <img
                        src="{{ asset("images/garis-1.png") }}"
                        alt=""
                        width="20"
                        height="20"
                        class="absolute -bottom-8 left-40 hidden w-[56%] scale-x-[-1] md:block lg:left-64"
                        draggable="false"
                    />
                </div>
                <div
                    class="relative mb-8 flex w-full flex-1 flex-col md:flex-row md:gap-12 lg:gap-28 lg:px-12"
                >
                    {{-- Simai --}}
                    <img
                        src="{{ asset("images/pengurus/simai.png") }}"
                        alt=""
                        width="20"
                        height="20"
                        class="z-50 h-auto w-full bg-cover bg-center object-contain md:w-1/2 lg:w-full"
                        draggable="false"
                    />
                    <div class="text-secondary text-justify">
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Illum perferendis rerum mollitia inventore, ad
                            quasi perspiciatis ipsam. Similique facilis
                            architecto neque. Voluptatibus, in ipsa laudantium,
                            provident distinctio neque voluptatem repellendus
                            cupiditate magnam similique, assumenda aut ut sed
                            nam obcaecati itaque tempora. Nulla quod repellendus
                            debitis totam molestias temporibus alias eveniet.
                        </p>
                    </div>
                    <img
                        src="{{ asset("images/garis-2.png") }}"
                        alt=""
                        width="20"
                        height="20"
                        class="absolute right-12 -bottom-24 hidden w-[82%] md:block lg:right-20 lg:-bottom-36"
                        draggable="false"
                    />
                </div>
            </div>
            {{-- DEPARTEMEN --}}
            <div class="text-center md:hidden">
                <div class="flex w-full items-center">
                    <span
                        class="h-px flex-1 bg-gradient-to-r from-transparent to-red-300 dark:to-red-600"
                    ></span>

                    <span
                        class="shrink-0 bg-gradient-to-r from-red-300 to-red-600 bg-clip-text px-4 text-2xl font-bold tracking-wider text-transparent uppercase"
                    >
                        DEPARTEMEN
                    </span>

                    <span
                        class="h-px flex-1 bg-gradient-to-l from-transparent to-red-300 dark:to-red-600"
                    ></span>
                </div>
            </div>
            <div
                class="relative mt-16 mb-8 flex w-full flex-1 flex-col justify-center gap-6 md:flex-row lg:mt-20 lg:px-12"
            >
                <div class="flex-1">
                    <img
                        src="{{ asset("images/pengurus/ristek.png") }}"
                        alt=""
                        class="h-auto w-full bg-cover bg-center object-contain"
                        draggable="false"
                    />
                </div>
                <span
                    class="mx-auto h-1 w-1/2 rounded-lg bg-red-500 md:hidden"
                ></span>
                <div class="flex-1">
                    <img
                        src="{{ asset("images/pengurus/psdm.png") }}"
                        alt=""
                        class="h-auto w-full bg-cover bg-center object-contain"
                        draggable="false"
                    />
                </div>
                <span
                    class="mx-auto h-1 w-1/2 rounded-lg bg-red-500 md:hidden"
                ></span>
                <div class="flex-1">
                    <img
                        src="{{ asset("images/pengurus/kominfo.png") }}"
                        alt=""
                        class="h-auto w-full bg-cover bg-center object-contain"
                        draggable="false"
                    />
                </div>
            </div>
        </div>
    </section>
@endsection
