@extends('layouts.app')

@section('title', 'Submit Research Article | Publish Academic Papers & Journals | OA-Gateway')

@section('meta_description',
'Submit your research article to OA-Gateway for peer review and publication. Publish academic papers, scholarly articles, research journals, and open access studies across multiple disciplines.')

@section('meta_keywords',
'submit article, research paper submission, academic journal submission, publish research paper, scholarly article submission, open access journal, peer review publication, academic publishing, submit manuscript, research journal')


@section('content')

<section class="bg-[#f8f8f8] py-12">

    <div class="max-w-7xl mx-auto px-6">

        <!-- Heading -->
        <div class="mb-10">

            <h1 class="text-5xl font-bold text-[#0f1f4b] mb-4">
                Article Submission
            </h1>

            <p class="text-gray-600 max-w-4xl">
                Thank you for your interest in submitting your research to the
                International Journal of Advanced Research.
            </p>

        </div>

        <!-- Success Message -->

        @if(session('success'))

        <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-lg">

            {{ session('success') }}

        </div>

        @endif

        <!-- Validation Errors -->

        @if($errors->any())

        <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-lg">

            <ul class="list-disc ml-5">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

        @endif

     <!-- Submission Process -->
<div class="mb-14">
    
    <h2 class="text-4xl font-bold text-[#0f1f4b] mb-4">
        Submission Process
    </h2>

    <div class="border-t border-gray-200 pt-8">

        <div class="grid md:grid-cols-2 gap-6">

            <!-- Prepare Manuscript -->
            <div class="bg-white border border-gray-200 rounded-xl p-8 flex gap-5 hover:shadow-md transition">

                <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-7 h-7 text-[#1d3f91]"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 12h6m-6 4h6M8 4h8a2 2 0 012 2v12a2 2 0 01-2 2H8a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                    </svg>
                </div>

                <div>
                    <h3 class="text-2xl font-bold text-[#0f1f4b] mb-3">
                        Prepare Your Manuscript
                    </h3>

                    <p class="text-gray-600 leading-relaxed">
                        Format your manuscript according to our guidelines.
                        Include all necessary sections, figures, and references
                        in the appropriate style.
                    </p>
                </div>

            </div>

            <!-- Peer Review -->
            <div class="bg-white border border-gray-200 rounded-xl p-8 flex gap-5 hover:shadow-md transition">

                <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-7 h-7 text-[#1d3f91]"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M17 20h5V4H2v16h5m10 0v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2m12 0H7m10-11a3 3 0 11-6 0 3 3 0 016 0zm-8 0a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>

                <div>
                    <h3 class="text-2xl font-bold text-[#0f1f4b] mb-3">
                        Peer Review
                    </h3>

                    <p class="text-gray-600 leading-relaxed">
                        Your manuscript will undergo rigorous peer review by at
                        least two independent experts in your field of research.
                    </p>
                </div>

            </div>

            <!-- Review Timeline -->
            <div class="bg-white border border-gray-200 rounded-xl p-8 flex gap-5 hover:shadow-md transition">

                <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-7 h-7 text-[#1d3f91]"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <div>
                    <h3 class="text-2xl font-bold text-[#0f1f4b] mb-3">
                        Review Timeline
                    </h3>

                    <div class="text-gray-600 leading-8">
                        <div>Initial screening: 1-2 weeks</div>
                        <div>Peer review: 4-6 weeks</div>
                        <div>Revision (if required): 2-4 weeks</div>
                        <div>Final decision: 1-2 weeks</div>
                    </div>
                </div>

            </div>

            <!-- Publication -->
            <div class="bg-white border border-gray-200 rounded-xl p-8 flex gap-5 hover:shadow-md transition">

                <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-7 h-7 text-[#1d3f91]"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <div>
                    <h3 class="text-2xl font-bold text-[#0f1f4b] mb-3">
                        Publication
                    </h3>

                    <p class="text-gray-600 leading-relaxed">
                        Upon acceptance, your article will be prepared for
                        publication. You will receive proofs for final review
                        before online publication.
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>

        <!-- Form -->

        <h2 class="text-2xl font-bold text-[#0f1f4b] mb-6">
            Submit Your Manuscript
        </h2>

        <form
            action="{{ route('submit.article.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="bg-white border rounded-lg p-8"
        >

            @csrf

            <!-- Name -->

            <div class="grid md:grid-cols-2 gap-6 mb-6">

                <div>

                    <label class="block text-sm font-medium mb-2">
                        First Name *
                    </label>

                    <input
                        type="text"
                        name="first_name"
                        value="{{ old('first_name') }}"
                        class="w-full border rounded-lg px-4 py-3"
                        required
                    >

                </div>

                <div>

                    <label class="block text-sm font-medium mb-2">
                        Last Name *
                    </label>

                    <input
                        type="text"
                        name="last_name"
                        value="{{ old('last_name') }}"
                        class="w-full border rounded-lg px-4 py-3"
                        required
                    >

                </div>

            </div>

            <!-- Email -->

            <div class="mb-6">

                <label class="block text-sm font-medium mb-2">
                    Email Address *
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full border rounded-lg px-4 py-3"
                    required
                >

            </div>

            <!-- Institution -->

            <div class="mb-6">

                <label class="block text-sm font-medium mb-2">
                    Institution / University *
                </label>

                <input
                    type="text"
                    name="institution"
                    value="{{ old('institution') }}"
                    class="w-full border rounded-lg px-4 py-3"
                    required
                >

            </div>

            <!-- Title -->

            <div class="mb-6">

                <label class="block text-sm font-medium mb-2">
                    Manuscript Title *
                </label>

                <input
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    class="w-full border rounded-lg px-4 py-3"
                    required
                >

            </div>

            <!-- Subject -->

            <div class="mb-6">

                <label class="block text-sm font-medium mb-2">
                    Subject Area *
                </label>

                <select
                    name="subject"
                    class="w-full border rounded-lg px-4 py-3"
                    required
                >

                    <option value="">
                        Select Subject Area
                    </option>

                    @foreach($subjects as $subject)

                        <option
                            value="{{ $subject->id }}"
                            {{ old('subject') == $subject->id ? 'selected' : '' }}
                        >
                            {{ $subject->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <!-- Abstract -->

            <div class="mb-6">

                <label class="block text-sm font-medium mb-2">
                    Abstract *
                </label>

                <textarea
                    name="abstract"
                    rows="7"
                    class="w-full border rounded-lg px-4 py-3"
                    required
                >{{ old('abstract') }}</textarea>

            </div>

            <!-- Document -->

            <div class="mb-6">

                <label class="block text-sm font-medium mb-2">
                    Upload Manuscript
                </label>

                <div class="border-2 border-dashed rounded-lg p-8">

                    <input
                        type="file"
                        name="document"
                        accept=".pdf,.doc,.docx"
                        class="w-full"
                    >

                </div>

                <p class="text-xs text-gray-500 mt-2">
                    Accepted formats: PDF, DOC, DOCX (Max 10MB)
                </p>

            </div>

            <!-- Comments -->

            <div class="mb-8">

                <label class="block text-sm font-medium mb-2">
                    Comments To Editor
                </label>

                <textarea
                    name="comments"
                    rows="5"
                    class="w-full border rounded-lg px-4 py-3"
                >{{ old('comments') }}</textarea>

            </div>

            <!-- Agreement -->

            <div class="space-y-4 mb-8">

                <label class="flex items-start gap-3">

                    <input type="checkbox" required>

                    <span class="text-sm text-gray-600">
                        I confirm that this manuscript has not been published elsewhere.
                    </span>

                </label>

                <label class="flex items-start gap-3">

                    <input type="checkbox" required>

                    <span class="text-sm text-gray-600">
                        I agree to the journal's publication policies.
                    </span>

                </label>

            </div>

            <!-- Submit -->

            <div class="text-right">

                <button
                    type="submit"
                    class="bg-[#1d3f91] hover:bg-[#16357d] text-white px-8 py-3 rounded-lg font-medium"
                >
                    Submit Manuscript
                </button>

            </div>

        </form>
          <!-- FAQ -->
        <div class="mt-16">

            <h2 class="text-2xl font-bold text-[#0f1f4b] mb-6">
                Frequently Asked Questions
            </h2>

            <div class="bg-white border rounded-lg divide-y">

                <details class="p-5">
                    <summary class="cursor-pointer font-medium">
                        How does OA-Gateway handle the peer review process?
                    </summary>
                    <p class="mt-3 text-gray-600">
                        All manuscripts undergo a rigorous peer review process.
                    </p>
                </details>

                <details class="p-5">
                    <summary class="cursor-pointer font-medium">
                        Does OA-Gateway charge publication fees?
                    </summary>
                    <p class="mt-3 text-gray-600">
                        Publication fees depend on the journal policy.
                    </p>
                </details>

                <details class="p-5">
                    <summary class="cursor-pointer font-medium">
                        Do you collaborate with international institutions?
                    </summary>
                    <p class="mt-3 text-gray-600">
                        Yes, we collaborate with institutions worldwide.
                    </p>
                </details>

            </div>

        </div>

    </div>
    

</section>

@endsection