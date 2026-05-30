<x-app-layout class="bg-slate-950 text-slate-100">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">{{ __('View Note') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900 border border-slate-800 shadow-sm sm:rounded-3xl">
                <div class="p-6 space-y-6">
                    @if(session('success'))
                        <div class="rounded-2xl bg-emerald-500/10 border border-emerald-500 text-emerald-200 p-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="space-y-4">
                        <h1 class="text-3xl font-semibold text-white">{{ $note->title }}</h1>
                        <p class="text-slate-300 whitespace-pre-line">{{ $note->content }}</p>
                        <p class="text-sm text-slate-500">Created {{ $note->created_at->diffForHumans() }}</p>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('notes.edit', $note) }}" class="inline-flex items-center justify-center rounded-2xl bg-emerald-500 px-4 py-2 text-sm font-medium text-slate-950 hover:bg-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">Edit</a>
                        <a href="{{ route('notes.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-700 px-4 py-2 text-sm font-medium text-slate-200 hover:border-slate-600 hover:text-white">Back to Notes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>