<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">College Management</h2>
                <p class="text-sm text-violet-600 dark:text-violet-400 mt-0.5">Manage all registered colleges</p>
            </div>
            <a href="{{ route('admin.colleges.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white
                      bg-gradient-to-r from-violet-700 to-violet-500
                      shadow-md shadow-violet-200 dark:shadow-violet-900/40
                      hover:from-violet-800 hover:to-violet-600 hover:-translate-y-0.5
                      transition-all duration-200">
                <i class="fas fa-plus text-xs"></i> Add College
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
            $total = $colleges->total();
            $totalVoters = \App\Models\User::where('role','voter')->count();
            $totalCandidates = \App\Models\Candidate::count();
            $avgVoters = $total > 0 ? round($totalVoters / $total) : 0;
        @endphp

        @foreach([
            ['label' => 'Total Colleges',     'value' => $total,            'icon' => 'fa-building',      'color' => 'from-violet-600 to-violet-400'],
            ['label' => 'Total Voters',      'value' => $totalVoters,      'icon' => 'fa-users',         'color' => 'from-emerald-600 to-emerald-400'],
            ['label' => 'Total Candidates',  'value' => $totalCandidates,  'icon' => 'fa-user-tie',      'color' => 'from-sky-600 to-sky-400'],
            ['label' => 'Avg Voters/College','value' => $avgVoters,        'icon' => 'fa-chart-column',  'color' => 'from-rose-600 to-rose-400'],
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
        <form method="GET" action="{{ route('admin.colleges.index') }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-violet-600 dark:text-violet-400 mb-1">Search</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-violet-300 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="College name or acronym..."
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
                <a href="{{ route('admin.colleges.index') }}"
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
                        <th class="text-left px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">College</th>
                        <th class="text-left px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider hidden md:table-cell">Acronym</th>
                        <th class="text-center px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Voters</th>
                        <th class="text-center px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Candidates</th>
                        <th class="text-right px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-violet-50 dark:divide-violet-800/30">
                    @forelse($colleges as $college)
                    <tr class="hover:bg-violet-50/40 dark:hover:bg-violet-900/20 transition-colors duration-150">
                        {{-- College Name --}}
                        <td class="px-5 py-3.5">
                            <a href="{{ route('admin.colleges.show', $college) }}"
                               class="flex items-center gap-3 hover:opacity-80 transition">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-600 to-violet-400
                                            flex items-center justify-center text-white font-bold text-sm flex-shrink-0
                                            shadow-sm">
                                    {{ strtoupper(substr($college->acronym, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800 dark:text-gray-100">{{ $college->name }}</div>
                                </div>
                            </a>
                        </td>

                        {{-- Acronym --}}
                        <td class="px-5 py-3.5 hidden md:table-cell">
                            <span class="font-mono font-semibold text-gray-600 dark:text-gray-400 bg-violet-100 dark:bg-violet-900/40
                                         px-2.5 py-1 rounded-lg text-xs inline-block">
                                {{ $college->acronym }}
                            </span>
                        </td>

                        {{-- Voters Count --}}
                        <td class="px-5 py-3.5 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold
                                         bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300
                                         border border-emerald-200 dark:border-emerald-700">
                                <i class="fas fa-users text-xs"></i>
                                {{ $college->voters_count ?? 0 }}
                            </span>
                        </td>

                        {{-- Candidates Count --}}
                        <td class="px-5 py-3.5 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold
                                         bg-sky-100 dark:bg-sky-900/30 text-sky-700 dark:text-sky-300
                                         border border-sky-200 dark:border-sky-700">
                                <i class="fas fa-user-tie text-xs"></i>
                                {{ $college->candidates_count ?? 0 }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td class="px-5 py-3.5">
                            <div class="flex items-center justify-end gap-1.5">
                                {{-- View --}}
                                <a href="{{ route('admin.colleges.show', $college) }}"
                                   title="View"
                                   class="w-8 h-8 flex items-center justify-center rounded-lg
                                          text-violet-600 dark:text-violet-400
                                          hover:bg-violet-100 dark:hover:bg-violet-800/40 transition-colors">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('admin.colleges.edit', $college) }}"
                                   title="Edit"
                                   class="w-8 h-8 flex items-center justify-center rounded-lg
                                          text-sky-600 dark:text-sky-400
                                          hover:bg-sky-100 dark:hover:bg-sky-800/40 transition-colors">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>

                                {{-- Delete --}}
                                <button type="button"
                                        title="Delete"
                                        @click="$dispatch('open-modal', 'delete-college-{{ $college->college_id }}')"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg
                                               text-rose-500 dark:text-rose-400
                                               hover:bg-rose-100 dark:hover:bg-rose-800/40 transition-colors">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>

                            {{-- Delete Modal --}}
                            <x-modal name="delete-college-{{ $college->college_id }}" focusable>
                                <div class="p-6">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-12 h-12 rounded-2xl bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-building-slash text-rose-500 text-lg"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-gray-900 dark:text-gray-100">Delete College</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">This action cannot be undone.</p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">
                                        Are you sure you want to delete <strong>{{ $college->name }}</strong>? This college cannot have associated voters or candidates.
                                    </p>
                                    <div class="flex justify-end gap-3">
                                        <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                                        <form method="POST" action="{{ route('admin.colleges.destroy', $college) }}">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold
                                                           text-white bg-rose-600 hover:bg-rose-700 transition-colors">
                                                <i class="fas fa-trash text-xs"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </x-modal>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-2xl bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center">
                                    <i class="fas fa-building text-2xl text-violet-400"></i>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">No colleges found</p>
                                <a href="{{ route('admin.colleges.create') }}"
                                   class="text-sm text-violet-600 dark:text-violet-400 hover:underline">
                                    Add the first college →
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($colleges->hasPages())
            <div class="px-5 py-4 border-t border-violet-100 dark:border-violet-800/50">
                {{ $colleges->withQueryString()->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
