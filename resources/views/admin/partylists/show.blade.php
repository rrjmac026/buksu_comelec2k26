<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.partylists.index') }}"
                   class="w-8 h-8 flex items-center justify-center rounded-xl
                          text-violet-600 dark:text-violet-400
                          hover:bg-violet-100 dark:hover:bg-violet-800/40 transition-colors">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">Partylist Profile</h2>
                    <p class="text-sm text-violet-600 dark:text-violet-400 mt-0.5">Viewing details for <strong>{{ $partylist->name }}</strong></p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.partylists.edit', $partylist) }}"
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

        {{-- Left: Partylist Header --}}
        <div class="lg:col-span-1 space-y-4">

            {{-- Partylist Card --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-6 text-center">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-violet-600 to-violet-400
                            flex items-center justify-center text-white text-2xl
                            shadow-lg shadow-violet-200 dark:shadow-violet-900/40 mx-auto mb-4">
                    <i class="fas fa-flag"></i>
                </div>
                <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100">{{ $partylist->name }}</h3>
                @if($partylist->description)
                    <p class="text-sm text-violet-500 dark:text-violet-400 mt-2 line-clamp-3">{{ $partylist->description }}</p>
                @endif

                <div class="mt-5 pt-4 border-t border-violet-100 dark:border-violet-800/50 space-y-2">
                    <a href="{{ route('admin.partylists.edit', $partylist) }}"
                       class="w-full py-2 rounded-xl text-sm font-semibold transition-all duration-200
                              text-sky-700 dark:text-sky-400 border border-sky-200 dark:border-sky-700 hover:bg-sky-50 dark:hover:bg-sky-900/20">
                        <i class="fas fa-pen mr-2"></i> Edit Partylist
                    </a>

                    <button type="button" @click="$dispatch('open-modal', 'delete-partylist')"
                            class="w-full py-2 rounded-xl text-sm font-semibold
                                   text-rose-600 dark:text-rose-400
                                   border border-rose-200 dark:border-rose-700
                                   hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all duration-200">
                        <i class="fas fa-trash mr-2"></i> Delete Partylist
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
                            <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase">Total Candidates</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">
                                {{ $partylist->candidates->count() ?? 0 }}
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-100 to-sky-50
                                    dark:from-sky-900/30 dark:to-sky-900/10 flex items-center justify-center">
                            <i class="fas fa-user-tie text-xl text-sky-500"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase">Total Votes</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">
                                {{ \App\Models\CastedVote::whereIn('candidate_id', $partylist->candidates->pluck('id'))->count() ?? 0 }}
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-50
                                    dark:from-emerald-900/30 dark:to-emerald-900/10 flex items-center justify-center">
                            <i class="fas fa-check-double text-xl text-emerald-500"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Candidates Section --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-violet-100 dark:border-violet-800/50
                            bg-gradient-to-r from-violet-50 to-transparent dark:from-violet-900/20">
                    <h4 class="font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                        <i class="fas fa-user-tie text-violet-500"></i> Candidates ({{ $partylist->candidates->count() }})
                    </h4>
                </div>

                @if($partylist->candidates->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-violet-100 dark:border-violet-800/50
                                           bg-gradient-to-r from-violet-50/50 to-transparent
                                           dark:from-violet-900/20">
                                    <th class="text-left px-6 py-3 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase">Name</th>
                                    <th class="text-left px-6 py-3 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase hidden md:table-cell">Position</th>
                                    <th class="text-left px-6 py-3 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase hidden lg:table-cell">College</th>
                                    <th class="text-center px-6 py-3 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase">Votes</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-violet-50 dark:divide-violet-800/30">
                                @foreach($partylist->candidates as $candidate)
                                <tr class="hover:bg-violet-50/30 dark:hover:bg-violet-900/10">
                                    <td class="px-6 py-3">
                                        <a href="{{ route('admin.candidates.show', $candidate) }}"
                                           class="font-medium text-gray-700 dark:text-gray-300 hover:text-violet-600 dark:hover:text-violet-400 transition">
                                            {{ $candidate->first_name }} {{ $candidate->last_name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-3 hidden md:table-cell text-sm text-gray-600 dark:text-gray-400">
                                        @if($candidate->position)
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold
                                                         bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300
                                                         border border-violet-200 dark:border-violet-700">
                                                {{ $candidate->position->name }}
                                            </span>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 hidden lg:table-cell text-sm text-gray-600 dark:text-gray-400">
                                        @if($candidate->college)
                                            {{ $candidate->college->name }}
                                        @else
                                            <span class="text-gray-500 dark:text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        <span class="inline-flex items-center justify-center px-3 py-1 rounded-lg text-xs font-bold
                                                   bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300">
                                            {{ \App\Models\CastedVote::where('candidate_id', $candidate->id)->count() }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="px-6 py-8 text-center">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i class="fas fa-inbox text-3xl text-violet-300 dark:text-violet-700"></i>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">No candidates in this partylist yet.</p>
                        </div>
                    </div>
                @endif
            </div>

        </div>

    </div>

    {{-- Delete Modal --}}
    <x-modal name="delete-partylist" focusable maxWidth="md">
        <div class="p-6">
            <div class="flex items-start gap-4 mb-4">
                <div class="w-12 h-12 rounded-full bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exclamation text-xl text-rose-600 dark:text-rose-400"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">Delete Partylist</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Are you sure you want to delete <strong>{{ $partylist->name }}</strong>?</p>
                </div>
            </div>

            @if($partylist->candidates->count() > 0)
                <div class="mb-4 p-3 rounded-lg bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-700">
                    <p class="text-xs text-rose-600 dark:text-rose-400 flex items-center gap-2">
                        <i class="fas fa-warning"></i> This partylist has {{ $partylist->candidates->count() }} candidate(s). Deleting it may affect election data.
                    </p>
                </div>
            @endif

            <div class="flex gap-3">
                <button @click="$dispatch('close-modal', 'delete-partylist')"
                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold
                               text-gray-700 dark:text-gray-300
                               border border-gray-200 dark:border-gray-700
                               hover:bg-gray-50 dark:hover:bg-gray-900/30 transition-all duration-200">
                    Cancel
                </button>
                <form method="POST" action="{{ route('admin.partylists.destroy', $partylist) }}" style="flex: 1;">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="w-full px-4 py-2.5 rounded-xl text-sm font-semibold text-white
                                   bg-gradient-to-r from-rose-600 to-rose-500
                                   hover:from-rose-700 hover:to-rose-600 transition-all duration-200">
                        <i class="fas fa-trash mr-2"></i> Delete Permanently
                    </button>
                </form>
            </div>
        </div>
    </x-modal>

</x-app-layout>
