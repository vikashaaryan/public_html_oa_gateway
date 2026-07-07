@extends('layouts.app')

@section('title', 'Submit Research Article | Publish Academic Papers & Journals | OA-Gateway')

@section('meta_description',
'Submit your research article to OA-Gateway for peer review and publication. Publish academic papers, scholarly articles, research journals, and open access studies across multiple disciplines.')

@section('meta_keywords',
'submit article, research paper submission, academic journal submission, publish research paper, scholarly article submission, open access journal, peer review publication, academic publishing, submit manuscript, research journal')



@section('content')

<section class="bg-[#f8f8f8] min-h-screen py-14">

    <div class="max-w-7xl mx-auto px-6">

        <div class="mb-14">

            <h1 class="text-[56px] font-bold heading-font text-[#0f1f4b] mb-4">
                Editorial Board
            </h1>

            <p class="text-[18px] text-gray-600 max-w-6xl leading-10">
                Our editorial board consists of leading researchers and academics
                from around the world, ensuring the highest standards of peer
                review and scholarly integrity.
            </p>

        </div>

        <div class="mb-8">

            <h2 class="text-[28px] font-bold heading-font text-[#0f1f4b] mb-3">
                Editor
            </h2>

            <div class="border-b border-gray-300"></div>

        </div>

        <div class="grid lg:grid-cols-2 gap-8">

            @foreach($authors as $author)

            <div class="bg-white border rounded-xl p-6">

                <div class="flex gap-6">

                    <img
                        src="{{ asset($author->image) }}"
                        class="w-52 h-52 object-cover rounded-lg"
                        alt="{{ $author->name }}"
                    >

                    <div>

                        <h3 class="text-[24px] font-bold heading-font text-[#0f1f4b] mb-1">
                            {{ $author->name }}
                        </h3>

                        <p class="text-gray-600 mb-5">
                           {{ $author->Jobs->name ?? '' }}
                        </p>

                        <div class="space-y-3 text-gray-600">

                            <p>
                                🎓 {{ $author->Universities->name ?? '' }}

                            </p>

                            <p>
                                📍 {{ $author->Locations->name ?? '' }}

                            </p>

                        </div>

                        <a href="{{ route('editorial.profile',$author->slug_url) }}"
                           class="inline-block mt-6 text-[#1d3f91] hover:underline">
                            View profile →
                        </a>

                    </div>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</section>

@endsection