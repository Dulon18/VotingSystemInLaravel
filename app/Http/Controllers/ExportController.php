<?php

// app/Exports/PollResultsExport.php

namespace App\Exports;

use App\Models\Poll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Collection;

class PollResultsExport implements WithMultipleSheets
{
    protected $poll;

    public function __construct(Poll $poll)
    {
        $this->poll = $poll;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Summary sheet
        $sheets[] = new PollSummarySheet($this->poll);

        // Individual question sheets
        foreach ($this->poll->questions as $index => $question) {
            $sheets[] = new QuestionResultsSheet($question, $index + 1);
        }

        // Detailed responses sheet
        $sheets[] = new DetailedResponsesSheet($this->poll);

        return $sheets;
    }
}

class PollSummarySheet implements FromCollection, WithHeadings, WithTitle
{
    protected $poll;

    public function __construct(Poll $poll)
    {
        $this->poll = $poll;
    }

    public function collection()
    {
        $data = collect([
            ['Poll Title', $this->poll->title],
            ['Description', $this->poll->description],
            ['Created By', $this->poll->user->name],
            ['Created At', $this->poll->created_at->format('Y-m-d H:i:s')],
            ['Total Votes', $this->poll->totalVotes()],
            ['Status', $this->poll->status],
            ['Start Date', $this->poll->start_date ? $this->poll->start_date->format('Y-m-d H:i:s') : 'N/A'],
            ['End Date', $this->poll->end_date ? $this->poll->end_date->format('Y-m-d H:i:s') : 'N/A'],
            [],
            ['Question Statistics'],
        ]);

        foreach ($this->poll->questions as $index => $question) {
            $data->push([
                'Q' . ($index + 1),
                $question->question_text,
                $question->question_type,
                $question->responses()->count() . ' responses'
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return ['Field', 'Value'];
    }

    public function title(): string
    {
        return 'Summary';
    }
}

class QuestionResultsSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $question;
    protected $questionNumber;

    public function __construct($question, $questionNumber)
    {
        $this->question = $question;
        $this->questionNumber = $questionNumber;
    }

    public function collection()
    {
        $data = collect();

        if ($this->question->question_type === 'single_choice' || $this->question->question_type === 'multiple_choice') {
            foreach ($this->question->options as $option) {
                $count = $option->voteCount();
                $percentage = $option->votePercentage();

                $data->push([
                    $option->option_text,
                    $count,
                    number_format($percentage, 2) . '%'
                ]);
            }
        } elseif ($this->question->question_type === 'rating') {
            $ratings = $this->question->responses()
                ->selectRaw('rating_value, COUNT(*) as count')
                ->groupBy('rating_value')
                ->orderBy('rating_value')
                ->get();

            $average = $this->question->responses()->avg('rating_value');

            $data->push(['Average Rating', number_format($average, 2), '']);
            $data->push(['', '', '']);

            foreach ($ratings as $rating) {
                $data->push([
                    'Rating ' . $rating->rating_value,
                    $rating->count,
                    ''
                ]);
            }
        } elseif ($this->question->question_type === 'text') {
            $responses = $this->question->responses()
                ->whereNotNull('text_response')
                ->get();

            foreach ($responses as $response) {
                $data->push([
                    $response->text_response,
                    $response->created_at->format('Y-m-d H:i:s'),
                    ''
                ]);
            }
        }

        return $data;
    }

    public function headings(): array
    {
        if ($this->question->question_type === 'text') {
            return ['Response', 'Timestamp', ''];
        }
        return ['Option', 'Count', 'Percentage'];
    }

    public function title(): string
    {
        return 'Q' . $this->questionNumber . ' - ' . substr($this->question->question_text, 0, 25);
    }
}

class DetailedResponsesSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $poll;

    public function __construct(Poll $poll)
    {
        $this->poll = $poll;
    }

    public function collection()
    {
        $data = collect();

        foreach ($this->poll->votes as $vote) {
            $row = [
                $vote->id,
                $vote->voter_name ?? 'Anonymous',
                $vote->voter_email ?? 'N/A',
                $vote->voted_at->format('Y-m-d H:i:s'),
                $vote->voter_ip,
            ];

            // Add each question response
            foreach ($this->poll->questions as $question) {
                $responses = $vote->responses()
                    ->where('question_id', $question->id)
                    ->get();

                if ($responses->isEmpty()) {
                    $row[] = 'No response';
                } else {
                    $responseTexts = [];
                    foreach ($responses as $response) {
                        if ($response->option) {
                            $responseTexts[] = $response->option->option_text;
                        } elseif ($response->rating_value) {
                            $responseTexts[] = $response->rating_value;
                        } elseif ($response->text_response) {
                            $responseTexts[] = $response->text_response;
                        }
                    }
                    $row[] = implode(', ', $responseTexts);
                }
            }

            $data->push($row);
        }

        return $data;
    }

    public function headings(): array
    {
        $headings = [
            'Vote ID',
            'Voter Name',
            'Voter Email',
            'Timestamp',
            'IP Address',
        ];

        foreach ($this->poll->questions as $index => $question) {
            $headings[] = 'Q' . ($index + 1) . ': ' . $question->question_text;
        }

        return $headings;
    }

    public function title(): string
    {
        return 'Detailed Responses';
    }
}
