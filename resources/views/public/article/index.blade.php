@extends('layouts.app')

@section('title', 'Research Articles | Academic Journals & Scholarly Publications | OA-Gateway')

@section('meta_description',
'Browse peer-reviewed research articles, academic journals, scholarly publications, and open access papers across multiple disciplines on OA-Gateway. Discover high-quality research from universities and researchers worldwide.')

@section('meta_keywords',
'research articles, academic journals, scholarly publications, open access journals, peer reviewed articles, scientific papers, academic research, journal publications, university research, research database, OA-Gateway articles')



@section('content')

<section class="bg-[#f7f7f7] min-h-screen py-16">
<div class="max-w-7xl mx-auto px-6">

    <div class="grid lg:grid-cols-3 gap-10">

        <!-- LEFT SIDE -->
        <div class="lg:col-span-2">

            <div class="mb-10">
                <h1 class="text-4xl font-bold heading-font text-[#0f1f4b] mb-4">
                    Articles
                </h1>

                <div class="border-b border-gray-300"></div>
            </div>

            <!-- Empty State -->
            <div class="h-[350px] flex items-center justify-center">

                <p class="text-2xl text-gray-300 heading-font">
                    No Articles Found
                </p>

            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-between mt-10">

                <button
                    class="bg-gray-200 text-white px-6 py-3 rounded-lg text-2xl font-semibold cursor-not-allowed">
                    Previous
                </button>

                <p class="text-2xl text-black">
                    Page 1 of 1
                </p>

                <button
                    class="bg-gray-200 text-white px-8 py-3 rounded-lg text-2xl font-semibold cursor-not-allowed">
                    Next
                </button>

            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div>

            <div class="mb-10">
                <h2 class="text-3xl font-bold heading-font text-[#0f1f4b] mb-4">
                    Archives
                </h2>

                <div class="border-b border-gray-300"></div>
            </div>

            <div class="space-y-4">

                @forelse($issues as $issue)

                    <a href="{{ route('show.article', $issue->id) }}"
                       class="block bg-white border rounded-2xl p-8 shadow-md hover:shadow-xl transition">

                        <h3 class="text-3xl heading-font text-[#1a1a1a]">

                            {{ $issue->Volume->name ?? 'Volume' }}
                            →
                            {{ $issue->name }}

                        </h3>

                    </a>

                @empty

                    <div class="bg-white border rounded-2xl p-8 shadow-md">

                        <p class="text-gray-500">
                            No Archive Found
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

</section>

@endsection
