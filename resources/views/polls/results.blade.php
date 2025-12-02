{{-- resources/views/polls/results.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Poll Results
                </h2>
                <p class="text-gray-600 mt-1">{{ $poll->title }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('polls.index') }}"
                    class="inline-flex items-center bg-gray-600 hover:bg-gray-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow-md transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Polls
                </a>
                <a href="{{ route('polls.export.excel', $poll->slug) }}"
                    class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow-md transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export Excel
                </a>
                <a href="{{ route('polls.export.csv', $poll->slug) }}"
                    class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow-md transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export CSV
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Summary Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium uppercase tracking-wide">Total Votes</p>
                            <p class="text-4xl font-bold mt-2"></p>
                        </div>
                        <div class="bg-blue-400 bg-opacity-30 p-3 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium uppercase tracking-wide">Questions</p>
                            <p class="text-4xl font-bold mt-2">{{ $poll->questions()->count() }}</p>
                        </div>
                        <div class="bg-purple-400 bg-opacity-30 p-3 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium uppercase tracking-wide">Status</p>
                            <p class="text-2xl font-bold mt-2">{{ ucfirst($poll->status) }}</p>
                        </div>
                        <div class="bg-green-400 bg-opacity-30 p-3 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-medium uppercase tracking-wide">Created</p>
                            <p class="text-lg font-bold mt-2">{{ $poll->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="bg-orange-400 bg-opacity-30 p-3 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Questions Results --}}
            @foreach($poll->questions as $index => $question)
                <div class="bg-white rounded-xl shadow-lg mb-8 overflow-hidden border-l-4 {{ $index % 4 == 0 ? 'border-blue-500' : ($index % 4 == 1 ? 'border-purple-500' : ($index % 4 == 2 ? 'border-green-500' : 'border-orange-500')) }}">
                    <div class="p-8">
                        {{-- Question Header --}}
                        <div class="mb-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full {{ $index % 4 == 0 ? 'bg-blue-100 text-blue-600' : ($index % 4 == 1 ? 'bg-purple-100 text-purple-600' : ($index % 4 == 2 ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600')) }} font-bold text-lg">
                                            {{ $index + 1 }}
                                        </span>
                                        <h3 class="text-2xl font-bold text-gray-900">{{ $question->question_text }}</h3>
                                    </div>
                                    <div class="flex items-center gap-4 ml-12 text-sm text-gray-600">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-100">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                            Type: <span class="font-semibold ml-1">{{ ucwords(str_replace('_', ' ', $question->question_type)) }}</span>
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                            <span class="font-semibold">{{ $question->responses()->count() }}</span> responses
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Results Based on Question Type --}}
                        @if($question->question_type === 'single_choice' || $question->question_type === 'multiple_choice')
                            {{-- Choice Questions --}}
                            <div class="space-y-4">
                                @foreach($question->options as $option)
                                    @php
                                        $count = $option->voteCount();
                                        $percentage = $option->votePercentage();
                                    @endphp
                                    <div class="group">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-gray-800 font-medium">{{ $option->option_text }}</span>
                                            <div class="flex items-center gap-3">
                                                <span class="text-2xl font-bold {{ $index % 4 == 0 ? 'text-blue-600' : ($index % 4 == 1 ? 'text-purple-600' : ($index % 4 == 2 ? 'text-green-600' : 'text-orange-600')) }}">
                                                    {{ $count }}
                                                </span>
                                                <span class="text-sm text-gray-500 font-semibold w-16 text-right">
                                                    ({{ number_format($percentage, 1) }}%)
                                                </span>
                                            </div>
                                        </div>
                                        <div class="relative w-full bg-gray-200 rounded-full h-6 overflow-hidden shadow-inner">
                                            <div class="absolute inset-0 {{ $index % 4 == 0 ? 'bg-gradient-to-r from-blue-400 to-blue-600' : ($index % 4 == 1 ? 'bg-gradient-to-r from-purple-400 to-purple-600' : ($index % 4 == 2 ? 'bg-gradient-to-r from-green-400 to-green-600' : 'bg-gradient-to-r from-orange-400 to-orange-600')) }} rounded-full transition-all duration-1000 ease-out hover:opacity-90"
                                                style="width: {{ $percentage }}%">
                                                <div class="absolute inset-0 bg-white opacity-20"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        @elseif($question->question_type === 'rating')
                            {{-- Rating Questions --}}
                            @php
                                $ratings = $question->responses()
                                    ->selectRaw('rating_value, COUNT(*) as count')
                                    ->groupBy('rating_value')
                                    ->orderBy('rating_value')
                                    ->get();
                                $average = $question->responses()->avg('rating_value');
                                $totalResponses = $question->responses()->count();
                            @endphp

                            <div class="mb-6 p-6 bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl border-2 border-yellow-200">
                                <div class="flex items-center justify-center">
                                    <div class="text-center">
                                        <p class="text-gray-600 text-sm font-medium uppercase tracking-wide mb-2">Average Rating</p>
                                        <div class="flex items-center justify-center gap-2">
                                            <span class="text-6xl font-bold text-yellow-600">{{ number_format($average, 1) }}</span>
                                            <div>
                                                <div class="flex text-yellow-400">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= floor($average))
                                                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                            </svg>
                                                        @elseif($i - 0.5 <= $average)
                                                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" opacity="0.5"></path>
                                                            </svg>
                                                        @else
                                                            <svg class="w-8 h-8 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                            </svg>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1">out of 5 stars</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                @for($star = 5; $star >= 1; $star--)
                                    @php
                                        $ratingData = $ratings->firstWhere('rating_value', $star);
                                        $count = $ratingData ? $ratingData->count : 0;
                                        $percentage = $totalResponses > 0 ? ($count / $totalResponses) * 100 : 0;
                                    @endphp
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center gap-1 w-24">
                                            <span class="text-sm font-semibold text-gray-700">{{ $star }} Star{{ $star > 1 ? 's' : '' }}</span>
                                        </div>
                                        <div class="flex-1 relative bg-gray-200 rounded-full h-8 overflow-hidden shadow-inner">
                                            <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-full transition-all duration-1000"
                                                style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <div class="flex items-center gap-2 w-24 justify-end">
                                            <span class="text-lg font-bold text-gray-900">{{ $count }}</span>
                                            <span class="text-sm text-gray-500">({{ number_format($percentage, 1) }}%)</span>
                                        </div>
                                    </div>
                                @endfor
                            </div>

                        @elseif($question->question_type === 'text')
                            {{-- Text Questions --}}
                            @php
                                $textResponses = $question->responses()->whereNotNull('text_response')->get();
                            @endphp

                            @if($textResponses->isEmpty())
                                <div class="text-center py-12 bg-gray-50 rounded-lg">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                    </svg>
                                    <p class="mt-2 text-gray-500">No text responses yet</p>
                                </div>
                            @else
                                <div class="space-y-3 max-h-96 overflow-y-auto pr-2">
                                    @foreach($textResponses as $response)
                                        <div class="group p-4 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-blue-50 hover:to-blue-100 rounded-lg border border-gray-200 hover:border-blue-300 transition-all duration-200 shadow-sm hover:shadow">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0 mt-1">
                                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold text-sm">
                                                        {{ $loop->iteration }}
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-gray-800 leading-relaxed">{{ $response->text_response }}</p>
                                                    <p class="text-xs text-gray-500 mt-2">
                                                        {{ $response->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach

            {{-- Share Results Section --}}
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-2xl p-8 text-white text-center">
                <h3 class="text-2xl font-bold mb-2">Share These Results</h3>
                <p class="text-blue-100 mb-6">Let others see the poll results</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <input type="text" readonly value="{{ route('polls.results', $poll->slug) }}"
                        id="results-link"
                        class="flex-1 max-w-xl px-4 py-3 rounded-lg bg-white bg-opacity-20 text-white placeholder-blue-200 border-2 border-white border-opacity-30 focus:outline-none focus:border-opacity-50 font-mono text-sm">
                    <button onclick="copyResultsLink()"
                        class="bg-white text-blue-600 hover:bg-blue-50 font-bold px-8 py-3 rounded-lg shadow-lg transition-all duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Copy Link
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyResultsLink() {
            const input = document.getElementById('results-link');
            input.select();
            input.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(input.value).then(() => {
                const button = event.target.closest('button');
                const originalHTML = button.innerHTML;

                button.innerHTML = `
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Copied!
                `;

                setTimeout(() => {
                    button.innerHTML = originalHTML;
                }, 2000);
            }).catch(err => {
                alert('Failed to copy link');
            });
        }

        // Animate progress bars on load
        document.addEventListener('DOMContentLoaded', function() {
            const progressBars = document.querySelectorAll('[style*="width"]');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
            });
        });
    </script>
</x-app-layout>
