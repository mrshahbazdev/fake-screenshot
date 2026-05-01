@extends('layouts.app')

@section('title', 'Quick Receipt — Generate Withdrawal Receipts Instantly')

@section('content')
<div class="min-h-screen relative overflow-hidden">
    {{-- Background decoration --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-[600px] h-[600px] bg-primary-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-[600px] h-[600px] bg-accent-500/10 rounded-full blur-3xl"></div>
    </div>

    {{-- Navigation --}}
    <nav class="relative z-20 py-6 px-6 lg:px-12">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl btn-gradient flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                    <i class="fa-solid fa-receipt text-white text-lg"></i>
                </div>
                <span class="text-xl font-bold gradient-text">Quick Receipt</span>
            </a>
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('home.index') }}" class="btn-gradient px-6 py-2.5 rounded-xl text-white text-sm font-medium shadow-lg">
                        Dashboard <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl text-gray-300 hover:text-white text-sm font-medium transition hover:bg-white/5">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="btn-gradient px-6 py-2.5 rounded-xl text-white text-sm font-medium shadow-lg">
                        Get Started <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="relative z-10 pt-16 pb-32 px-6 lg:px-12">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass text-sm text-primary-300 mb-8">
                    <i class="fa-solid fa-sparkles"></i>
                    <span>Version 4.0 — Now with 50+ Templates</span>
                </div>
                <h1 class="text-5xl lg:text-6xl font-black leading-tight mb-6">
                    Generate <span class="gradient-text">Withdrawal Receipts</span> Instantly
                </h1>
                <p class="text-lg text-gray-400 mb-10 max-w-lg leading-relaxed">
                    Create professional billing screenshots with our advanced receipt generator. Choose from 50+ mobile templates, customize, and download in seconds.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="btn-gradient px-8 py-4 rounded-2xl text-white font-semibold text-base shadow-xl flex items-center gap-2">
                        <i class="fa-solid fa-rocket"></i> Start Free Trial
                    </a>
                    <a href="#features" class="px-8 py-4 rounded-2xl glass text-gray-300 hover:text-white font-medium text-base transition hover:bg-white/10 flex items-center gap-2">
                        <i class="fa-solid fa-play"></i> Learn More
                    </a>
                </div>

                {{-- Stats --}}
                <div class="mt-12 flex gap-10">
                    <div>
                        <div class="text-3xl font-bold text-white">50+</div>
                        <div class="text-sm text-gray-500">Templates</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-white">HD</div>
                        <div class="text-sm text-gray-500">Quality Export</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-white">1-Click</div>
                        <div class="text-sm text-gray-500">Screenshot</div>
                    </div>
                </div>
            </div>

            {{-- Hero visual --}}
            <div class="relative hidden lg:block">
                <div class="relative animate-float">
                    <div class="glass rounded-3xl p-6 shadow-2xl max-w-sm mx-auto">
                        <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl p-4 mb-4">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-primary-500/20 flex items-center justify-center">
                                        <i class="fa-solid fa-building-columns text-primary-400 text-xs"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-300">Bank Transfer</span>
                                </div>
                                <span class="text-xs text-emerald-400 bg-emerald-400/10 px-2 py-1 rounded-full">Successful</span>
                            </div>
                            <div class="text-center py-6">
                                <p class="text-sm text-gray-500 mb-1">Amount Withdrawn</p>
                                <p class="text-4xl font-bold text-white">$2,450.00</p>
                            </div>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between text-gray-400"><span>Date</span><span class="text-gray-300">{{ now()->format('M d, Y') }}</span></div>
                                <div class="flex justify-between text-gray-400"><span>Reference</span><span class="text-gray-300">#QR{{ rand(100000, 999999) }}</span></div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span>Quick Receipt v4.0</span>
                            <span>Template Preview</span>
                        </div>
                    </div>
                </div>
                {{-- Floating badges --}}
                <div class="absolute -top-4 -right-4 glass rounded-2xl px-4 py-3 shadow-xl animate-float" style="animation-delay: 1s">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center">
                            <i class="fa-solid fa-check text-emerald-400 text-xs"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-300">HD Export</span>
                    </div>
                </div>
                <div class="absolute -bottom-4 -left-4 glass rounded-2xl px-4 py-3 shadow-xl animate-float" style="animation-delay: 2s">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-accent-500/20 flex items-center justify-center">
                            <i class="fa-solid fa-mobile-screen text-accent-400 text-xs"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-300">50+ Templates</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features" class="relative z-10 py-24 px-6 lg:px-12">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">Powerful Features</h2>
                <p class="text-gray-400 max-w-2xl mx-auto">Everything you need to generate professional receipts quickly and efficiently</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                $features = [
                    ['icon' => 'fa-mobile-screen-button', 'color' => 'primary', 'title' => '50+ Mobile Templates', 'desc' => 'Wide variety of pre-designed receipt templates for different banks and platforms.'],
                    ['icon' => 'fa-camera', 'color' => 'accent', 'title' => 'One-Click Screenshot', 'desc' => 'Capture high-quality screenshots with a single click using advanced rendering.'],
                    ['icon' => 'fa-sliders', 'color' => 'primary', 'title' => 'Adjustable Size', 'desc' => 'Fine-tune image dimensions with an intuitive slider control for perfect output.'],
                    ['icon' => 'fa-palette', 'color' => 'accent', 'title' => 'Live Preview', 'desc' => 'See your receipt in real-time before exporting with our mobile preview panel.'],
                    ['icon' => 'fa-download', 'color' => 'primary', 'title' => 'JPG Export', 'desc' => 'Download your receipts in high-quality JPG format ready to use anywhere.'],
                    ['icon' => 'fa-shield-halved', 'color' => 'accent', 'title' => 'Subscription Access', 'desc' => 'Flexible subscription plans to keep your access active for as long as needed.'],
                ];
                @endphp
                @foreach($features as $f)
                <div class="glass rounded-2xl p-6 hover:bg-white/10 transition group">
                    <div class="w-12 h-12 rounded-xl bg-{{ $f['color'] }}-500/20 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <i class="fa-solid {{ $f['icon'] }} text-{{ $f['color'] }}-400 text-lg"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">{{ $f['title'] }}</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="relative z-10 py-24 px-6 lg:px-12">
        <div class="max-w-4xl mx-auto text-center">
            <div class="glass rounded-3xl p-12 lg:p-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">Ready to Get Started?</h2>
                <p class="text-gray-400 mb-8 max-w-xl mx-auto">Join now and start generating professional withdrawal receipts in seconds.</p>
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 btn-gradient px-10 py-4 rounded-2xl text-white font-semibold text-lg shadow-xl">
                    <i class="fa-solid fa-rocket"></i> Create Free Account
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="relative z-10 py-8 px-6 lg:px-12 border-t border-white/5">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg btn-gradient flex items-center justify-center">
                    <i class="fa-solid fa-receipt text-white text-sm"></i>
                </div>
                <span class="text-sm font-semibold gradient-text">Quick Receipt</span>
            </div>
            <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} Quick Receipt. All rights reserved.</p>
        </div>
    </footer>
</div>
@endsection
