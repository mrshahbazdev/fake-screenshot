@extends('layouts.auth')

@section('title', 'Activate Subscription')

@section('auth-content')
    <div class="text-center mb-8">
        <div class="w-16 h-16 rounded-2xl bg-accent-500/20 flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-crown text-accent-400 text-2xl animate-float"></i>
        </div>
        <h2 class="text-2xl font-bold text-white mb-2">Activate Subscription</h2>
        <p class="text-gray-400 text-sm">Enter the number of days to access all templates</p>
    </div>

    <form method="POST" action="{{ route('subscription.store') }}" class="space-y-5">
        @csrf

        <div>
            <label for="days" class="block text-sm font-medium text-gray-300 mb-2">
                <i class="fa-solid fa-calendar-days text-accent-400 mr-1"></i> Subscription Duration
            </label>
            <input type="number" id="days" name="days" min="1" max="365" required
                class="input-modern w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-accent-400"
                placeholder="Number of days (e.g., 30)">
            @error('days')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Quick select --}}
        <div class="grid grid-cols-3 gap-3">
            <button type="button" onclick="document.getElementById('days').value=7"
                class="p-3 rounded-xl glass hover:bg-white/10 transition text-center group">
                <span class="block text-lg font-bold text-white group-hover:text-primary-400 transition">7</span>
                <span class="text-xs text-gray-500">days</span>
            </button>
            <button type="button" onclick="document.getElementById('days').value=30"
                class="p-3 rounded-xl glass hover:bg-white/10 transition text-center group">
                <span class="block text-lg font-bold text-white group-hover:text-primary-400 transition">30</span>
                <span class="text-xs text-gray-500">days</span>
            </button>
            <button type="button" onclick="document.getElementById('days').value=365"
                class="p-3 rounded-xl glass hover:bg-white/10 transition text-center group">
                <span class="block text-lg font-bold text-white group-hover:text-primary-400 transition">365</span>
                <span class="text-xs text-gray-500">days</span>
            </button>
        </div>

        <button type="submit" class="btn-gradient w-full py-3 rounded-xl text-white font-semibold text-sm tracking-wide shadow-lg">
            <i class="fa-solid fa-bolt mr-2"></i> Activate Subscription
        </button>
    </form>

    <div class="mt-6 text-center">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-gray-500 hover:text-gray-300 text-sm transition">
                <i class="fa-solid fa-right-from-bracket mr-1"></i> Logout
            </button>
        </form>
    </div>
@endsection
