@extends('layouts.app')

@section('title', 'All Users')

@section('content')
<div class="min-h-screen">
    {{-- Navigation --}}
    <nav class="py-6 px-6 lg:px-12 border-b border-white/5">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home.index') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl btn-gradient flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                    <i class="fa-solid fa-receipt text-white text-lg"></i>
                </div>
                <span class="text-xl font-bold gradient-text">Quick Receipt</span>
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('home.index') }}" class="px-5 py-2.5 rounded-xl glass text-gray-300 hover:text-white text-sm font-medium transition flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 rounded-xl glass text-gray-400 hover:text-red-400 text-sm transition flex items-center gap-2">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-10">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">All Users</h1>
                <p class="text-gray-400">Manage and view all registered users</p>
            </div>
            <div class="glass rounded-2xl px-5 py-3 flex items-center gap-3">
                <i class="fa-solid fa-users text-primary-400"></i>
                <div>
                    <p class="text-xl font-bold text-white">{{ $users->total() }}</p>
                    <p class="text-xs text-gray-500">Total Users</p>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="glass rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/5">
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Username</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Subscription End</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($users as $index => $user)
                        <tr class="hover:bg-white/5 transition">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $users->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-500/20 flex items-center justify-center">
                                        <span class="text-xs font-bold text-primary-400">{{ strtoupper(substr($user->username, 0, 1)) }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-white">{{ $user->username }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-400">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @if($user->subscription_status === 'active' && $user->subscription_end && \Carbon\Carbon::parse($user->subscription_end)->isFuture())
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-red-500/10 text-red-400 text-xs font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Expired
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-400">
                                {{ $user->subscription_end ? \Carbon\Carbon::parse($user->subscription_end)->format('M d, Y') : '—' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <i class="fa-solid fa-users-slash text-gray-600 text-3xl mb-3"></i>
                                <p class="text-gray-500">No users found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($users->hasPages())
            <div class="px-6 py-4 border-t border-white/5 flex items-center justify-between">
                <p class="text-sm text-gray-500">
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                </p>
                <div class="flex items-center gap-2">
                    @if($users->onFirstPage())
                        <span class="px-3 py-2 rounded-lg bg-white/5 text-gray-600 text-sm cursor-not-allowed">Previous</span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" class="px-3 py-2 rounded-lg glass text-gray-300 hover:text-white text-sm transition">Previous</a>
                    @endif

                    @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        @if($page == $users->currentPage())
                            <span class="px-3 py-2 rounded-lg btn-gradient text-white text-sm font-medium">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-2 rounded-lg glass text-gray-400 hover:text-white text-sm transition">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" class="px-3 py-2 rounded-lg glass text-gray-300 hover:text-white text-sm transition">Next</a>
                    @else
                        <span class="px-3 py-2 rounded-lg bg-white/5 text-gray-600 text-sm cursor-not-allowed">Next</span>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
