@extends('layouts.app')

@section('title', 'OA-Gateway | Open Access Research Publishing Platform')

@section('meta_description',
    'Explore open access journals, academic articles, scientific publications,
    algorithms, nanotechnology, agriculture, engineering, and peer-reviewed
    research content at OA-Gateway.')

@section('content')


    <!-- HERO SECTION -->
    <section class="max-w-7xl mx-auto px-6 mt-8">

        <div x-data="heroSlider()" x-init="start()"
            class="relative bg-[#162b6f] rounded-2xl overflow-hidden shadow-xl h-[420px]">

            <!-- SLIDER WRAPPER -->
            <div class="relative w-full h-full">

                <!-- SLIDES -->
                <template x-for="(slide, index) in slides" :key="index">

                    <div x-show="activeSlide === index" x-transition:enter="transition-opacity duration-700"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity duration-500" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" class="absolute inset-0 flex items-center" x-cloak>

                        <div class="px-10 md:px-16 text-white max-w-3xl">

                            <!-- TITLE -->
                            <h1 class="text-3xl md:text-5xl font-bold heading-font mb-6 leading-tight" x-text="slide.title">
                            </h1>

                            <!-- DESCRIPTION -->
                            <p class="text-lg text-gray-200 leading-8 mb-8" x-text="slide.description"></p>

                            <!-- BUTTON -->
                            <a :href="slide.link"
                                class="inline-flex items-center gap-2
                            bg-white text-[#162b6f]
                            px-7 py-3 rounded-lg
                            font-semibold hover:bg-gray-100 transition">
                                Read More
                            </a>

                        </div>

                    </div>

                </template>

            </div>

            <!-- PREV -->
            <button @click="prev()"
                class="absolute left-5 top-1/2 -translate-y-1/2
            bg-white/20 hover:bg-white/30
            backdrop-blur text-white
            w-10 h-10 rounded-full flex items-center justify-center z-20">
                ‹
            </button>

            <!-- NEXT -->
            <button @click="next()"
                class="absolute right-5 top-1/2 -translate-y-1/2
            bg-white/20 hover:bg-white/30
            backdrop-blur text-white
            w-10 h-10 rounded-full flex items-center justify-center z-20">
                ›
            </button>

            <!-- DOTS -->
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-3 z-20">

                <template x-for="(slide, index) in slides" :key="index">

                    <button @click="activeSlide = index" class="w-3 h-3 rounded-full transition-all duration-300"
                        :class="activeSlide === index ?
                            'bg-white scale-125' :
                            'bg-white/40'"></button>

                </template>

            </div>

        </div>

    </section>

    <!-- ALPINE JS -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- SLIDER SCRIPT -->
    <script>
        function heroSlider() {

            return {

                activeSlide: 0,

                interval: null,

                slides: [

                    {
                        title: 'Agriculture',
                        description: 'Science and technology of crop and animal production, biosecurity, sustainability, and food systems research.',
                        link: '#'
                    },

                    {
                        title: 'Algorithms',
                        description: 'Algorithms are step-by-step computational procedures designed to solve problems and process information efficiently.',
                        link: '#'
                    },

                    {
                        title: 'Nanotechnology',
                        description: 'Nanotechnology is the science of manipulating matter at the atomic and molecular scale for innovation.',
                        link: '#'
                    }

                ],

                start() {

                    this.interval = setInterval(() => {

                        this.next()

                    }, 4000)

                },

                next() {

                    this.activeSlide =
                        (this.activeSlide + 1) % this.slides.length

                },

                prev() {

                    this.activeSlide =
                        (this.activeSlide - 1 + this.slides.length) %
                        this.slides.length

                }

            }

        }
    </script>

   <!-- SUBJECT AREA -->
<section class="max-w-7xl mx-auto px-6 mt-20">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10">

        <div>
            <h2 class="text-4xl font-bold heading-font text-gray-900">
                Subject Areas
            </h2>

            <p class="text-gray-500 mt-3">
                Explore multidisciplinary research domains and academic fields.
            </p>
        </div>

        <a href="{{ route('gateway') }}" class="text-[#162b6f] font-semibold hover:underline">
            View all subject areas →
        </a>

    </div>

    <!-- GRID -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-7">

        @forelse($subjects as $subject)

            <div class="bg-white rounded-2xl border p-7 shadow-sm hover:shadow-xl transition">

                <div class="flex items-center justify-between mb-5">

                    <h3 class="text-2xl font-bold heading-font">
                        {{ $subject->name }}
                    </h3>

                    <span class="text-2xl">📚</span>

                </div>

                <p class="text-gray-600 leading-7 mb-8">
                    {{ \Illuminate\Support\Str::limit(strip_tags($subject->description), 120) }}
                </p>

                <div class="flex items-center justify-between">

                    <span class="text-sm text-gray-500">
                        {{ $subject->article_count }} Articles
                    </span>

                    <a href="{{ route('subjectdetails', $subject->slug_url) }}"
                        class="text-[#162b6f] font-semibold hover:underline">
                        Browse →
                    </a>

                </div>

            </div>

        @empty

            <div class="col-span-3">
                <div class="bg-white rounded-2xl border p-10 text-center">
                    <p class="text-gray-500">
                        No Subject Areas Available.
                    </p>
                </div>
            </div>

        @endforelse

    </div>

</section>

    <!-- CTA -->
    <section class="max-w-7xl mx-auto px-6 mt-24 mb-24">

        <div class="bg-[#162b6f] rounded-2xl px-10 py-20 text-center text-white">

            <h2 class="text-4xl md:text-5xl font-bold heading-font mb-6">
                Ready to Publish Your Research?
            </h2>

            <p class="max-w-3xl mx-auto text-lg text-gray-200 leading-8 mb-10">
                Submit your peer-reviewed manuscripts and publish
                high-quality academic research with OA-Gateway.
            </p>

            <a href="#"
                class="inline-flex items-center gap-3
            bg-white text-[#162b6f]
            px-8 py-4 rounded-xl
            font-bold hover:bg-gray-100 transition">
                📄 Submit Your Manuscript
            </a>

        </div>

    </section>

    <!-- ALPINE JS -->
    <script src="//unpkg.com/alpinejs" defer></script>


@endsection
