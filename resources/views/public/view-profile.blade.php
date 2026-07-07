@extends('layouts.app')

@section('title', $author->name . ' | OA-Gateway')

@section('content')

    <section class="bg-[#f5f6f8] min-h-screen py-12">

        <div class="max-w-6xl mx-auto px-6">

            <a href="{{ route('editorial.board') }}"
                class="inline-flex items-center text-gray-600 hover:text-[#1f3778] text-[17px] mb-8">

                <i class="fas fa-arrow-left mr-2"></i>
                Back to Editorial Board

            </a>

            <div class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm">

                <div class="flex flex-col md:flex-row gap-8">

                    <!-- Profile Image -->
                    <div class="flex-shrink-0">

                        <img src="{{ asset($author->image) }}" alt="{{ $author->name }}"
                            class="w-[190px] h-[190px] rounded-lg object-cover border">

                    </div>

                    <!-- Profile Info -->
                    <div class="flex-1">

                        <h1 class="text-[35px] leading-tight font-bold text-[#0f172a] font-serif">
                            {{ $author->name }}
                        </h1>

                        <!-- Job -->
                        <div class="flex items-center gap-3 mt-4">

                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-briefcase text-[#1f3778]"></i>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Position</p>
                                <p class="text-[#1f3778] text-xl font-semibold">
                                    {{ $author->Jobs->name ?? 'Editor' }}
                                </p>
                            </div>

                        </div>

                        <div class="mt-8 space-y-5">

                            <!-- University -->
                            <div class="flex items-center gap-4">

                                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-university text-green-700"></i>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">
                                        University
                                    </p>

                                    <p class="text-lg font-medium text-gray-800">
                                        {{ $author->Universities->name ?? 'N/A' }}
                                    </p>
                                </div>

                            </div>

                            <!-- Location -->
                            <div class="flex items-center gap-4">

                                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                                    <i class="fas fa-map-marker-alt text-red-600"></i>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">
                                        Location
                                    </p>

                                    <p class="text-lg font-medium text-gray-800">
                                        {{ $author->Locations->name ?? 'N/A' }}
                                    </p>
                                </div>

                            </div>

                            <!-- Email -->
                            <div class="flex items-center gap-4">

                                <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                                    <i class="fas fa-envelope text-yellow-700"></i>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">
                                        Email Address
                                    </p>

                                    <p class="text-lg font-medium text-[#1f3778]">
                                        {{ $author->email }}
                                    </p>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="mt-10 text-[19px] leading-[2] text-gray-700">
                {!! $author->about !!}
            </div>

        </div>

    </section>

@endsection
