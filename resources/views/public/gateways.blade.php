@extends('layouts.app')

@section('title', 'Research Gateways | Explore Subjects, Universities & Topics | OA-Gateway')

@section('meta_description', 'Explore research gateways at OA-Gateway. Browse academic subjects, universities, and research topics to discover scholarly articles, journals, publications, and open-access research resources across multiple disciplines.')

@section('meta_keywords', 'research gateways, academic research, subject areas, universities, research topics, scholarly articles, open access journals, academic publications, scientific research, university research, research database, journal articles, OA-Gateway')

@section('content')

<section x-data="{ tab:'subjects' }" class="bg-[#f7f7f7] py-16 min-h-screen">

    <div class="max-w-7xl mx-auto px-6">

        <!-- HEADER -->
        <div class="mb-12">

            <h1 class="text-5xl lg:text-6xl font-bold heading-font text-[#0f1f4b] mb-4">
                Research Gateways
            </h1>

            <p class="text-lg text-gray-600 max-w-4xl leading-8">
                Explore research by subject areas, universities, and topics.
                Discover scholarly articles, journals, and academic resources
                across multiple disciplines.
            </p>

        </div>

        <!-- TABS -->
        <div class="border-b border-gray-300 mb-10">

            <div class="flex flex-wrap gap-8">

                <button
                    @click="tab='subjects'"
                    class="pb-4 font-medium transition"
                    :class="tab=='subjects'
                    ? 'text-[#162b6f] border-b-2 border-[#162b6f]'
                    : 'text-gray-500'"
                >
                    📚 Subject Areas
                </button>

                <button
                    @click="tab='universities'"
                    class="pb-4 font-medium transition"
                    :class="tab=='universities'
                    ? 'text-[#162b6f] border-b-2 border-[#162b6f]'
                    : 'text-gray-500'"
                >
                    🎓 Universities
                </button>

                <button
                    @click="tab='topics'"
                    class="pb-4 font-medium transition"
                    :class="tab=='topics'
                    ? 'text-[#162b6f] border-b-2 border-[#162b6f]'
                    : 'text-gray-500'"
                >
                    🏷 Topics
                </button>

            </div>

        </div>

        <!-- SUBJECTS -->
        <div
            x-show="tab=='subjects'"
            x-transition
            class="grid md:grid-cols-2 lg:grid-cols-3 gap-6"
        >

            @forelse($subjects as $subject)

                <div class="bg-white rounded-2xl border p-7 shadow-sm hover:shadow-xl transition">

                    <div class="flex justify-between items-start mb-5">

                        <h3 class="text-2xl font-bold heading-font text-[#0f1f4b]">
                            {{ $subject->name }}
                        </h3>

                        <span class="text-2xl">📚</span>

                    </div>

                    <p class="text-gray-600 leading-7 mb-6">
                        {{ \Illuminate\Support\Str::limit(strip_tags($subject->description),120) }}
                    </p>

                    <div class="flex items-center justify-between">

                        <span class="text-sm text-gray-500">
                            {{ $subject->article_count }} Articles
                        </span>

                        <a href="{{ route('subjectdetails',$subject->slug_url) }}"
                           class="text-[#162b6f] font-semibold hover:underline">
                            Browse →
                        </a>

                    </div>

                </div>

            @empty

                <div class="col-span-3">

                    <div class="bg-white rounded-xl p-8 text-center">

                        <h3 class="text-xl font-semibold text-gray-500">
                            No Subject Found
                        </h3>

                    </div>

                </div>

            @endforelse

        </div>

        <!-- UNIVERSITIES -->
        <div
            x-show="tab=='universities'"
            x-transition
            class="grid md:grid-cols-2 lg:grid-cols-3 gap-6"
        >

            @forelse($universities as $university)

                <div class="bg-white rounded-2xl border p-7 shadow-sm hover:shadow-xl transition">

                    <div class="flex justify-between items-start mb-5">

                        <h3 class="text-xl font-bold heading-font text-[#0f1f4b]">
                            {{ $university->name }}
                        </h3>

                        <span class="text-2xl">🎓</span>

                    </div>

                    <p class="text-gray-600 leading-7 mb-6">
                        {{ \Illuminate\Support\Str::limit(strip_tags($university->description),120) }}
                    </p>

                    <div class="flex items-center justify-between">

                        <span class="text-sm text-gray-500">
                            Collaborations: {{ $university->collaboration }}
                        </span>

                        <a href="{{ route('university.details',$university->slug_url) }}"
                           class="text-[#162b6f] font-semibold hover:underline">
                            View →
                        </a>

                    </div>

                </div>

            @empty

                <div class="col-span-3">

                    <div class="bg-white rounded-xl p-8 text-center">

                        <h3 class="text-xl font-semibold text-gray-500">
                            No University Found
                        </h3>

                    </div>

                </div>

            @endforelse

        </div>

        <!-- TOPICS -->
        <div
            x-show="tab=='topics'"
            x-transition
            class="grid md:grid-cols-2 lg:grid-cols-3 gap-6"
        >

            @forelse($topics as $topic)

                <div class="bg-white rounded-2xl border p-7 shadow-sm hover:shadow-xl transition">

                    <div class="flex justify-between items-start mb-5">

                        <h3 class="text-2xl font-bold heading-font text-[#0f1f4b]">
                            {{ $topic->name }}
                        </h3>

                        <span class="text-2xl">🏷</span>

                    </div>

                    <p class="text-gray-600 leading-7 mb-6">
                        {{ \Illuminate\Support\Str::limit(strip_tags($topic->description),120) }}
                    </p>

                    <div class="flex items-center justify-end">

                        <a href="{{ route('topic.details',$topic->slug_url) }}"
                           class="text-[#162b6f] font-semibold hover:underline">
                            Explore →
                        </a>

                    </div>

                </div>

            @empty

                <div class="col-span-3">

                    <div class="bg-white rounded-xl p-8 text-center">

                        <h3 class="text-xl font-semibold text-gray-500">
                            No Topics Found
                        </h3>

                    </div>

                </div>

            @endforelse

        </div>

    </div>

</section>

<script src="//unpkg.com/alpinejs" defer></script>

@endsection