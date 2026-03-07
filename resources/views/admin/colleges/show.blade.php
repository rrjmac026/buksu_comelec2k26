<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.colleges.index') }}"
                   class="w-8 h-8 flex items-center justify-center rounded-xl
                          text-violet-600 dark:text-violet-400
                          hover:bg-violet-100 dark:hover:bg-violet-800/40 transition-colors">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">College Profile</h2>
                    <p class="text-sm text-violet-600 dark:text-violet-400 mt-0.5">Viewing details for <strong>{{ $college->name }}</strong></p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.colleges.edit', $college) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold
                          text-violet-600 dark:text-violet-400
                          border border-violet-200 dark:border-violet-700
                          hover:bg-violet-50 dark:hover:bg-violet-900/30 transition-all duration-200">
                    <i class="fas fa-pen text-xs"></i> Edit
                </a>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             class="mb-4 flex items-center gap-3 px-4 py-3 rounded-xl
                    bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700
                    text-emerald-700 dark:text-emerald-300 text-sm font-medium">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Left: College Header --}}
        <div class="lg:col-span-1 space-y-4">

            {{-- College Card --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-6 text-center">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-violet-600 to-violet-400
                            flex items-center justify-center text-white text-3xl font-bold
                            shadow-lg shadow-violet-200 dark:shadow-violet-900/40 mx-auto mb-4">
                    {{ strtoupper(substr($college->acronym, 0, 2)) }}
                </div>
                <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100">{{ $college->name }}</h3>
                <p class="text-sm text-violet-500 dark:text-violet-400 mt-1 font-mono">{{ $college->acronym }}</p>

                <div class="mt-5 pt-4 border-t border-violet-100 dark:border-violet-800/50 space-y-2">
                    <a href="{{ route('admin.colleges.edit', $college) }}"
                       class="w-full py-2 rounded-xl text-sm font-semibold transition-all duration-200
                              text-sky-700 dark:text-sky-400 border border-sky-200 dark:border-sky-700 hover:bg-sky-50 dark:hover:bg-sky-900/20">
                        <i class="fas fa-pen mr-2"></i> Edit College
                    </a>

                    <button type="button" @click="$dispatch('open-modal', 'delete-college')"
                            class="w-full py-2 rounded-xl text-sm font-semibold
                                   text-rose-600 dark:text-rose-400
                                   border border-rose-200 dark:border-rose-700
                                   hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all duration-200">
                        <i class="fas fa-trash mr-2"></i> Delete College
                    </button>
                </div>
            </div>

        </div>

        {{-- Right: Statistics & Details --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Stats Row --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase">Total Voters</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">
                                {{ $college->voters->count() ?? 0 }}
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-50
                                    dark:from-emerald-900/30 dark:to-emerald-900/10 flex items-center justify-center">
                            <i class="fas fa-users text-xl text-emerald-500"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase">Total Candidates</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">
                                {{ $college->candidates->count() ?? 0 }}
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-100 to-sky-50
                                    dark:from-sky-900/30 dark:to-sky-900/10 flex items-center justify-center">
                            <i class="fas fa-user-tie text-xl text-sky-500"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Voters Section --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-violet-100 dark:border-violet-800/50
                            bg-gradient-to-r from-violet-50 to-transparent dark:from-violet-900/20">
                    <h4 class="font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                        <i class="fas fa-users text-violet-500"></i> Recent Voters ({{ $college->voters->count() }})
                    </h4>
                </div>

                @if($college->voters->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-violet-100 dark:border-violet-800/50
                                           bg-gradient-to-r from-violet-50/50 to-transparent
                                           dark:from-violet-900/20">
                                    <th class="text-left px-6 py-3 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase">Name</th>
                                    <th class="text-left px-6 py-3 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase hidden md:table-cell">Email</th>
                                    <th class="text-left px-6 py-3 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-violet-50 dark:divide-violet-800/30">
                                @foreach($college->voters->take(10) as $voter)
                                <tr class="hover:bg-violet-50/30 dark:hover:bg-violet-900/10">
                                    <td class="px-6 py-3 font-medium text-gray-700 dark:text-gray-300">
                                        {{ $voter->name }}
                                    </td>
                                    <td class="px-6 py-3 hidden md:table-cell text-sm text-gray-600 dark:text-gray-400">
                                        {{ $voter->email }}
                                    </td>
                                    <td class="px-6 py-3">
                                        @if($voter->status === 'active')
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold
                                                         bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300
                                                         border border-emerald-200 dark:border-emerald-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold
                                                         bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400
                                                         border border-rose-200 dark:border-rose-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> Inactive
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($college->voters->count() > 10)
                        <div class="px-6 py-3 bg-violet-50/40 dark:bg-violet-900/10 text-center text-sm text-violet-600 dark:text-violet-400 font-medium">
                            Showing 10 of {{ $college->voters->count() }} voters
                        </div>
                    @endif
                @else
                    <div class="px-6 py-8 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <i class="fas fa-users text-3xl text-violet-300 dark:text-violet-700"></i>
                            <p class="text-sm text-gray-500 dark:text-gray-400">No voters from this college</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Candidates Section --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-violet-100 dark:border-violet-800/50
                            bg-gradient-to-r from-violet-50 to-transparent dark:from-violet-900/20">
                    <h4 class="font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                        <i class="fas fa-ballot text-sky-500"></i> Candidates ({{ $college->candidates->count() }})
                    </h4>
                </div>

                @if($college->candidates->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-violet-100 dark:border-violet-800/50
                                           bg-gradient-to-r from-violet-50/50 to-transparent
                                           dark:from-violet-900/20">
                                    <th class="text-left px-6 py-3 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase">Name</th>
                                    <th class="text-left px-6 py-3 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase hidden md:table-cell">Position</th>
                                    <th class="text-left px-6 py-3 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase">Party List</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-violet-50 dark:divide-violet-800/30">
                                @foreach($college->candidates->take(10) as $candidate)
                                <tr class="hover:bg-violet-50/30 dark:hover:bg-violet-900/10">
                                    <td class="px-6 py-3 font-medium text-gray-700 dark:text-gray-300">
                                        {{ $candidate->first_name }} {{ $candidate->last_name }}
                                    </td>
                                    <td class="px-6 py-3 hidden md:table-cell text-sm text-gray-600 dark:text-gray-400">
                                        {{ $candidate->position?->name ?? '—' }}
                                    </td>
                                    <td class="px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $candidate->partylist?->name ?? '—' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($college->candidates->count() > 10)
                        <div class="px-6 py-3 bg-violet-50/40 dark:bg-violet-900/10 text-center text-sm text-violet-600 dark:text-violet-400 font-medium">
                            Showing 10 of {{ $college->candidates->count() }} candidates
                        </div>
                    @endif
                @else
                    <div class="px-6 py-8 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <i class="fas fa-ballot text-3xl text-sky-300 dark:text-sky-700"></i>
                            <p class="text-sm text-gray-500 dark:text-gray-400">No candidates from this college</p>
                        </div>
                    </div>
                @endif
            </div>

        </div>

    </div>

    {{-- Delete Modal --}}
    <x-modal name="delete-college" focusable>
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

</x-app-layout>
