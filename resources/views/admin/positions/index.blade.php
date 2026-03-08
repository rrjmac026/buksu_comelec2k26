<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">Position Management</h2>
                <p class="text-sm text-violet-600 dark:text-violet-400 mt-0.5">Manage all election positions</p>
            </div>
            <a href="{{ route('admin.positions.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white
                      bg-gradient-to-r from-violet-700 to-violet-500
                      shadow-md shadow-violet-200 dark:shadow-violet-900/40
                      hover:from-violet-800 hover:to-violet-600 hover:-translate-y-0.5
                      transition-all duration-200">
                <i class="fas fa-plus text-xs"></i> Add Position
            </a>
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
            $total = $positions->total();
            $totalCandidates = \App\Models\Candidate::count();
            $totalVotes = \App\Models\CastedVote::count();
            $avgCandidates = $total > 0 ? round($totalCandidates / $total) : 0;
        @endphp

        @foreach([
            ['label' => 'Total Positions',     'value' => $total,            'icon' => 'fa-sitemap',        'color' => 'from-violet-600 to-violet-400'],
            ['label' => 'Total Candidates',    'value' => $totalCandidates,  'icon' => 'fa-users',          'color' => 'from-emerald-600 to-emerald-400'],
            ['label' => 'Total Votes',         'value' => $totalVotes,       'icon' => 'fa-check-double',   'color' => 'from-sky-600 to-sky-400'],
            ['label' => 'Avg Candidates/Pos',  'value' => $avgCandidates,    'icon' => 'fa-chart-column',   'color' => 'from-rose-600 to-rose-400'],
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

    {{-- Search Bar --}}
    <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-4 mb-4">
        <form method="GET" action="{{ route('admin.positions.index') }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-violet-600 dark:text-violet-400 mb-1">Search</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-violet-300 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Position name..."
                           class="w-full pl-8 pr-3 py-2 text-sm rounded-xl
                                  border border-violet-200 dark:border-violet-700
                                  bg-violet-50/50 dark:bg-violet-900/30
                                  text-gray-800 dark:text-gray-200
                                  focus:outline-none focus:ring-2 focus:ring-violet-400
                                  placeholder-violet-300 dark:placeholder-violet-600">
                </div>
            </div>

            <button type="submit"
                    class="px-4 py-2 rounded-xl text-sm font-semibold text-white
                           bg-gradient-to-r from-violet-700 to-violet-500
                           hover:from-violet-800 hover:to-violet-600 transition-all duration-200 shadow-sm">
                <i class="fas fa-filter mr-1"></i> Search
            </button>

            @if(request('search'))
                <a href="{{ route('admin.positions.index') }}"
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
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-violet-100 dark:border-violet-800/50
                               bg-gradient-to-r from-violet-50 to-violet-50/30
                               dark:from-violet-900/30 dark:to-transparent">
                        <th class="text-left px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Position</th>
                        <th class="text-center px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Candidates</th>
                        <th class="text-right px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-violet-50 dark:divide-violet-800/30">
                    @forelse($positions as $position)
                    <tr class="hover:bg-violet-50/40 dark:hover:bg-violet-900/20 transition-colors duration-150">
                        {{-- Position Name --}}
                        <td class="px-5 py-3.5">
                            <a href="{{ route('admin.positions.show', $position) }}"
                               class="flex items-center gap-3 hover:opacity-80 transition">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-600 to-violet-400
                                            flex items-center justify-center text-white font-bold text-sm flex-shrink-0
                                            shadow-sm">
                                    <i class="fas fa-sitemap text-xs"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800 dark:text-gray-100">{{ $position->name }}</div>
                                </div>
                            </a>
                        </td>

                        {{-- Candidates Count --}}
                        <td class="px-5 py-3.5 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold
                                         bg-sky-100 dark:bg-sky-900/30 text-sky-700 dark:text-sky-300">
                                <i class="fas fa-users text-xs"></i> {{ $position->candidates_count ?? 0 }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td class="px-5 py-3.5">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.positions.show', $position) }}"
                                   class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold
                                          text-sky-600 dark:text-sky-400 border border-sky-200 dark:border-sky-700
                                          hover:bg-sky-50 dark:hover:bg-sky-900/30 transition-all duration-200">
                                    <i class="fas fa-eye text-xs"></i> View
                                </a>
                                <a href="{{ route('admin.positions.edit', $position) }}"
                                   class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold
                                          text-violet-600 dark:text-violet-400 border border-violet-200 dark:border-violet-700
                                          hover:bg-violet-50 dark:hover:bg-violet-900/30 transition-all duration-200">
                                    <i class="fas fa-pen text-xs"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.positions.destroy', $position) }}"
                                      style="display:inline-block;"
                                      onsubmit="return confirm('Are you sure? This cannot be undone.') && ({{ $position->candidates_count ?? 0 }} === 0 || confirm('This position has candidates. Are you sure?'));">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold
                                                   text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-700
                                                   hover:bg-rose-50 dark:hover:bg-rose-900/30 transition-all duration-200">
                                        <i class="fas fa-trash text-xs"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-5 py-8 text-center">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <i class="fas fa-inbox text-3xl text-violet-300 dark:text-violet-700"></i>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">No positions found.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $positions->links() }}
    </div>
</x-app-layout>
