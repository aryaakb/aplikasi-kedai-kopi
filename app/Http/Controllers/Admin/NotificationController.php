<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(): View
    {
        $notifications = Notification::orderBy('created_at', 'desc')->paginate(10);
        
        $stats = [
            'total' => Notification::count(),
            'active' => Notification::active()->count(),
            'maintenance' => Notification::maintenance()->count(),
            'scheduled' => Notification::where('scheduled_at', '>', now())->count(),
        ];

        return view('admin.notifications.index', compact('notifications', 'stats'));
    }

    public function create(): View
    {
        return view('admin.notifications.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'type' => ['required', 'in:info,warning,success,maintenance'],
            'is_active' => ['boolean'],
            'scheduled_at' => ['nullable', 'date', 'after:now'],
            'expires_at' => ['nullable', 'date', 'after:scheduled_at'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        Notification::create($validated);

        return redirect()->route('admin.notifications.index')
                        ->with('success', 'Notifikasi berhasil dibuat!');
    }

    public function show(Notification $notification): View
    {
        return view('admin.notifications.show', compact('notification'));
    }

    public function edit(Notification $notification): View
    {
        return view('admin.notifications.edit', compact('notification'));
    }

    public function update(Request $request, Notification $notification): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'type' => ['required', 'in:info,warning,success,maintenance'],
            'is_active' => ['boolean'],
            'scheduled_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after:scheduled_at'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        $notification->update($validated);

        return redirect()->route('admin.notifications.index')
                        ->with('success', 'Notifikasi berhasil diperbarui!');
    }

    public function destroy(Notification $notification): RedirectResponse
    {
        $notification->delete();

        return redirect()->route('admin.notifications.index')
                        ->with('success', 'Notifikasi berhasil dihapus!');
    }

    public function toggle(Notification $notification): RedirectResponse
    {
        $notification->update([
            'is_active' => !$notification->is_active
        ]);

        $status = $notification->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()
                        ->with('success', "Notifikasi berhasil {$status}!");
    }

    public function broadcast(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'type' => ['required', 'in:info,warning,success,maintenance'],
        ]);

        $validated['is_active'] = true;
        $validated['scheduled_at'] = now();

        Notification::create($validated);

        return redirect()->route('admin.notifications.index')
                        ->with('success', 'Broadcast berhasil dikirim ke semua user!');
    }
}