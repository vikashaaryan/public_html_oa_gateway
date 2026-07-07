@extends('layouts.app')

@section('title', $topic->meta_title ?? $topic->name)

@section('meta_description', $topic->meta_description)

@section('content')

    <section class="bg-[#f7f7f7] min-h-screen py-12">

        <div class="max-w-7xl mx-auto px-6">

            <div class="bg-[#162b6f] rounded-2xl p-10 lg:p-14 shadow-lg mb-10">

                <h1 class="text-4xl lg:text-5xl font-bold text-white">
                    {{ $topic->name }}
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


                        <a href="{{ route('topic.articles', $topic->slug_url) }}"
                            class="pb-4 font-medium text-[#162b6f] border-b-2 border-transparent hover:border-[#162b6f] transition">
                            View Articles 
                        </a>

                    </div>

                </div>

                <!-- ABOUT -->

                <div x-show="tab=='about'">

                    <div class="bg-white rounded-2xl border p-8 shadow-sm">

                        <div class="prose max-w-none">
                            {!! $topic->description !!}
                        </div>

                        @if ($topic->meta_keywords)

                            <div class="mt-10">

                                <h3 class="font-semibold text-[#162b6f] mb-4">
                                    Keywords
                                </h3>

                                <div class="flex flex-wrap gap-2">

                                    @foreach (explode(',', $topic->meta_keywords) as $keyword)
                                        <span class="px-3 py-1 bg-blue-50 text-[#162b6f] rounded-full text-sm">
                                            {{ trim($keyword) }}
                                        </span>
                                    @endforeach

                                </div>

                            </div>

                        @endif

                    </div>

                </div>

                

            </div>

        </div>

    </section>

@endsection
