{{-- resources/views/polls/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-2xl font-bold text-gray-900">
                My Polls
            </h2>
            <a href="{{ route('polls.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create New Poll
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-r-lg shadow-sm" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-800 px-6 py-4 rounded-r-lg shadow-sm" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                {{-- Total Polls --}}
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Polls</p>
                            <p class="text-4xl font-bold text-gray-900 mt-2">{{ Auth::user()->polls()->count() }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-full">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Active Polls --}}
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Active Polls</p>
                            <p class="text-4xl font-bold text-green-600 mt-2">{{ Auth::user()->polls()->where('status', 'active')->count() }}</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Total Votes --}}
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Votes</p>
                            <p class="text-4xl font-bold text-purple-600 mt-2">{{ Auth::user()->polls()->withCount('votes')->get()->sum('votes_count') }}</p>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-full">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Closed Polls --}}
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6 border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Closed Polls</p>
                            <p class="text-4xl font-bold text-red-600 mt-2">{{ Auth::user()->polls()->where('status', 'closed')->count() }}</p>
                        </div>
                        <div class="p-3 bg-red-50 rounded-full">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filter Tabs --}}
            <div class="bg-white rounded-xl shadow-md mb-6 overflow-hidden">
                <nav class="flex border-b border-gray-200">
                    <a href="{{ route('polls.index') }}"
                        class="flex-1 py-4 px-6 text-center font-medium text-sm transition-colors duration-200 border-b-2 {{ !request('status') ? 'border-blue-600 text-blue-600 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50' }}">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            All Polls
                        </span>
                    </a>
                    <a href="{{ route('polls.index', ['status' => 'active']) }}"
                        class="flex-1 py-4 px-6 text-center font-medium text-sm transition-colors duration-200 border-b-2 {{ request('status') === 'active' ? 'border-green-600 text-green-600 bg-green-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50' }}">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Active
                        </span>
                    </a>
                    <a href="{{ route('polls.index', ['status' => 'closed']) }}"
                        class="flex-1 py-4 px-6 text-center font-medium text-sm transition-colors duration-200 border-b-2 {{ request('status') === 'closed' ? 'border-red-600 text-red-600 bg-red-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50' }}">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Closed
                        </span>
                    </a>
                    <a href="{{ route('polls.index', ['status' => 'draft']) }}"
                        class="flex-1 py-4 px-6 text-center font-medium text-sm transition-colors duration-200 border-b-2 {{ request('status') === 'draft' ? 'border-gray-600 text-gray-600 bg-gray-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50' }}">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Drafts
                        </span>
                    </a>
                </nav>
            </div>

            {{-- Polls List --}}
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    @if($polls->isEmpty())
                        <div class="text-center py-16">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-6">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">No polls yet</h3>
                            <p class="text-gray-500 mb-8 max-w-md mx-auto">Get started by creating your first poll and start collecting responses from your audience.</p>
                            <a href="{{ route('polls.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create Your First Poll
                            </a>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($polls as $poll)
                                <div class="group border border-gray-200 rounded-xl hover:shadow-xl hover:border-blue-300 transition-all duration-300 overflow-hidden">
                                    <div class="p-8">
                                        <div class="flex flex-col lg:flex-row justify-between items-start gap-6">
                                            {{-- Poll Info --}}
                                            <div class="flex-1 w-full lg:w-auto">
                                                <div class="flex flex-wrap items-center gap-3 mb-3">
                                                    <h3 class="text-2xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                                        {{ $poll->title }}
                                                    </h3>

                                                    {{-- Status Badge --}}
                                                    @if($poll->status === 'active')
                                                        <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-gradient-to-r from-green-400 to-green-600 text-white shadow-sm">
                                                            <span class="w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></span>
                                                            Active
                                                        </span>
                                                    @elseif($poll->status === 'closed')
                                                        <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-gradient-to-r from-red-400 to-red-600 text-white shadow-sm">
                                                            Closed
                                                        </span>
                                                    @elseif($poll->status === 'draft')
                                                        <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-gradient-to-r from-gray-400 to-gray-600 text-white shadow-sm">
                                                            Draft
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-gradient-to-r from-yellow-400 to-yellow-600 text-white shadow-sm">
                                                            Archived
                                                        </span>
                                                    @endif
                                                </div>

                                                @if($poll->description)
                                                    <p class="text-gray-600 text-base leading-relaxed mb-4">
                                                        {{ Str::limit($poll->description, 200) }}
                                                    </p>
                                                @endif

                                                {{-- Meta Information --}}
                                                <div class="flex flex-wrap gap-6 text-sm text-gray-600 mb-4">
                                                    <div class="flex items-center bg-gray-50 px-3 py-2 rounded-lg">
                                                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                        </svg>
                                                        <span class="font-semibold text-gray-900">{{ $poll->votes_count }}</span>
                                                        <span class="ml-1">votes</span>
                                                    </div>

                                                    <div class="flex items-center bg-gray-50 px-3 py-2 rounded-lg">
                                                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        <span class="font-semibold text-gray-900">{{ $poll->questions()->count() }}</span>
                                                        <span class="ml-1">questions</span>
                                                    </div>

                                                    <div class="flex items-center bg-gray-50 px-3 py-2 rounded-lg">
                                                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        <span>{{ $poll->created_at->diffForHumans() }}</span>
                                                    </div>

                                                    @if($poll->end_date)
                                                        <div class="flex items-center bg-gray-50 px-3 py-2 rounded-lg">
                                                            <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                            <span>Ends {{ $poll->end_date->format('M d, Y') }}</span>
                                                        </div>
                                                    @endif

                                                    @if($poll->is_public)
                                                        <div class="flex items-center text-green-600 bg-green-50 px-3 py-2 rounded-lg">
                                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                            <span class="font-medium">Public</span>
                                                        </div>
                                                    @else
                                                        <div class="flex items-center text-red-600 bg-red-50 px-3 py-2 rounded-lg">
                                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                            </svg>
                                                            <span class="font-medium">Private</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- Share Link --}}
                                                <div class="flex items-stretch">
                                                    <input type="text" readonly value="{{ route('polls.show', $poll->slug) }}"
                                                        id="poll-link-{{ $poll->id }}"
                                                        class="flex-1 text-sm border-2 border-gray-200 rounded-l-lg px-4 py-3 bg-gray-50 text-gray-700 font-mono focus:outline-none focus:border-blue-400">
                                                    <button onclick="copyLink('poll-link-{{ $poll->id }}')"
                                                        class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-r-lg border-2 border-l-0 border-gray-600 font-semibold transition-all duration-200 flex items-center">
                                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                        </svg>
                                                        Copy
                                                    </button>
                                                </div>
                                            </div>

                                            {{-- Action Buttons --}}
                                            <div class="flex flex-row lg:flex-col gap-3 w-full lg:w-auto lg:min-w-[140px]">
                                                <a href="{{ route('polls.show', $poll->slug) }}"
                                                    class="flex-1 lg:flex-none inline-flex items-center justify-center px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    View
                                                </a>

                                                <a href="{{ route('polls.results', $poll->slug) }}"
                                                    class="flex-1 lg:flex-none inline-flex items-center justify-center px-5 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                    </svg>
                                                    Results
                                                </a>

                                                <a href="{{ route('polls.edit', $poll->id) }}"
                                                    class="flex-1 lg:flex-none inline-flex items-center justify-center px-5 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Edit
                                                </a>

                                                <form action="{{ route('polls.destroy', $poll->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this poll? This action cannot be undone.')"
                                                    class="flex-1 lg:flex-none">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="w-full inline-flex items-center justify-center px-5 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        {{-- Pagination --}}
                        <div class="mt-8 flex justify-center">
                            {{ $polls->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Copy Link Script --}}
    <script>
        function copyLink(elementId) {
            const input = document.getElementById(elementId);
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
                button.classList.remove('bg-gray-600', 'hover:bg-gray-700', 'border-gray-600');
                button.classList.add('bg-green-600', 'hover:bg-green-700', 'border-green-600');

                setTimeout(() => {
                    button.innerHTML = originalHTML;
                    button.classList.remove('bg-green-600', 'hover:bg-green-700', 'border-green-600');
                    button.classList.add('bg-gray-600', 'hover:bg-gray-700', 'border-gray-600');
                }, 2000);
            }).catch(err => {
                alert('Failed to copy link');
            });
        }
    </script>
</x-app-layout>
