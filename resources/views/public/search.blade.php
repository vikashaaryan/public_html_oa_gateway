@extends('layouts.app')

@section('title', 'Search Research Articles, Journals & Academic Papers | OA-Gateway')

@section('meta_description',
'Search research articles, academic journals, scholarly publications, authors, universities, and subject areas on OA-Gateway.')

@section('meta_keywords',
'search articles,research articles,journals,academic papers')

@section('content')

<section class="bg-[#f8f8f8] min-h-screen py-14">

    <div class="max-w-7xl mx-auto px-6">

        <!-- Heading -->
        <div class="mb-10">

            <h1 class="text-[56px] font-bold heading-font text-[#0f1f4b] mb-4">
                Search Articles
            </h1>

            <p class="text-[18px] text-gray-600">
                Search for articles by title, subject area, university, article type
            </p>

        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('search') }}">

            <!-- Search Box -->
            <div class="flex flex-col lg:flex-row gap-4 mb-8">

                <div class="flex-1 relative">

                    <svg
                        class="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0a7 7 0 0114 0z"/>

                    </svg>

                    <input
                        type="text"
                        name="keyword"
                        value="{{ request('keyword') }}"
                        placeholder="Search by title"
                        class="w-full h-16 border rounded-xl pl-14 pr-5 text-lg focus:ring-2 focus:ring-[#1d3f91]">

                </div>

                <button
                    class="bg-[#1d3f91] text-white px-12 rounded-xl hover:bg-[#15306d]">

                    Search

                </button>

                <a
                    href="{{ route('search') }}"
                    class="border px-10 rounded-xl flex items-center justify-center hover:bg-gray-50">

                    Reset Filters

                </a>

            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl border p-7 mb-14">

                <div class="grid lg:grid-cols-3 gap-8">

                    <!-- Subject -->

                    <div>

                        <label class="block text-gray-600 mb-3">
                            Subject Area
                        </label>

                        <select
                            name="subject"
                            class="w-full border rounded-lg px-4 py-3">

                            <option value="">
                                All Subject Areas
                            </option>

                            @foreach($subjects as $subject)

                                <option
                                    value="{{ $subject->id }}"
                                    {{ request('subject')==$subject->id ? 'selected' : '' }}>

                                    {{ $subject->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- University -->

                    <div>

                        <label class="block text-gray-600 mb-3">
                            University
                        </label>

                        <select
                            name="university"
                            class="w-full border rounded-lg px-4 py-3">

                            <option value="">
                                All Universities
                            </option>

                            @foreach($universities as $university)

                                <option
                                    value="{{ $university->id }}"
                                    {{ request('university')==$university->id ? 'selected' : '' }}>

                                    {{ $university->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- Article Type -->

                    <div>

                        <label class="block text-gray-600 mb-3">
                            Article Types
                        </label>

                        <select
                            name="article_type"
                            class="w-full border rounded-lg px-4 py-3">

                            <option value="">
                                All Article Types
                            </option>

                            @foreach($articleTypes as $type)

                                <option
                                    value="{{ $type->id }}"
                                    {{ request('article_type')==$type->id ? 'selected' : '' }}>

                                    {{ $type->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

            </div>

        </form>

        @if($articles->count())

            <div class="mb-8">

                <h2 class="text-2xl font-bold text-[#0f1f4b]">

                    Search Results ({{ $articles->count() }})

                </h2>

            </div>

            <div class="grid gap-6">

                @foreach($articles as $article)

                    <div class="bg-white rounded-xl border p-6 hover:shadow-md transition">

                        <h3 class="text-2xl font-bold text-[#0f1f4b] mb-4">

                            {{ $article->title }}

                        </h3>

                        <!-- Authors -->

                        <div class="flex flex-wrap gap-2 mb-4">

                            @foreach($article->ArticleAuthors as $author)

                                <span class="bg-gray-100 px-3 py-1 rounded-full text-sm">

                                    {{ $author->author_name }}

                                </span>

                            @endforeach

                        </div>

                        <!-- Tags -->

                        <div class="flex flex-wrap gap-2 mb-5">

                            @if($article->Volumes)

                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">

                                    {{ $article->Volumes->name }}

                                </span>

                            @endif

                            @if($article->Issues)

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

                                    {{ $article->Issues->name }}

                                </span>

                            @endif

                            @if($article->ArticleType)

                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm">

                                    {{ $article->ArticleType->name }}

                                </span>

                            @endif

                        </div>

                        @if($article->abstract)

                            <p class="text-gray-600 mb-6">

                                {{ \Illuminate\Support\Str::limit(strip_tags($article->abstract),200) }}

                            </p>

                        @endif

                        <a
                            href="{{ route('article-details',$article->slug_url) }}"
                            class="text-[#1d3f91] font-semibold hover:underline">

                            Read Article →

                        </a>

                    </div>

                @endforeach

            </div>

        @elseif(
            request()->filled('keyword') ||
            request()->filled('subject') ||
            request()->filled('university') ||
            request()->filled('article_type')
        )

            <div class="bg-white border rounded-xl p-16 text-center">

                <h2 class="text-4xl font-bold text-[#0f1f4b] mb-4">

                    No Results Found

                </h2>

                <p class="text-gray-600">

                    No articles matching your search criteria.

                </p>

            </div>

        @endif

    </div>

</section>

@endsection