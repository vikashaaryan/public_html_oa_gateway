@extends('layouts.app')

@section('title', $subject->meta_title ?? $subject->name)

@section('meta_description', $subject->meta_description)

@section('content')

<section class="bg-[#f7f7f7] min-h-screen py-10">

    <div class="max-w-7xl mx-auto px-6">

        <!-- SUBJECT HEADER -->
        <div class="bg-[#162b6f] rounded-lg px-8 py-8 shadow-md mb-8">

            <h1 class="text-4xl font-bold text-white">
                {{ $subject->name }}
            </h1>

        </div>

        <!-- TABS -->
        <div class="border-b border-gray-300 mb-6">

            <div class="flex gap-10">

                <button
                    class="pb-3 text-[#162b6f]
                    border-b-2 border-[#162b6f]
                    font-medium">
                    About
                </button>

               <a href="{{ route('subject.articles',$subject->slug_url) }}"
   class="pb-3 text-gray-500 hover:text-[#162b6f]">
    View Articles
</a>

            </div>

        </div>

        <!-- CONTENT -->
        <div class="bg-white border rounded-lg p-8 shadow-sm">

            @if($subject->description)
                <div class="text-gray-700 leading-8 mb-8">
                    {!! nl2br(e($subject->description)) !!}
                </div>
            @endif

            @if($subject->long_description)
                <div class="prose max-w-none text-gray-700">
                    {!! $subject->long_description !!}
                </div>
            @endif

            <!-- INFO SECTION -->
            <div class="mt-10 border-t pt-8">

                <div class="grid md:grid-cols-2 gap-6">

                    <div class="bg-gray-50 p-5 rounded-lg">

                        <h3 class="font-semibold text-[#162b6f] mb-2">
                            Subject Name
                        </h3>

                        <p class="text-gray-700">
                            {{ $subject->name }}
                        </p>

                    </div>

                    <div class="bg-gray-50 p-5 rounded-lg">

                        <h3 class="font-semibold text-[#162b6f] mb-2">
                            Total Articles
                        </h3>

                        <p class="text-gray-700">
                            {{ $subject->article_count }}
                        </p>

                    </div>

                </div>

            </div>

           

            <!-- META KEYWORDS -->
            @if($subject->meta_keywords)
                <div class="mt-10">

                    <h3 class="text-xl font-bold text-[#162b6f] mb-4">
                        Keywords
                    </h3>

                    <div class="flex flex-wrap gap-2">

                        @foreach(explode(',', $subject->meta_keywords) as $keyword)

                            <span class="px-3 py-1 bg-blue-50 text-[#162b6f] rounded-full text-sm">
                                {{ trim($keyword) }}
                            </span>

                        @endforeach

                    </div>

                </div>
            @endif

        </div>

    </div>

</section>

@endsection