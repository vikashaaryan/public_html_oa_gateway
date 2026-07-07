@php
    $setting = setting();
@endphp

<header class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-6 py-4">

        <div class="flex justify-between items-center">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3">

                @if ($setting && $setting->logo)
                    <img src="{{ asset($setting->logo) }}" alt="{{ $setting->title ?? 'Logo' }}"
                        class="w-12 h-12 object-contain">
                @else
                    <div
                        class="w-12 h-12 rounded-full border-2 border-gray-300 flex items-center justify-center font-bold text-[#162b6f]">
                        OA
                    </div>
                @endif

                <h1 class="font-bold text-xl text-[#162b6f] heading-font">
                    {{ $setting->title ?? 'OA-Gateway' }}
                </h1>

            </a>

            <!-- Desktop Menu -->
            <nav class="hidden md:flex gap-8 text-sm text-gray-700">

                <a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'text-[#162b6f] border-b-2 border-[#162b6f]' : 'hover:text-[#162b6f]' }}">
                    Home
                </a>

                <a href="{{ route('article') }}"
                    class="{{ request()->routeIs('article') ? 'text-[#162b6f] border-b-2 border-[#162b6f]' : 'hover:text-[#162b6f]' }}">
                    Articles
                </a>

                <a href="{{ route('gateway') }}"
                    class="{{ request()->routeIs('gateway') ? 'text-[#162b6f] border-b-2 border-[#162b6f]' : 'hover:text-[#162b6f]' }}">
                    Gateways
                </a>

                <a href="{{ route('editorial.board') }}"
                    class="{{ request()->routeIs('editorial.board') ? 'text-[#162b6f] border-b-2 border-[#162b6f]' : 'hover:text-[#162b6f]' }}">
                    Editorial Board
                </a>

                <a href="{{ route('submit.article') }}"
                    class="{{ request()->routeIs('submit.article') ? 'text-[#162b6f] border-b-2 border-[#162b6f]' : 'hover:text-[#162b6f]' }}">
                    Submit Article
                </a>

                <a href="{{ route('search') }}"
                    class="{{ request()->routeIs('search') ? 'text-[#162b6f] border-b-2 border-[#162b6f]' : 'hover:text-[#162b6f]' }}">
                    Search
                </a>

            </nav>

            <!-- Mobile Button -->
            <button id="menuBtn" class="md:hidden">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

        </div>

        <!-- Mobile Menu -->
        <nav id="mobileMenu"
            class="hidden md:hidden mt-4 bg-white border border-gray-200 rounded shadow-sm overflow-hidden">

            <a href="{{ route('home') }}"
                class="block px-5 py-3 text-sm transition-colors duration-200
        {{ request()->routeIs('home')
            ? 'bg-[#162b6f] text-white font-medium'
            : 'text-gray-700 hover:bg-gray-50 hover:text-[#162b6f]' }}">
                Home
            </a>

            <a href="{{ route('article') }}"
                class="block px-5 py-3 text-sm transition-colors duration-200 border-t border-gray-100
        {{ request()->routeIs('article')
            ? 'bg-[#162b6f] text-white font-medium'
            : 'text-gray-700 hover:bg-gray-50 hover:text-[#162b6f]' }}">
                Articles
            </a>

            <a href="{{ route('gateway') }}"
                class="block px-5 py-3 text-sm transition-colors duration-200 border-t border-gray-100
        {{ request()->routeIs('gateway')
            ? 'bg-[#162b6f] text-white font-medium'
            : 'text-gray-700 hover:bg-gray-50 hover:text-[#162b6f]' }}">
                Gateways
            </a>

            <a href="{{ route('editorial.board') }}"
                class="block px-5 py-3 text-sm transition-colors duration-200 border-t border-gray-100
        {{ request()->routeIs('editorial.board')
            ? 'bg-[#162b6f] text-white font-medium'
            : 'text-gray-700 hover:bg-gray-50 hover:text-[#162b6f]' }}">
                Editorial Board
            </a>

            <a href="{{ route('submit.article') }}"
                class="block px-5 py-3 text-sm transition-colors duration-200 border-t border-gray-100
        {{ request()->routeIs('submit.article')
            ? 'bg-[#162b6f] text-white font-medium'
            : 'text-gray-700 hover:bg-gray-50 hover:text-[#162b6f]' }}">
                Submit Article
            </a>

            <a href="{{ route('search') }}"
                class="block px-5 py-3 text-sm transition-colors duration-200 border-t border-gray-100
        {{ request()->routeIs('search')
            ? 'bg-[#162b6f] text-white font-medium'
            : 'text-gray-700 hover:bg-gray-50 hover:text-[#162b6f]' }}">
                Search
            </a>

        </nav>

    </div>
</header>

<script>
    document.getElementById('menuBtn').addEventListener('click', function() {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    });
</script>
