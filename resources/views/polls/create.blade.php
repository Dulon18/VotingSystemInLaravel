<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create New Poll
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('polls.store') }}" method="POST" id="pollForm">
                        @csrf

                        {{-- Basic Info --}}
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Poll Title *
                            </label>
                            <input type="text" name="title" required
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                value="{{ old('title') }}">
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">
                                Description
                            </label>
                            <textarea name="description" rows="3"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description') }}</textarea>
                        </div>

                        {{-- Settings --}}
                        <div class="mb-6 p-4 bg-gray-50 rounded">
                            <h3 class="text-lg font-semibold mb-3">Poll Settings</h3>

                            <div class="grid grid-cols-2 gap-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_public" value="1" checked class="mr-2">
                                    Public Poll
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_anonymous" value="1" checked class="mr-2">
                                    Anonymous Voting
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="allow_multiple_votes" value="1" class="mr-2">
                                    Allow Multiple Votes
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="require_email" value="1" class="mr-2">
                                    Require Email
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="show_results_before_vote" value="1" class="mr-2">
                                    Show Results Before Vote
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="randomize_options" value="1" class="mr-2">
                                    Randomize Options
                                </label>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Start Date</label>
                                    <input type="datetime-local" name="start_date" class="border rounded px-3 py-2 w-full">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">End Date</label>
                                    <input type="datetime-local" name="end_date" class="border rounded px-3 py-2 w-full">
                                </div>
                            </div>
                        </div>

                        {{-- Questions --}}
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-lg font-semibold">Questions</h3>
                                <button type="button" onclick="addQuestion()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                    + Add Question
                                </button>
                            </div>

                            <div id="questionsContainer"></div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('polls.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                                Cancel
                            </a>
                            <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                                Create Poll
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let questionCount = 0;

        function addQuestion() {
            questionCount++;
            const container = document.getElementById('questionsContainer');
            const questionHtml = `
                <div class="question-block border p-4 rounded mb-4" data-question="${questionCount}">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="font-semibold">Question ${questionCount}</h4>
                        <button type="button" onclick="removeQuestion(${questionCount})" class="text-red-500 hover:text-red-700">Remove</button>
                    </div>

                    <div class="mb-3">
                        <input type="text" name="questions[${questionCount}][question_text]" placeholder="Enter your question" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    </div>

                    <div class="mb-3">
                        <select name="questions[${questionCount}][question_type]" required
                            onchange="handleQuestionTypeChange(${questionCount}, this.value)"
                            class="shadow border rounded py-2 px-3 text-gray-700">
                            <option value="single_choice">Single Choice</option>
                            <option value="multiple_choice">Multiple Choice</option>
                            <option value="rating">Rating</option>
                            <option value="text">Text Response</option>
                        </select>
                    </div>

                    <div class="options-container-${questionCount} mb-3">
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-sm font-medium">Options</label>
                            <button type="button" onclick="addOption(${questionCount})" class="text-blue-500 text-sm">+ Add Option</button>
                        </div>
                        <div class="options-list-${questionCount}">
                            <input type="text" name="questions[${questionCount}][options][]" placeholder="Option 1" required class="border rounded w-full py-2 px-3 mb-2">
                            <input type="text" name="questions[${questionCount}][options][]" placeholder="Option 2" required class="border rounded w-full py-2 px-3 mb-2">
                        </div>
                    </div>

                    <label class="flex items-center">
                        <input type="checkbox" name="questions[${questionCount}][is_required]" value="1" checked class="mr-2">
                        Required Question
                    </label>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', questionHtml);
        }

        function removeQuestion(id) {
            const element = document.querySelector(`[data-question="${id}"]`);
            if (element) element.remove();
        }

        function addOption(questionId) {
            const container = document.querySelector(`.options-list-${questionId}`);
            const optionCount = container.querySelectorAll('input').length + 1;
            const optionHtml = `<input type="text" name="questions[${questionId}][options][]" placeholder="Option ${optionCount}" required class="border rounded w-full py-2 px-3 mb-2">`;
            container.insertAdjacentHTML('beforeend', optionHtml);
        }

        function handleQuestionTypeChange(questionId, type) {
            const optionsContainer = document.querySelector(`.options-container-${questionId}`);
            if (type === 'text' || type === 'rating') {
                optionsContainer.style.display = 'none';
                optionsContainer.querySelectorAll('input').forEach(input => input.removeAttribute('required'));
            } else {
                optionsContainer.style.display = 'block';
                optionsContainer.querySelectorAll('input').forEach(input => input.setAttribute('required', 'required'));
            }
        }

        // Add first question on load
        addQuestion();
    </script>
</x-app-layout>
