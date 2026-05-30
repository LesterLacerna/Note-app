<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    // Step 1: Update index — fetch and display all notes for authenticated user
    public function index()
    {
        $notes = auth()->user()->notes()->latest()->get();
        return view('notes.index', compact('notes'));
    }

    // Show create form
    public function create()
    {
        return view('notes.create');
    }

    // Step 2: store method — save new note
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);

        auth()->user()->notes()->create($request->only('title', 'content'));

        return redirect()->route('notes.index')->with('success', 'Note added!');
    }

    // Show a single note
    public function show(Note $note)
    {
        // Ensure the note belongs to the authenticated user
        if ($note->user_id !== auth()->id()) {
            abort(403);
        }

        return view('notes.show', compact('note'));
    }

    // Show edit form
    public function edit(Note $note)
    {
        // Ensure the note belongs to the authenticated user
        if ($note->user_id !== auth()->id()) {
            abort(403);
        }

        return view('notes.edit', compact('note'));
    }

    // Update note
    public function update(Request $request, Note $note)
    {
        // Ensure the note belongs to the authenticated user
        if ($note->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);

        $note->update($request->only('title', 'content'));

        return redirect()->route('notes.index')->with('success', 'Note updated!');
    }

    // Delete note
    public function destroy(Note $note)
    {
        // Ensure the note belongs to the authenticated user
        if ($note->user_id !== auth()->id()) {
            abort(403);
        }

        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Note deleted!');
    }
}