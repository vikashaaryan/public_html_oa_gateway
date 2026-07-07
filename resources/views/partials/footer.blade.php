@php
    $setting = setting();
@endphp

<footer class="footer-bg text-white pt-16 pb-8">

    <div class="max-w-7xl mx-auto px-6">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

            {{-- Dynamic Footer Categories --}}
            @foreach($footerCategories as $category)

                <div>

                    <h3 class="text-xl font-bold heading-font mb-5">
                        {{ $category->name }}
                    </h3>

                    <ul class="space-y-3 text-gray-300 text-sm">

                        @foreach($category->Links as $link)

                            @php

                                $url = $link->footer_link;

                                // React Hash Routes → Laravel Routes

                                if(str_contains($url, '#about_us')){
                                    $url = route('about');
                                }

                                elseif(str_contains($url, '#gateways')){
                                    $url = route('gateway');
                                }

                                elseif(str_contains($url, '#editorial')){
                                    $url = route('editorial-board');
                                }

                                elseif(str_contains($url, '#faq')){
                                    $url = route('faq');
                                }

                                elseif(str_contains($url, '#contact')){
                                    $url = route('contact');
                                }

                                elseif(str_contains($url, '#submit_article')){
                                    $url = route('submit.article');
                                }

                                elseif(str_contains($url, '#search')){
                                    $url = route('search');
                                }

                            @endphp

                            <li>

                                <a
                                    href="{{ $url }}"
                                    class="hover:text-white transition duration-200"
                                    @if(Str::startsWith($url,['http://','https://']))
                                        target="_blank"
                                    @endif
                                >
                                    {{ $link->name }}
                                </a>

                            </li>

                        @endforeach

                    </ul>

                </div>

            @endforeach

            {{-- Contact & Social --}}
            <div>

                <h3 class="text-xl font-bold heading-font mb-5">
                    Connect With Us
                </h3>

                @if(!empty($setting->email))

                    <p class="text-gray-300 text-sm mb-4">
                        {{ $setting->email }}
                    </p>

                @endif

                @if(isset($socialLinks) && $socialLinks->count())

                    <div class="flex flex-wrap gap-4">

                        @foreach($socialLinks as $social)

                            <a
                                href="{{ $social->link }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="hover:scale-110 transition duration-200"
                            >

                                <img
                                    src="{{ asset($social->image) }}"
                                    alt="{{ $social->name }}"
                                    class="w-9 h-9 object-contain"
                                >

                            </a>

                        @endforeach

                    </div>

                @endif

            </div>

        </div>

        {{-- Copyright --}}
        <div class="border-t border-gray-700 mt-12 pt-6 text-center text-gray-400 text-sm">

            © {{ date('Y') }}
            {{ $setting->title ?? 'OA-Gateway' }}.
            All Rights Reserved.

        </div>

    </div>

</footer>