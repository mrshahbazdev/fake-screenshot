<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function show(): View
    {
        return view('subscription.subscribe');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'days' => 'required|integer|min:1|max:365',
        ]);

        $user = $request->user();
        $endDate = now()->addDays($validated['days']);

        $user->update([
            'subscription_status' => 'active',
            'subscription_end' => $endDate,
        ]);

        Subscription::create([
            'user_id' => $user->id,
            'start_date' => now()->toDateString(),
            'end_date' => $endDate->toDateString(),
        ]);

        return redirect()->route('login')
            ->with('success', 'Subscription activated for ' . $validated['days'] . ' days!');
    }
}
