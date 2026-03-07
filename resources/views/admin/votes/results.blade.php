<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">Election Results</h2>
                <p class="text-sm text-violet-600 dark:text-violet-400 mt-0.5">Real-time voting results by position</p>
            </div>
        </div>
    </x-slot>

    {{-- Voter Turnout Card --}}
    <div class="mb-6">
        <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-6
                   bg-gradient-to-r from-violet-50/50 to-transparent dark:from-violet-900/20 dark:to-transparent">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-violet-600 dark:text-violet-400 font-semibold uppercase">Voter Turnout</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-2">
                        {{ $totalVotersTurnout }} <span class="text-xl text-violet-500">voters</span>
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Have casted their votes</p>
                </div>
                <div class="text-5xl font-bold text-violet-600 dark:text-violet-400 opacity-10">
                    <i class="fas fa-vote-yea"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Results by Position --}}
    <div class="space-y-6">
        @forelse($results as $position)
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm overflow-hidden">

                {{-- Position Header --}}
                <div class="bg-gradient-to-r from-violet-50 to-violet-50/30 dark:from-violet-900/30 dark:to-transparent
                            px-6 py-4 border-b border-violet-100 dark:border-violet-800/50">
                    <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100">{{ $position->name }}</h3>
                </div>

                {{-- Candidates Results --}}
                <div class="p-6">
                    @if($position->candidates->count() > 0)
                        <div class="space-y-4">
                            @foreach($position->candidates as $candidate)
                                @php
                                    $voteCount = $candidate->votes_count ?? 0;
                                    $totalPositionVotes = $position->candidates->sum('votes_count');
                                    $percentage = $totalPositionVotes > 0 ? ($voteCount / $totalPositionVotes) * 100 : 0;
                                @endphp

                                <div class="pb-4 last:pb-0">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center gap-3 flex-1">
                                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-violet-600 to-violet-400
                                                        flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                                @if($candidate->photo)
                                                    <img src="{{ asset('images/candidates/' . $candidate->photo) }}"
                                                         alt="{{ $candidate->first_name }}" class="w-full h-full object-cover rounded-lg">
                                                @else
                                                    {{ strtoupper(substr($candidate->first_name, 0, 1)) }}
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-semibold text-gray-800 dark:text-gray-100">
                                                    {{ $candidate->first_name }} {{ $candidate->last_name }}
                                                </p>
                                                <p class="text-xs text-violet-500 dark:text-violet-400">
                                                    {{ $candidate->partylist?->name ?? 'Independent' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-xl text-gray-800 dark:text-gray-100">{{ $voteCount }}</p>
                                            <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold">
                                                {{ number_format($percentage, 1) }}%
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Progress Bar --}}
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 overflow-hidden">
                                        <div class="bg-gradient-to-r from-violet-600 to-violet-400 h-full rounded-full transition-all duration-500"
                                             style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Position Summary --}}
                        <div class="mt-5 pt-4 border-t border-violet-100 dark:border-violet-800/50 flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">
                                Total votes for this position:
                            </span>
                            <span class="font-bold text-lg text-gray-800 dark:text-gray-100">
                                {{ $position->candidates->sum('votes_count') }}
                            </span>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-3xl text-violet-200 dark:text-violet-800/50 mb-3"></i>
                            <p class="text-gray-500 dark:text-gray-400">No candidates for this position yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-12 text-center">
                <i class="fas fa-inbox text-5xl text-violet-200 dark:text-violet-800/50 mb-4"></i>
                <p class="text-gray-500 dark:text-gray-400 text-lg">No positions found.</p>
            </div>
        @endforelse
    </div>

    {{-- Summary Statistics --}}
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
        @php
            $totalVotes = \App\Models\CastedVote::count();
            $totalCandidates = \App\Models\Candidate::count();
            $totalPositions = \App\Models\Position::count();
        @endphp

        @foreach([
            ['label' => 'Total Votes Cast',      'value' => $totalVotes,        'icon' => 'fa-check-circle',   'color' => 'from-violet-600 to-violet-400'],
            ['label' => 'Total Candidates',      'value' => $totalCandidates,   'icon' => 'fa-users',          'color' => 'from-emerald-600 to-emerald-400'],
            ['label' => 'Total Positions',       'value' => $totalPositions,    'icon' => 'fa-list',           'color' => 'from-sky-600 to-sky-400'],
        ] as $stat)
        <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $stat['color'] }}
                        flex items-center justify-center text-white shadow-md flex-shrink-0">
                <i class="fas {{ $stat['icon'] }} text-sm"></i>
            </div>
            <div>
                <div class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $stat['value'] }}</div>
                <div class="text-xs text-violet-500 dark:text-violet-400 font-medium">{{ $stat['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>
