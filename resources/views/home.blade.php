@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<link href="{{ asset('assets/css/main.fc9cb7b7.css') }}" rel="stylesheet">
<style>
    .sidebar-scroll::-webkit-scrollbar { width: 4px; }
    .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
    .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
    .mobile-view-wrapper { width: 100%; max-height: calc(100vh - 120px); overflow-y: auto; overflow-x: auto; }
    .mobile-view-wrapper::-webkit-scrollbar { width: 6px; }
    .mobile-view-wrapper::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
    .page-item { transition: all 0.2s; }
    .page-item:hover { transform: translateX(4px); }
    .page-item.active { background: rgba(14,165,233,0.15); border-color: rgba(14,165,233,0.4); }
    .grid-overlay { display: none; position: fixed; inset: 0; z-index: 50; background: rgba(0,0,0,0.85); backdrop-filter: blur(10px); }
    .grid-overlay.active { display: flex; }
</style>
@endpush

@section('content')
<div class="min-h-screen flex">
    {{-- Left Sidebar --}}
    <aside class="w-72 flex-shrink-0 glass-dark border-r border-white/5 flex flex-col h-screen sticky top-0">
        {{-- Logo & User --}}
        <div class="p-5 border-b border-white/5">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl btn-gradient flex items-center justify-center">
                    <i class="fa-solid fa-receipt text-white"></i>
                </div>
                <div>
                    <h3 class="font-bold text-white text-sm">Quick Receipt</h3>
                    <span class="text-xs text-gray-500">V.4</span>
                </div>
            </div>
            <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5">
                <div class="w-8 h-8 rounded-full bg-primary-500/20 flex items-center justify-center">
                    <i class="fa-solid fa-user text-primary-400 text-xs"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->username }}</p>
                    <p class="text-xs text-gray-500">Active until {{ auth()->user()->subscription_end?->format('M d, Y') ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <div class="p-4">
            <button id="listAllBtn" class="w-full py-2.5 px-4 rounded-xl bg-accent-500/10 border border-accent-500/20 text-accent-400 text-sm font-medium hover:bg-accent-500/20 transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-grid-2"></i> List All Pages
            </button>
        </div>

        {{-- Page List --}}
        <div class="flex-1 overflow-y-auto sidebar-scroll px-3 pb-4">
            <div class="space-y-1">
                @foreach($allPages as $p)
                <a href="{{ route('home.index', $p->name) }}"
                    class="page-item flex items-center gap-3 px-3 py-2.5 rounded-xl border border-transparent {{ $currentPage === $p->name ? 'active' : 'hover:bg-white/5' }} transition">
                    @if($p->thumbnail)
                        <img src="{{ asset('assets/media/' . $p->thumbnail) }}" alt="" class="w-8 h-8 rounded-lg object-cover flex-shrink-0">
                    @else
                        <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-file text-gray-600 text-xs"></i>
                        </div>
                    @endif
                    <span class="text-sm {{ $currentPage === $p->name ? 'text-primary-400 font-medium' : 'text-gray-400' }} truncate">
                        {{ $p->name }}
                    </span>
                    @if($currentPage === $p->name)
                        <i class="fa-solid fa-chevron-right text-primary-400 text-xs ml-auto"></i>
                    @endif
                </a>
                @endforeach
            </div>
        </div>

        {{-- Bottom Actions --}}
        <div class="p-4 border-t border-white/5 space-y-2">
            <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/5 transition text-gray-400 text-sm">
                <i class="fa-solid fa-users"></i> All Users
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-red-500/10 transition text-gray-400 hover:text-red-400 text-sm">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 flex flex-col min-h-screen">
        {{-- Top Bar --}}
        <header class="h-16 flex items-center justify-between px-6 border-b border-white/5 glass-dark sticky top-0 z-10">
            <div class="flex items-center gap-4">
                <h2 class="text-lg font-semibold text-white">PREVIEW</h2>
                <span class="px-3 py-1 rounded-full bg-primary-500/10 text-primary-400 text-xs font-medium">{{ $currentPage }}</span>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3 glass rounded-xl px-4 py-2">
                    <button id="screenshotBtn" class="btn-gradient px-4 py-1.5 rounded-lg text-white text-xs font-medium flex items-center gap-2">
                        <i class="fa-solid fa-camera"></i> Screenshot
                    </button>
                    <span class="text-xs text-gray-400" id="sliderValue">137%</span>
                    <input type="range" min="1" max="3700" value="137" class="w-32 h-1 accent-primary-500" id="dimensionSlider">
                </div>
            </div>
        </header>

        {{-- Preview Area --}}
        <div class="flex-1 p-6 flex">
            {{-- Mobile Preview --}}
            <div class="flex-1">
                <div class="mobile-view-wrapper bg-gray-900/50 rounded-2xl p-4 border border-white/5">
                    <div class="artboard" id="artboard">
                        <foreignobject>
                            {!! $pageData->data !!}
                        </foreignobject>
                    </div>
                </div>
            </div>

            {{-- Controls Panel --}}
            @if($pageData->sidebar)
            <div class="w-80 flex-shrink-0 ml-6 glass-dark rounded-2xl p-5 border border-white/5 h-fit max-h-[calc(100vh-120px)] overflow-y-auto sidebar-scroll sticky top-20">
                <h3 class="text-sm font-semibold text-white mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-primary-400"></i> CONTROLS
                </h3>
                <div id="controlsArea">
                    {!! $pageData->sidebar !!}
                </div>
            </div>
            @endif
        </div>
    </main>
</div>

{{-- Grid Overlay --}}
<div class="grid-overlay" id="gridOverlay">
    <div class="w-full h-full flex flex-col p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-white">All Templates</h2>
            <button id="closeGrid" class="w-10 h-10 rounded-xl glass flex items-center justify-center text-gray-400 hover:text-white transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($allPages as $p)
                <a href="{{ route('home.index', $p->name) }}" class="glass rounded-2xl p-3 hover:bg-white/10 transition group text-center">
                    @if($p->thumbnail)
                        <img src="{{ asset('assets/media/' . $p->thumbnail) }}" alt="" class="w-full h-32 rounded-xl object-cover mb-2 group-hover:scale-105 transition">
                    @else
                        <div class="w-full h-32 rounded-xl bg-white/5 flex items-center justify-center mb-2">
                            <i class="fa-solid fa-file text-gray-600 text-3xl"></i>
                        </div>
                    @endif
                    <p class="text-xs text-gray-400 group-hover:text-white transition truncate">{{ $p->name }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{!! $pageData->script ?? '' !!}
<script src="{{ asset('assets/js/main.20648ec0.js') }}"></script>
<script>
    // Slider
    const slider = document.getElementById('dimensionSlider');
    const sliderVal = document.getElementById('sliderValue');
    const svgEl = document.getElementById('mySvg');

    if (slider && svgEl) {
        svgEl.setAttribute('width', slider.value + '%');
        slider.addEventListener('input', function() {
            svgEl.setAttribute('width', this.value + '%');
            sliderVal.textContent = this.value + '%';
        });
    }

    // Screenshot
    document.getElementById('screenshotBtn').addEventListener('click', function() {
        if (svgEl) {
            const serializer = new XMLSerializer();
            const svgString = serializer.serializeToString(svgEl);
            const svgDataUrl = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(svgString);
            const img = new Image();
            const canvas = document.createElement('canvas');
            const svgSize = svgEl.getBoundingClientRect();
            canvas.width = svgSize.width;
            canvas.height = svgSize.height;
            const ctx = canvas.getContext('2d');
            img.onload = () => {
                ctx.drawImage(img, 0, 0);
                const link = document.createElement('a');
                link.download = 'receipt-{{ $currentPage }}.jpg';
                link.href = canvas.toDataURL('image/jpeg');
                link.click();
            };
            img.src = svgDataUrl;
        } else {
            html2canvas(document.getElementById('artboard')).then(canvas => {
                const link = document.createElement('a');
                link.download = 'receipt-{{ $currentPage }}.jpg';
                link.href = canvas.toDataURL('image/jpeg');
                link.click();
            });
        }
    });

    // Grid overlay
    document.getElementById('listAllBtn').addEventListener('click', () => document.getElementById('gridOverlay').classList.add('active'));
    document.getElementById('closeGrid').addEventListener('click', () => document.getElementById('gridOverlay').classList.remove('active'));
    document.getElementById('gridOverlay').addEventListener('click', (e) => { if (e.target === e.currentTarget) e.currentTarget.classList.remove('active'); });

    // Auto-scroll to active page in sidebar
    document.addEventListener('DOMContentLoaded', function() {
        const active = document.querySelector('.page-item.active');
        if (active) active.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });
</script>
@endpush
