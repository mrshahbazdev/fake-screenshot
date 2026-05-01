@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    {{-- Background decoration --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-primary-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-accent-500/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-primary-600/5 rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl btn-gradient flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                    <i class="fa-solid fa-receipt text-white text-xl"></i>
                </div>
                <span class="text-2xl font-bold gradient-text">Quick Receipt</span>
            </a>
        </div>

        {{-- Card --}}
        <div class="glass rounded-3xl p-8 shadow-2xl">
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-lg"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('auth-content')
        </div>
    </div>
</div>
@endsection
