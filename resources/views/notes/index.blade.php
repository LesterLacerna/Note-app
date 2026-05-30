<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 style="font-size:1.25rem;font-weight:700;color:#f1f5f9;">My Notes</h2>
                <p style="font-size:0.875rem;color:#94a3b8;margin-top:2px;">Clean, organized notes in one place.</p>
            </div>
            <a href="{{ route('notes.create') }}"
               style="display:inline-flex;align-items:center;gap:8px;background:#10b981;color:#000;padding:8px 16px;border-radius:10px;font-size:0.875rem;font-weight:600;text-decoration:none;">
                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Note
            </a>
        </div>
    </x-slot>

    <div style="padding:2rem 0;background:#020617;min-height:100vh;">
        <div style="max-width:900px;margin:0 auto;padding:0 1.5rem;display:flex;flex-direction:column;gap:1.5rem;">

            {{-- Welcome Banner --}}
            <div style="background:linear-gradient(135deg,#1e293b,#0f172a);border:1px solid #334155;border-radius:16px;padding:1.5rem;">
                <h3 style="font-size:1.25rem;font-weight:700;color:#fff;margin-bottom:4px;">
                    Welcome back, {{ auth()->user()->name }}! 👋
                </h3>
                <p style="color:#94a3b8;font-size:0.875rem;">Here's a summary of your notes activity.</p>
            </div>

            {{-- Stats Row --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">

                {{-- Total Notes --}}
                <div style="background:#0f172a;border:1px solid #1e293b;border-radius:14px;padding:1.25rem;display:flex;align-items:center;gap:1rem;">
                    <div style="width:44px;height:44px;background:#2563eb;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg style="width:22px;height:22px;color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p style="font-size:0.75rem;color:#94a3b8;font-weight:500;">Total Notes</p>
                        <p style="font-size:2rem;font-weight:700;color:#fff;line-height:1;">{{ auth()->user()->notes()->count() }}</p>
                    </div>
                </div>

                {{-- This Week --}}
                <div style="background:#0f172a;border:1px solid #1e293b;border-radius:14px;padding:1.25rem;display:flex;align-items:center;gap:1rem;">
                    <div style="width:44px;height:44px;background:#059669;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg style="width:22px;height:22px;color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p style="font-size:0.75rem;color:#94a3b8;font-weight:500;">This Week</p>
                        <p style="font-size:2rem;font-weight:700;color:#fff;line-height:1;">{{ auth()->user()->notes()->where('created_at', '>=', now()->subDays(7))->count() }}</p>
                    </div>
                </div>

            </div>

            {{-- Notes List --}}
            <div style="background:#0f172a;border:1px solid #1e293b;border-radius:14px;padding:1.5rem;">
                <div style="margin-bottom:1rem;">
                    <h3 style="font-size:1rem;font-weight:700;color:#f1f5f9;">Recent Notes</h3>
                    <p style="font-size:0.8rem;color:#64748b;margin-top:2px;">Your latest 5 notes.</p>
                </div>

                @forelse(auth()->user()->notes()->latest()->take(5)->get() as $note)
                    <div style="border-bottom:1px solid #1e293b;padding:1rem 0;display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;">
                        <div style="flex:1;min-width:0;">
                            {{-- Title in white on dark, black on light --}}
                            <h4 style="font-size:0.9rem;font-weight:600;color:#f8fafc;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $note->title }}
                            </h4>
                            <p style="font-size:0.8rem;color:#94a3b8;margin-top:4px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                {{ Str::limit($note->content, 120) }}
                            </p>
                            <p style="font-size:0.7rem;color:#475569;margin-top:6px;">
                                {{ $note->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div style="display:flex;align-items:center;gap:12px;flex-shrink:0;">
                            {{-- View --}}
                            <a href="{{ route('notes.show', $note) }}" title="View"
                               style="color:#38bdf8;display:flex;">
                                <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            {{-- Edit --}}
                            <a href="{{ route('notes.edit', $note) }}" title="Edit"
                               style="color:#34d399;display:flex;">
                                <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            {{-- Delete --}}
                            <form action="{{ route('notes.destroy', $note) }}" method="POST"
                                  onsubmit="return confirm('Delete this note?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete"
                                        style="color:#f87171;background:none;border:none;cursor:pointer;display:flex;padding:0;">
                                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center;padding:3rem 0;">
                        <svg style="width:48px;height:48px;color:#334155;margin:0 auto;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 style="margin-top:12px;font-size:0.9rem;font-weight:600;color:#f1f5f9;">No notes yet</h3>
                        <p style="margin-top:4px;font-size:0.8rem;color:#64748b;">Click "New Note" above to get started.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

</x-app-layout>