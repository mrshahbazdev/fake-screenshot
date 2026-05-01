@extends('layouts.auth')

@section('title', 'Login')

@section('auth-content')
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-white mb-2">Welcome Back</h2>
        <p class="text-gray-400 text-sm">Enter your credentials to access your account</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="username" class="block text-sm font-medium text-gray-300 mb-2">
                <i class="fa-solid fa-user text-primary-400 mr-1"></i> Username
            </label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus
                class="input-modern w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-primary-400"
                placeholder="Enter your username">
            @error('username')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                <i class="fa-solid fa-lock text-primary-400 mr-1"></i> Password
            </label>
            <div class="relative">
                <input type="password" id="password" name="password" required
                    class="input-modern w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-primary-400"
                    placeholder="Enter your password">
                <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300 transition">
                    <i class="fa-solid fa-eye" id="toggleIcon"></i>
                </button>
            </div>
            @error('password')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-gradient w-full py-3 rounded-xl text-white font-semibold text-sm tracking-wide shadow-lg">
            <i class="fa-solid fa-right-to-bracket mr-2"></i> Sign In
        </button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-gray-400 text-sm">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-primary-400 hover:text-primary-300 font-medium transition">Create one</a>
        </p>
    </div>
@endsection

@push('scripts')
<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        if (input.type === 'password') { input.type = 'text'; icon.classList.replace('fa-eye', 'fa-eye-slash'); }
        else { input.type = 'password'; icon.classList.replace('fa-eye-slash', 'fa-eye'); }
    }
</script>
@endpush
