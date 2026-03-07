<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">Voter Management</h2>
                <p class="text-sm text-violet-600 dark:text-violet-400 mt-0.5">Manage all registered voter accounts</p>
            </div>
            <a href="{{ route('admin.voters.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white
                      bg-gradient-to-r from-violet-700 to-violet-500
                      shadow-md shadow-violet-200 dark:shadow-violet-900/40
                      hover:from-violet-800 hover:to-violet-600 hover:-translate-y-0.5
                      transition-all duration-200">
                <i class="fas fa-user-plus text-xs"></i> Add Voter
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
            $total    = $voters->total();
            $active   = \App\Models\User::where('role','voter')->where('status','active')->count();
            $inactive = \App\Models\User::where('role','voter')->where('status','inactive')->count();
            $voted    = \App\Models\User::where('role','voter')->whereHas('votes')->count();
        @endphp

        @foreach([
            ['label' => 'Total Voters',    'value' => $total,    'icon' => 'fa-users',           'color' => 'from-violet-600 to-violet-400'],
            ['label' => 'Active',          'value' => $active,   'icon' => 'fa-circle-check',     'color' => 'from-emerald-600 to-emerald-400'],
            ['label' => 'Inactive',        'value' => $inactive, 'icon' => 'fa-circle-xmark',     'color' => 'from-rose-600 to-rose-400'],
            ['label' => 'Already Voted',   'value' => $voted,    'icon' => 'fa-vote-yea',         'color' => 'from-sky-600 to-sky-400'],
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
        <form method="GET" action="{{ route('admin.voters.index') }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[180px]">
                <label class="block text-xs font-semibold text-violet-600 dark:text-violet-400 mb-1">Search</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-violet-300 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Name, email, student no..."
                           class="w-full pl-8 pr-3 py-2 text-sm rounded-xl
                                  border border-violet-200 dark:border-violet-700
                                  bg-violet-50/50 dark:bg-violet-900/30
                                  text-gray-800 dark:text-gray-200
                                  focus:outline-none focus:ring-2 focus:ring-violet-400
                                  placeholder-violet-300 dark:placeholder-violet-600">
                </div>
            </div>

            <div class="min-w-[160px]">
                <label class="block text-xs font-semibold text-violet-600 dark:text-violet-400 mb-1">College</label>
                <select name="college_id"
                        class="w-full py-2 px-3 text-sm rounded-xl
                               border border-violet-200 dark:border-violet-700
                               bg-violet-50/50 dark:bg-violet-900/30
                               text-gray-800 dark:text-gray-200
                               focus:outline-none focus:ring-2 focus:ring-violet-400">
                    <option value="">All Colleges</option>
                    @foreach($colleges as $college)
                        <option value="{{ $college->college_id }}" {{ request('college_id') == $college->college_id ? 'selected' : '' }}>
                            {{ $college->acronym }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="min-w-[130px]">
                <label class="block text-xs font-semibold text-violet-600 dark:text-violet-400 mb-1">Status</label>
                <select name="status"
                        class="w-full py-2 px-3 text-sm rounded-xl
                               border border-violet-200 dark:border-violet-700
                               bg-violet-50/50 dark:bg-violet-900/30
                               text-gray-800 dark:text-gray-200
                               focus:outline-none focus:ring-2 focus:ring-violet-400">
                    <option value="">All Status</option>
                    <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <button type="submit"
                    class="px-4 py-2 rounded-xl text-sm font-semibold text-white
                           bg-gradient-to-r from-violet-700 to-violet-500
                           hover:from-violet-800 hover:to-violet-600 transition-all duration-200 shadow-sm">
                <i class="fas fa-filter mr-1"></i> Filter
            </button>

            @if(request()->hasAny(['search','college_id','status']))
                <a href="{{ route('admin.voters.index') }}"
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
                        <th class="text-left px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Voter</th>
                        <th class="text-left px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider hidden md:table-cell">Student No.</th>
                        <th class="text-left px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider hidden lg:table-cell">College / Course</th>
                        <th class="text-left px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider hidden sm:table-cell">Year</th>
                        <th class="text-left px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Status</th>
                        <th class="text-right px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-violet-50 dark:divide-violet-800/30">
                    @forelse($voters as $voter)
                    <tr class="hover:bg-violet-50/40 dark:hover:bg-violet-900/20 transition-colors duration-150">
                        {{-- Voter info --}}
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-600 to-violet-400
                                            flex items-center justify-center text-white font-bold text-sm flex-shrink-0
                                            shadow-sm">
                                    {{ strtoupper(substr($voter->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800 dark:text-gray-100">{{ $voter->name }}</div>
                                    <div class="text-xs text-violet-500 dark:text-violet-400">{{ $voter->email }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Student no --}}
                        <td class="px-5 py-3.5 hidden md:table-cell">
                            <span class="font-mono text-xs bg-violet-100 dark:bg-violet-900/40
                                         text-violet-700 dark:text-violet-300 px-2 py-0.5 rounded-lg">
                                {{ $voter->student_number ?? '—' }}
                            </span>
                        </td>

                        {{-- College / Course --}}
                        <td class="px-5 py-3.5 hidden lg:table-cell">
                            <div class="font-medium text-gray-700 dark:text-gray-300">{{ $voter->college->acronym ?? '—' }}</div>
                            <div class="text-xs text-violet-400 dark:text-violet-500">{{ $voter->course ?? '—' }}</div>
                        </td>

                        {{-- Year --}}
                        <td class="px-5 py-3.5 hidden sm:table-cell">
                            <span class="text-gray-600 dark:text-gray-400">
                                {{ $voter->year_level ? $voter->year_level . ($voter->year_level == 1 ? 'st' : ($voter->year_level == 2 ? 'nd' : ($voter->year_level == 3 ? 'rd' : 'th'))) : '—' }}
                            </span>
                        </td>

                        {{-- Status --}}
                        <td class="px-5 py-3.5">
                            @if($voter->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold
                                             bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300
                                             border border-emerald-200 dark:border-emerald-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold
                                             bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400
                                             border border-rose-200 dark:border-rose-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    Inactive
                                </span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-5 py-3.5">
                            <div class="flex items-center justify-end gap-1.5">
                                {{-- View --}}
                                <a href="{{ route('admin.voters.show', $voter) }}"
                                   title="View"
                                   class="w-8 h-8 flex items-center justify-center rounded-lg
                                          text-violet-600 dark:text-violet-400
                                          hover:bg-violet-100 dark:hover:bg-violet-800/40 transition-colors">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('admin.voters.edit', $voter) }}"
                                   title="Edit"
                                   class="w-8 h-8 flex items-center justify-center rounded-lg
                                          text-sky-600 dark:text-sky-400
                                          hover:bg-sky-100 dark:hover:bg-sky-800/40 transition-colors">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>

                                {{-- Toggle Status --}}
                                <form method="POST" action="{{ route('admin.voters.toggle-status', $voter) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                            title="{{ $voter->status === 'active' ? 'Deactivate' : 'Activate' }}"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg transition-colors
                                                   {{ $voter->status === 'active'
                                                       ? 'text-amber-600 dark:text-amber-400 hover:bg-amber-100 dark:hover:bg-amber-800/40'
                                                       : 'text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-800/40' }}">
                                        <i class="fas {{ $voter->status === 'active' ? 'fa-toggle-on' : 'fa-toggle-off' }} text-sm"></i>
                                    </button>
                                </form>

                                {{-- Delete --}}
                                <button type="button"
                                        title="Delete"
                                        @click="$dispatch('open-modal', 'delete-voter-{{ $voter->id }}')"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg
                                               text-rose-500 dark:text-rose-400
                                               hover:bg-rose-100 dark:hover:bg-rose-800/40 transition-colors">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>

                            {{-- Delete Modal --}}
                            <x-modal name="delete-voter-{{ $voter->id }}" focusable>
                                <div class="p-6">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-12 h-12 rounded-2xl bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-user-slash text-rose-500 text-lg"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-gray-900 dark:text-gray-100">Delete Voter Account</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">This action cannot be undone.</p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">
                                        Are you sure you want to delete <strong>{{ $voter->name }}</strong>'s account? All their vote data will also be removed.
                                    </p>
                                    <div class="flex justify-end gap-3">
                                        <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                                        <form method="POST" action="{{ route('admin.voters.destroy', $voter) }}">
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
                        <td colspan="6" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-2xl bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center">
                                    <i class="fas fa-users text-2xl text-violet-400"></i>
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">No voters found</p>
                                <a href="{{ route('admin.voters.create') }}"
                                   class="text-sm text-violet-600 dark:text-violet-400 hover:underline">
                                    Add the first voter →
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($voters->hasPages())
            <div class="px-5 py-4 border-t border-violet-100 dark:border-violet-800/50">
                {{ $voters->withQueryString()->links() }}
            </div>
        @endif
    </div>
</x-app-layout>