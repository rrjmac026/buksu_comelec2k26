<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">Organization Management</h2>
                <p class="text-sm text-violet-600 dark:text-violet-400 mt-0.5">Manage all registered organizations</p>
            </div>
            <a href="{{ route('admin.organizations.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white
                      bg-gradient-to-r from-violet-700 to-violet-500
                      shadow-md shadow-violet-200 dark:shadow-violet-900/40
                      hover:from-violet-800 hover:to-violet-600 hover:-translate-y-0.5
                      transition-all duration-200">
                <i class="fas fa-plus text-xs"></i> Add Organization
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
            $total           = $organizations->total();
            $totalCandidates = $organizations->sum('candidates_count');
            $collegesCount   = $organizations->groupBy('college_id')->count();
            $totalPositions  = \App\Models\Position::count();
        @endphp

        @foreach([
            ['label' => 'Total Organizations', 'value' => $total,            'icon' => 'fa-sitemap',  'color' => 'from-violet-600 to-violet-400'],
            ['label' => 'Total Positions',     'value' => $totalPositions,   'icon' => 'fa-list',     'color' => 'from-emerald-600 to-emerald-400'],
            ['label' => 'Colleges',            'value' => $collegesCount,    'icon' => 'fa-building', 'color' => 'from-sky-600 to-sky-400'],
            ['label' => 'Total Candidates',    'value' => $totalCandidates,  'icon' => 'fa-user-tie', 'color' => 'from-rose-600 to-rose-400'],
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
        <form method="GET" action="{{ route('admin.organizations.index') }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-violet-600 dark:text-violet-400 mb-1">Search</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-violet-300 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Organization name..."
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
                    @foreach(\App\Models\College::orderBy('name')->get() as $college)
                        <option value="{{ $college->id }}" {{ request('college_id') == $college->id ? 'selected' : '' }}>
                            {{ $college->acronym }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                    class="px-4 py-2 rounded-xl text-sm font-semibold text-white
                           bg-gradient-to-r from-violet-700 to-violet-500
                           hover:from-violet-800 hover:to-violet-600 transition-all duration-200 shadow-sm">
                <i class="fas fa-filter mr-1"></i> Search
            </button>

            @if(request('search') || request('college_id'))
                <a href="{{ route('admin.organizations.index') }}"
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
                        <th class="text-left px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Organization</th>
                        <th class="text-left px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider hidden md:table-cell">College</th>
                        <th class="text-center px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Candidates</th>
                        <th class="text-right px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-violet-50 dark:divide-violet-800/30">
                    @forelse($organizations as $organization)
                    <tr class="hover:bg-violet-50/40 dark:hover:bg-violet-900/20 transition-colors duration-150">
                        {{-- Organization Name --}}
                        <td class="px-5 py-3.5">
                            <a href="{{ route('admin.organizations.show', $organization) }}"
                               class="flex items-center gap-3 hover:opacity-80 transition">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-600 to-violet-400
                                            flex items-center justify-center text-white font-bold text-sm flex-shrink-0
                                            shadow-sm">
                                    {{ strtoupper(substr($organization->acronym ?? $organization->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800 dark:text-gray-100">{{ $organization->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 line-clamp-1">
                                        {{ $organization->acronym ? $organization->acronym . ' — ' : '' }}{{ $organization->description ?? '—' }}
                                    </div>
                                </div>
                            </a>
                        </td>

                        {{-- College --}}
                        <td class="px-5 py-3.5 hidden md:table-cell">
                            <span class="font-mono font-semibold text-gray-600 dark:text-gray-400 bg-violet-100 dark:bg-violet-900/40
                                         px-2.5 py-1 rounded-lg text-xs inline-block">
                                {{ $organization->college?->acronym ?? '—' }}
                            </span>
                        </td>

                        {{-- Candidates Count --}}
                        <td class="px-5 py-3.5 text-center">
                            <span class="inline-flex items-center gap-1.5">
                                <i class="fas fa-user-tie text-violet-500"></i>
                                <strong class="text-gray-800 dark:text-gray-100">{{ $organization->candidates_count ?? 0 }}</strong>
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.organizations.show', $organization) }}"
                                   class="p-2 rounded-lg text-sky-600 dark:text-sky-400
                                          hover:bg-sky-50 dark:hover:bg-sky-900/20 transition"
                                   title="View Details">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('admin.organizations.edit', $organization) }}"
                                   class="p-2 rounded-lg text-emerald-600 dark:text-emerald-400
                                          hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition"
                                   title="Edit">
                                    <i class="fas fa-pen text-sm"></i>
                                </a>
                                <button type="button" @click="$dispatch('open-modal', 'delete-org-{{ $organization->id }}')"
                                        class="p-2 rounded-lg text-rose-600 dark:text-rose-400
                                               hover:bg-rose-50 dark:hover:bg-rose-900/20 transition"
                                        title="Delete">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </div>

                            {{-- Delete Modal --}}
                            <x-modal name="delete-org-{{ $organization->id }}" :show="false" maxWidth="sm">
                                <div class="p-6">
                                    <div class="text-center mb-4">
                                        <div class="mx-auto w-12 h-12 rounded-full bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center">
                                            <i class="fas fa-trash-can text-rose-600 dark:text-rose-400 text-lg"></i>
                                        </div>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 text-center">
                                        Delete Organization?
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm text-center mt-2">
                                        Are you sure you want to delete <strong>{{ $organization->name }}</strong>? This action cannot be undone.
                                    </p>
                                    <div class="mt-6 flex gap-3 justify-center">
                                        <button @click="$dispatch('close')"
                                                class="px-4 py-2 rounded-xl text-sm font-semibold
                                                       text-gray-700 dark:text-gray-300
                                                       border border-gray-200 dark:border-gray-700
                                                       hover:bg-gray-50 dark:hover:bg-gray-900/30 transition">
                                            Cancel
                                        </button>
                                        <form method="POST" action="{{ route('admin.organizations.destroy', $organization) }}" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="px-4 py-2 rounded-xl text-sm font-semibold text-white
                                                           bg-gradient-to-r from-rose-600 to-rose-500
                                                           hover:from-rose-700 hover:to-rose-600 transition">
                                                <i class="fas fa-trash mr-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </x-modal>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <i class="fas fa-inbox text-4xl text-violet-200 dark:text-violet-800"></i>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">No organizations found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $organizations->links() }}
    </div>
</x-app-layout>