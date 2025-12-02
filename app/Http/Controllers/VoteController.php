<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\Vote;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    public function store(Request $request, $slug)
    {
        $poll = Poll::where('slug', $slug)->firstOrFail();

        // Validate poll is active
        if (!$poll->isActive()) {
            return back()->with('error', 'This poll is no longer active.');
        }

        // Check max votes
        if ($poll->hasReachedMaxVotes()) {
            return back()->with('error', 'This poll has reached maximum votes.');
        }

        // Check for duplicate votes
        if (!$poll->allow_multiple_votes) {
            $existingVote = Vote::where('poll_id', $poll->id)
                ->where(function ($query) use ($request) {
                    $query->where('voter_ip', $request->ip());
                    if ($request->voter_email) {
                        $query->orWhere('voter_email', $request->voter_email);
                    }
                })
                ->exists();

            if ($existingVote) {
                return back()->with('error', 'You have already voted in this poll.');
            }
        }

        // Validate responses
        $validated = $request->validate([
            'voter_name' => 'nullable|string|max:255',
            'voter_email' => $poll->require_email ? 'required|email' : 'nullable|email',
            'responses' => 'required|array',
            'responses.*' => 'nullable',
        ]);

        DB::beginTransaction();

        try {
            // Create vote record
            $vote = Vote::create([
                'poll_id' => $poll->id,
                'voter_email' => $validated['voter_email'] ?? null,
                'voter_name' => $validated['voter_name'] ?? null,
                'voter_ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'voted_at' => now(),
            ]);

            // Store responses
            foreach ($validated['responses'] as $questionId => $responseData) {
                $question = $poll->questions()->findOrFail($questionId);

                if ($question->question_type === 'single_choice') {
                    Response::create([
                        'vote_id' => $vote->id,
                        'question_id' => $questionId,
                        'option_id' => $responseData,
                    ]);
                } elseif ($question->question_type === 'multiple_choice') {
                    if (is_array($responseData)) {
                        foreach ($responseData as $optionId) {
                            Response::create([
                                'vote_id' => $vote->id,
                                'question_id' => $questionId,
                                'option_id' => $optionId,
                            ]);
                        }
                    }
                } elseif ($question->question_type === 'rating') {
                    Response::create([
                        'vote_id' => $vote->id,
                        'question_id' => $questionId,
                        'rating_value' => $responseData,
                    ]);
                } elseif ($question->question_type === 'text') {
                    Response::create([
                        'vote_id' => $vote->id,
                        'question_id' => $questionId,
                        'text_response' => $responseData,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('polls.thankyou', $poll->slug)
                ->with('success', 'Thank you for voting!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to submit vote: ' . $e->getMessage());
        }
    }

    public function thankyou($slug)
    {
        $poll = Poll::where('slug', $slug)->firstOrFail();

        return view('polls.thankyou', compact('poll'));
    }
}
