<x-guest-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-3xl font-bold mb-4">{{ $poll->title }}</h1>

                    @if($poll->description)
                        <p class="text-gray-600 mb-6">{{ $poll->description }}</p>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('polls.vote', $poll->slug) }}" method="POST">
                        @csrf

                        @if(!$poll->is_anonymous || $poll->require_email)
                            <div class="mb-6 p-4 bg-gray-50 rounded">
                                @if(!$poll->is_anonymous)
                                    <div class="mb-3">
                                        <label class="block text-sm font-medium mb-1">Your Name</label>
                                        <input type="text" name="voter_name" class="border rounded w-full py-2 px-3">
                                    </div>
                                @endif

                                @if($poll->require_email)
                                    <div>
                                        <label class="block text-sm font-medium mb-1">Your Email *</label>
                                        <input type="email" name="voter_email" required class="border rounded w-full py-2 px-3">
                                    </div>
                                @endif
                            </div>
                        @endif

                        @foreach($poll->questions as $question)
                            <div class="mb-6 p-4 border rounded">
                                <h3 class="font-semibold mb-3">
                                    {{ $question->question_text }}
                                    @if($question->is_required)
                                        <span class="text-red-500">*</span>
                                    @endif
                                </h3>

                                @if($question->question_type === 'single_choice')
                                    @foreach($question->options as $option)
                                        <label class="flex items-center mb-2">
                                            <input type="radio" name="responses[{{ $question->id }}]" value="{{ $option->id }}"
                                                {{ $question->is_required ? 'required' : '' }} class="mr-2">
                                            {{ $option->option_text }}
                                        </label>
                                    @endforeach

                                @elseif($question->question_type === 'multiple_choice')
                                    @foreach($question->options as $option)
                                        <label class="flex items-center mb-2">
                                            <input type="checkbox" name="responses[{{ $question->id }}][]" value="{{ $option->id }}" class="mr-2">
                                            {{ $option->option_text }}
                                        </label>
                                    @endforeach

                                @elseif($question->question_type === 'rating')
                                    <div class="flex space-x-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <label class="flex items-center">
                                                <input type="radio" name="responses[{{ $question->id }}]" value="{{ $i }}"
                                                    {{ $question->is_required ? 'required' : '' }} class="mr-1">
                                                {{ $i }}
                                            </label>
                                        @endfor
                                    </div>

                                @elseif($question->question_type === 'text')
                                    <textarea name="responses[{{ $question->id }}]" rows="3"
                                        {{ $question->is_required ? 'required' : '' }}
                                        class="border rounded w-full py-2 px-3"></textarea>
                                @endif
                            </div>
                        @endforeach

                        <button type="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 font-semibold">
                            Submit Vote
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
