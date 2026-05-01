@extends('layouts.auth')

@section('title', 'Register')

@section('auth-content')
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-white mb-2">Create Account</h2>
        <p class="text-gray-400 text-sm">Sign up to start generating receipts</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="username" class="block text-sm font-medium text-gray-300 mb-2">
                <i class="fa-solid fa-user text-primary-400 mr-1"></i> Username
            </label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus
                class="input-modern w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-primary-400"
                placeholder="Choose a username">
            @error('username')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                <i class="fa-solid fa-envelope text-primary-400 mr-1"></i> Email
            </label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                class="input-modern w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-primary-400"
                placeholder="Enter your email">
            @error('email')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                <i class="fa-solid fa-lock text-primary-400 mr-1"></i> Password
            </label>
            <input type="password" id="password" name="password" required
                class="input-modern w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-primary-400"
                placeholder="Create a password (min 6 characters)">
            @error('password')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">
                <i class="fa-solid fa-shield-check text-primary-400 mr-1"></i> Confirm Password
            </label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                class="input-modern w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-primary-400"
                placeholder="Confirm your password">
        </div>

        <button type="submit" class="btn-gradient w-full py-3 rounded-xl text-white font-semibold text-sm tracking-wide shadow-lg">
            <i class="fa-solid fa-user-plus mr-2"></i> Create Account
        </button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-gray-400 text-sm">
            Already have an account?
            <a href="{{ route('login') }}" class="text-primary-400 hover:text-primary-300 font-medium transition">Sign in</a>
        </p>
    </div>
@endsection
