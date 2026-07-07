@extends('layouts.app')

@section('title', $university->meta_title ?? $university->name)

@section('meta_description', $university->meta_description)

@section('content')

    <section class="bg-[#f7f7f7] min-h-screen py-12">

        <div class="max-w-7xl mx-auto px-6">

            <div class="bg-[#162b6f] rounded-2xl p-10 lg:p-14 shadow-lg mb-10">

                <h1 class="text-4xl lg:text-5xl font-bold text-white">
                    {{ $university->name }}
                </h1>

            </div>

            <div x-data="{ tab: 'about' }">

                <div class="border-b border-gray-300 mb-8">

                    <div class="flex gap-10">

                        <button @click="tab='about'" class="pb-4 font-medium transition"
                            :class="tab == 'about' ?
                                'text-[#162b6f] border-b-2 border-[#162b6f]' :
                                'text-gray-500'">
                            About
                        </button>

                        <a href="{{ route('university.articles', $university->slug_url) }}"
                            class="pb-4 font-medium text-[#162b6f] border-b-2 border-transparent hover:border-[#162b6f] transition">
                            View Articles ({{ $articles->count() }})
                        </a>

                    </div>

                </div>

                <!-- ABOUT -->

                <div x-show="tab=='about'">

                    <div class="bg-white rounded-2xl border p-8 shadow-sm">

                        <div class="prose max-w-none">
                            {!! $university->description !!}
                        </div>

                        <div class="grid md:grid-cols-2 gap-6 mt-10">

                            <div class="bg-gray-50 rounded-xl p-5">
                                <h3 class="font-semibold text-[#162b6f] mb-2">
                                    University Name
                                </h3>

                                <p>{{ $university->name }}</p>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-5">
                                <h3 class="font-semibold text-[#162b6f] mb-2">
                                    Collaborations
                                </h3>

                                <p>{{ $university->collaboration }}</p>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- ARTICLES -->

                <div x-show="tab=='articles'" x-cloak>

                    <div class="space-y-5">

                        @forelse($articles as $article)

                            <a href="{{ route('article.details', $article->id) }}"
                                class="block bg-white rounded-2xl border p-6 shadow-sm hover:shadow-lg transition">

                                <h2 class="text-2xl font-bold text-[#162b6f] mb-3">
                                    {{ $article->title }}
                                </h2>

                                <div class="flex flex-wrap gap-2 mb-4">

                                    @foreach ($article->ArticleAuthors as $author)
                                        <span class="bg-gray-100 px-3 py-1 rounded-full text-sm">
                                            {{ $author->author_name }}
                                        </span>
                                    @endforeach

                                </div>

                                <div class="flex gap-3">

                                    <span class="bg-blue-50 text-[#162b6f] px-3 py-1 rounded-full text-sm">
                                        {{ $article->Volumes->name ?? '' }}
                                    </span>

                                    <span class="bg-green-50 text-green-700 px-3 py-1 rounded-full text-sm">
                                        {{ $article->Issues->name ?? '' }}
                                    </span>

                                </div>

                            </a>

                        @empty

                            <div class="bg-white rounded-2xl p-16 text-center">

                                <h3 class="text-2xl text-gray-500">
                                    No Active Articles Found
                                </h3>

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection
