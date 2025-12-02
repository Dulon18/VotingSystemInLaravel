<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PollController extends Controller
{

    public function index(Request $request)
    {
        $query = Auth::user()->polls()->withCount('votes');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $polls = $query->latest()->paginate(10);
        //dd($polls);
        return view('polls.index', compact('polls'));
    }

    public function create()
    {
        return view('polls.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'boolean',
            'is_anonymous' => 'boolean',
            'allow_multiple_votes' => 'boolean',
            'require_email' => 'boolean',
            'show_results_before_vote' => 'boolean',
            'randomize_options' => 'boolean',
            'password' => 'nullable|string|min:4',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'max_votes' => 'nullable|integer|min:1',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|in:single_choice,multiple_choice,rating,text',
            'questions.*.is_required' => 'boolean',
            'questions.*.options' => 'required_unless:questions.*.question_type,text,rating|array|min:2',
            'questions.*.options.*' => 'required|string',
            'questions.*.settings' => 'nullable|array',
        ]);
        //dd($validated);
        DB::beginTransaction();

        try {
            // Create poll
            $poll = Poll::create([
                'user_id' => Auth::id(),
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'slug' => Str::slug($validated['title']) . '-' . Str::random(6),
                'is_public' => $validated['is_public'] ?? true,
                'is_anonymous' => $validated['is_anonymous'] ?? true,
                'allow_multiple_votes' => $validated['allow_multiple_votes'] ?? false,
                'require_email' => $validated['require_email'] ?? false,
                'show_results_before_vote' => $validated['show_results_before_vote'] ?? false,
                'randomize_options' => $validated['randomize_options'] ?? false,
                'password' => $validated['password'] ?? null,
                'start_date' => $validated['start_date'] ?? null,
                'end_date' => $validated['end_date'] ?? null,
                'max_votes' => $validated['max_votes'] ?? null,
                'status' => 'active',
            ]);

            // Create questions and options
            foreach ($validated['questions'] as $index => $questionData) {
                $question = $poll->questions()->create([
                    'poll_id ' => $poll->id,
                    'question_text' => $questionData['question_text'],
                    'question_type' => $questionData['question_type'],
                    'is_required' => $questionData['is_required'] ?? true,
                    'order' => $index,
                    'settings' => $questionData['settings'] ?? null,
                ]);

                // Create options if not text or rating type
                if (!in_array($questionData['question_type'], ['text', 'rating'])) {
                    foreach ($questionData['options'] as $optionIndex => $optionText) {
                        $question->options()->create([
                            'question_id '=> $question->id,
                            'option_text' => $optionText,
                            'order' => $optionIndex,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('polls.show', $poll->slug)
                ->with('success', 'Poll created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to create poll: ' . $e->getMessage());
        }
    }

    public function show($slug)
    {
        $poll = Poll::where('slug', $slug)
            ->with(['questions.options'])
            ->firstOrFail();

        // Check if poll is accessible
        if (!$poll->is_public && (!Auth::check() || Auth::id() !== $poll->user_id)) {
            abort(403, 'This poll is private');
        }

        // Check if poll is active
        if (!$poll->isActive()) {
            return view('polls.closed', compact('poll'));
        }

        // Check if max votes reached
        if ($poll->hasReachedMaxVotes()) {
            return view('polls.closed', compact('poll'));
        }

        return view('polls.show', compact('poll'));
    }

    public function edit(Poll $poll)
    {
        $this->authorize('update', $poll);

        $poll->load('questions.options');

        return view('polls.edit', compact('poll'));
    }

    public function update(Request $request, Poll $poll)
    {
        $this->authorize('update', $poll);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'end_date' => 'nullable|date',
            'status' => 'required|in:active,closed,archived',
        ]);

        $poll->update($validated);

        return redirect()->route('polls.show', $poll->slug)
            ->with('success', 'Poll updated successfully!');
    }

    public function destroy(Poll $poll)
    {
        $this->authorize('delete', $poll);

        $poll->delete();

        return redirect()->route('polls.index')
            ->with('success', 'Poll deleted successfully!');
    }
    public function results($slug)
    {
        $poll = Poll::where('slug', $slug)
            ->with(['questions.options', 'votes'])
            ->firstOrFail();

        //$this->authorize('view', $poll);

        return view('polls.results', compact('poll'));
    }
}
