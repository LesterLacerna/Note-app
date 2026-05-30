<x-app-layout class="bg-slate-950 text-slate-100">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">{{ __('Edit Note') }}</h2>
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

                    @if($errors->any())
                        <div class="rounded-2xl bg-rose-500/10 border border-rose-500 text-rose-200 p-4">
                            <p class="font-semibold">Please fix the following errors:</p>
                            <ul class="mt-2 list-disc list-inside text-sm space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('notes.update', $note) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="title" class="block text-sm font-medium text-slate-200">Title</label>
                            <input id="title" name="title" type="text" value="{{ old('title', $note->title) }}" class="mt-1 block w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-white shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/50" />
                            @error('title') <p class="mt-2 text-sm text-rose-400">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-medium text-slate-200">Content</label>
                            <textarea id="content" name="content" rows="8" class="mt-1 block w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-white shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/50">{{ old('content', $note->content) }}</textarea>
                            @error('content') <p class="mt-2 text-sm text-rose-400">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex flex-wrap items-center gap-4">
                            <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-emerald-500 px-5 py-3 font-medium text-slate-950 transition hover:bg-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">Update Note</button>
                            <a href="{{ route('notes.index') }}" class="text-slate-300 hover:text-white">Back to Notes</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>