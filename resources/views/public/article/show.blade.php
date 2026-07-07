@extends('layouts.app')

@section('title',$issue->title)

@section('content')

<section class="max-w-7xl mx-auto px-6 py-10">

    <a href="{{ route('article') }}"
       class="inline-flex items-center text-gray-600 hover:text-blue-700 mb-8">

        ← Back to Articles

    </a>

    <div class="bg-white rounded-xl border p-8 shadow-sm">

        <div class="text-gray-500 mb-4">

            {{ date('F Y',strtotime($issue->publish_date)) }}

            |

            {{ $issue->Volume?->name }}

            |

            {{ $issue->name }}

        </div>

        <h1 class="text-5xl font-bold text-[#0F172A] mb-6">
            {{ $issue->title }}
        </h1>

        <div class="prose max-w-none">
            {!! $issue->description !!}
        </div>

    </div>

    <div class="mt-16">

        <h2 class="text-4xl font-bold mb-10">
            Articles in this Issue
        </h2>

        @forelse($articles as $article)

            <div class="bg-white border rounded-xl p-8 mb-6">

                <h3 class="text-2xl font-bold mb-3">
                    {{ $article->title }}
                </h3>

                <div class="text-gray-500 mb-3">

                    Article ID :
                    {{ $article->article_id }}

                </div>

                <div class="text-gray-500 mb-3">

                    DOI :
                    {{ $article->doi }}

                </div>

                <div class="mb-4">

                    <strong>Authors:</strong>

                    @foreach($article->ArticleAuthors as $author)

                        {{ $author->author_name }}

                        @if(!$loop->last)
                            ,
                        @endif

                    @endforeach

                </div>

                <div class="mb-4 text-gray-700">

                    @if($article->ArticleContents->count())

                        {!! Str::limit(
                            strip_tags(
                                $article->ArticleContents->first()->description
                            ),
                            250
                        ) !!}

                    @endif

                </div>


            </div>

        @empty

            <div class="bg-white rounded-xl p-10 text-center">

                No Articles Found

            </div>

        @endforelse

    </div>

</section>

@endsection