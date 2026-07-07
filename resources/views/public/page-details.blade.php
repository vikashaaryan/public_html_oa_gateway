@extends('layouts.app')

@section('title', $page->name)

@section('content')

<section class="bg-[#f5f5f5] py-14 min-h-screen">

    <div class="max-w-7xl mx-auto px-6">

        <!-- Return Home -->
        <div class="mb-8">
            <a href="{{ route('home') }}"
               class="text-[#44506a] hover:text-[#1d3f91] transition">
                Return Home
            </a>
        </div>

        <!-- Blue Header -->
        <div class="bg-[#1d3276] rounded-xl px-10 py-10 mb-10 shadow-sm">

            <h1 class="text-white text-3xl font-bold heading-font">
                {{ $page->name }}
            </h1>

        </div>

        <!-- Content Card -->
        <div class="bg-white border border-gray-200 rounded-xl p-10 shadow-sm">

            <div class="prose prose-lg max-w-none
                        prose-headings:text-[#0f1f4b]
                        prose-headings:font-bold
                        prose-p:text-gray-700
                        prose-li:text-gray-700">

                {!! $page->description !!}

            </div>

        </div>

    </div>

</section>

@endsection