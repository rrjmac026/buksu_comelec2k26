<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">Casted Votes Management</h2>
                <p class="text-sm text-violet-600 dark:text-violet-400 mt-0.5">Monitor and manage voter participation</p>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="mb-4 flex items-center gap-3 px-4 py-3 rounded-xl
                    bg-emerald-50 dark:bg-emerald-900/20
                    border border-emerald-200 dark:border-emerald-700
                    text-emerald-700 dark:text-emerald-300 text-sm font-medium">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             class="mb-4 flex items-center gap-3 px-4 py-3 rounded-xl
                    bg-red-50 dark:bg-red-900/20
                    border border-red-200 dark:border-red-700
                    text-red-700 dark:text-red-300 text-sm font-medium">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Stats Row --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        @php
            $totalVotes = $votes->total();
            $totalVoters = \App\Models\CastedVote::distinct('voter_id')->count('voter_id');
            $totalPositions = $positions->count();
        @endphp

        @foreach([
            ['label' => 'Total Votes Cast',    'value' => $totalVotes,      'icon' => 'fa-check-circle',   'color' => 'from-violet-600 to-violet-400'],
            ['label' => 'Unique Voters',       'value' => $totalVoters,     'icon' => 'fa-users',          'color' => 'from-emerald-600 to-emerald-400'],
            ['label' => 'Positions',           'value' => $totalPositions,  'icon' => 'fa-list',           'color' => 'from-sky-600 to-sky-400'],
            ['label' => 'Voter Turnout',       'value' => $totalVoters > 0 ? round(($totalVoters / \App\Models\User::count()) * 100) . '%' : '0%',  'icon' => 'fa-percent',        'color' => 'from-rose-600 to-rose-400'],
        ] as $stat)
        <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50
                    shadow-sm p-4 flex items-center gap-3">
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

    {{-- Filter Bar --}}
    <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-4 mb-4">
        <form method="GET" action="{{ route('admin.votes.index') }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[180px]">
                <label class="block text-xs font-semibold text-violet-600 dark:text-violet-400 mb-1">Search</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-violet-300 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Voter name, email, transaction..."
                           class="w-full pl-8 pr-3 py-2 text-sm rounded-xl
                                  border border-violet-200 dark:border-violet-700
                                  bg-violet-50/50 dark:bg-violet-900/30
                                  text-gray-800 dark:text-gray-200
                                  focus:outline-none focus:ring-2 focus:ring-violet-400
                                  placeholder-violet-300 dark:placeholder-violet-600">
                </div>
            </div>

            <div class="min-w-[160px]">
                <label class="block text-xs font-semibold text-violet-600 dark:text-violet-400 mb-1">Position</label>
                <select name="position_id"
                        class="w-full py-2 px-3 text-sm rounded-xl
                               border border-violet-200 dark:border-violet-700
                               bg-violet-50/50 dark:bg-violet-900/30
                               text-gray-800 dark:text-gray-200
                               focus:outline-none focus:ring-2 focus:ring-violet-400">
                    <option value="">All Positions</option>
                    @foreach($positions as $position)
                        <option value="{{ $position->position_id }}" {{ request('position_id') == $position->position_id ? 'selected' : '' }}>
                            {{ $position->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                    class="px-4 py-2 rounded-xl text-sm font-semibold text-white
                           bg-gradient-to-r from-violet-700 to-violet-500
                           hover:from-violet-800 hover:to-violet-600 transition-all duration-200 shadow-sm">
                <i class="fas fa-filter mr-1"></i> Filter
            </button>

            @if(request()->hasAny(['search','position_id']))
                <a href="{{ route('admin.votes.index') }}"
                   class="px-4 py-2 rounded-xl text-sm font-semibold
                          text-violet-600 dark:text-violet-400
                          border border-violet-200 dark:border-violet-700
                          hover:bg-violet-50 dark:hover:bg-violet-900/30 transition-all duration-200">
                    <i class="fas fa-xmark mr-1"></i> Clear
                </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm overflow-hidden">
        @if($votes->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-violet-100 dark:border-violet-800/50
                                   bg-gradient-to-r from-violet-50 to-violet-50/30
                                   dark:from-violet-900/30 dark:to-transparent">
                            <th class="text-left px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Voter</th>
                            <th class="text-left px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Position</th>
                            <th class="text-left px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Candidate</th>
                            <th class="text-left px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Transaction ID</th>
                            <th class="text-left px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Voted At</th>
                            <th class="text-center px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-violet-100 dark:divide-violet-800/50">
                        @foreach($votes as $vote)
                            <tr class="hover:bg-violet-50/50 dark:hover:bg-violet-800/20 transition-colors">
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-violet-600 to-violet-400
                                                    flex items-center justify-center text-white font-semibold text-xs">
                                            {{ strtoupper(substr($vote->voter->full_name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800 dark:text-gray-100">{{ $vote->voter->full_name ?? 'Unknown' }}</p>
                                            <p class="text-xs text-violet-500 dark:text-violet-400">{{ $vote->voter->email ?? '—' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $vote->position->name ?? '—' }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $vote->candidate->first_name ?? '—' }} {{ $vote->candidate->last_name ?? '' }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5">
                                    <code class="text-xs font-mono bg-violet-100/50 dark:bg-violet-900/30
                                               text-violet-700 dark:text-violet-300 px-2.5 py-1 rounded-lg">
                                        {{ substr($vote->transaction_number ?? 'N/A', 0, 12) }}{{ strlen($vote->transaction_number ?? '') > 12 ? '...' : '' }}
                                    </code>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ $vote->voted_at?->diffForHumans() ?? '—' }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.votes.show', $vote) }}"
                                           class="w-8 h-8 inline-flex items-center justify-center rounded-lg
                                                  text-sky-600 dark:text-sky-400
                                                  hover:bg-sky-100 dark:hover:bg-sky-900/30 transition-colors"
                                           title="View">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                        <button type="button"
                                                @click="$dispatch('open-modal', 'delete-vote-{{ $vote->casted_vote_id }}')"
                                                class="w-8 h-8 inline-flex items-center justify-center rounded-lg
                                                       text-rose-600 dark:text-rose-400
                                                       hover:bg-rose-100 dark:hover:bg-rose-900/30 transition-colors"
                                                title="Delete">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </div>

                                    {{-- Delete Modal --}}
                                    <x-modal name="delete-vote-{{ $vote->casted_vote_id }}" focusable>
                                        <div class="p-6">
                                            <div class="flex items-center gap-4 mb-4">
                                                <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-lg
                                                            bg-rose-100 dark:bg-rose-900/30">
                                                    <i class="fas fa-exclamation-triangle text-rose-600 dark:text-rose-400"></i>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Delete Vote Record</h3>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                        Are you sure you want to delete this vote record?
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex gap-3 mt-6">
                                                <button type="button"
                                                        @click="$dispatch('close-modal', 'delete-vote-{{ $vote->casted_vote_id }}')"
                                                        class="flex-1 px-4 py-2 rounded-lg text-sm font-medium
                                                               text-gray-700 dark:text-gray-300
                                                               bg-gray-100 dark:bg-gray-800
                                                               hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                                    Cancel
                                                </button>
                                                <form method="POST" action="{{ route('admin.votes.destroy', $vote) }}" class="flex-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="w-full px-4 py-2 rounded-lg text-sm font-medium
                                                                   text-white bg-rose-600 hover:bg-rose-700 transition-colors">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </x-modal>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="px-5 py-4 border-t border-violet-100 dark:border-violet-800/50">
                {{ $votes->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-inbox text-4xl text-violet-200 dark:text-violet-800/50 mb-4"></i>
                <p class="text-gray-500 dark:text-gray-400">No vote records found.</p>
            </div>
        @endif
    </div>
</x-app-layout>
