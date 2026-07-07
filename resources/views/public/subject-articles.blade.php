@extends('layouts.app')

@section('title', $subject->name.' Articles')

@section('content')

<section class="bg-[#f7f7f7] min-h-screen py-16">

    <div class="max-w-7xl mx-auto px-6">

        <div class="mb-10">

            <h1 class="text-5xl font-bold text-[#0f1f4b] mb-3">
                {{ $subject->name }}
            </h1>

            <p class="text-gray-600">
                Research Articles in {{ $subject->name }}
            </p>

            <div class="border-b mt-5"></div>

        </div>

        @if($articles->count())

            <div class="space-y-6">

                @foreach($articles as $item)

                    @php
                        $article = $item->Article;
                    @endphp

                    @if($article)

                    <div class="bg-white rounded-xl border p-6 shadow-sm hover:shadow-md transition">

                        <h2 class="text-2xl font-bold text-[#162b6f] mb-3">
                            {{ $article->title }}
                        </h2>

                        <div class="flex flex-wrap gap-4 text-sm text-gray-500 mb-4">

                            <span>
                                Volume:
                                {{ $article->Volumes->name ?? 'N/A' }}
                            </span>

                            <span>
                                Issue:
                                {{ $article->Issues->name ?? 'N/A' }}
                            </span>

                            <span>
                                {{ $article->publish_date }}
                            </span>

                        </div>

                        @if($article->ArticleAuthors->count())

                            <div class="text-gray-700">

                                @foreach($article->ArticleAuthors as $author)

                                    <span>
                                        {{ $author->author_name }}
                                    </span>

                                    @if(!$loop->last)
                                        ,
                                    @endif

                                @endforeach

                            </div>

                        @endif

                    </div>

                    @endif

                @endforeach

            </div>

        @else

            <div class="text-center py-20">

                <h2 class="text-4xl font-bold text-[#0f1f4b] mb-4">
                    No Results Found
                </h2>

                <p class="text-gray-500 text-xl">
                    No articles matching your search criteria.
                </p>

            </div>

        @endif

    </div>

</section>

@endsection