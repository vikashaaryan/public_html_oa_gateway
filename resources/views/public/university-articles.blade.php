@extends('layouts.app')

@section('content')

<section class="bg-[#f7f7f7] min-h-screen py-12">

    <div class="max-w-7xl mx-auto px-6">

        <h1 class="text-4xl font-bold text-[#162b6f] mb-10">
            {{ $university->name }} Articles
        </h1>

        @forelse($articles as $article)

        <div class="bg-white rounded-2xl border p-6 mb-5 shadow-sm">

            <h2 class="text-2xl font-bold text-[#162b6f] mb-3">
                {{ $article->title }}
            </h2>

            <div class="flex flex-wrap gap-2 mb-4">

                @foreach($article->ArticleAuthors as $author)

                <span class="bg-gray-100 px-3 py-1 rounded-full text-sm">
                    {{ $author->author_name }}
                </span>

                @endforeach

            </div>

            <div class="flex gap-3">

                <span class="bg-blue-50 px-3 py-1 rounded-full text-sm">
                    {{ $article->Volumes->name ?? '' }}
                </span>

                <span class="bg-green-50 px-3 py-1 rounded-full text-sm">
                    {{ $article->Issues->name ?? '' }}
                </span>

            </div>

        </div>

        @empty

        <div class="bg-white rounded-2xl p-16 text-center">

            <h3 class="text-2xl text-gray-500">
                No Active Articles Found
            </h3>

        </div>

        @endforelse

    </div>

</section>

@endsection