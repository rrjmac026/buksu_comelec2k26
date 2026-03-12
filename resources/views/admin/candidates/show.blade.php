<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.candidates.index') }}"
                   class="w-8 h-8 flex items-center justify-center rounded-xl
                          text-violet-600 dark:text-violet-400
                          hover:bg-violet-100 dark:hover:bg-violet-800/40 transition-colors">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">Candidate Profile</h2>
                    <p class="text-sm text-violet-600 dark:text-violet-400 mt-0.5">Viewing details for <strong>{{ $candidate->first_name }} {{ $candidate->last_name }}</strong></p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.candidates.edit', $candidate) }}"
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

        {{-- Left: Profile Card --}}
        <div class="lg:col-span-1 space-y-4">

            {{-- Photo & Name --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-6 text-center">
                <div class="w-32 h-32 rounded-2xl bg-gradient-to-br from-violet-600 to-violet-400
                            flex items-center justify-center text-white text-5xl font-bold
                            shadow-lg shadow-violet-200 dark:shadow-violet-900/40 mx-auto mb-4 overflow-hidden">
                    @if($candidate->photo)
                        <img src="{{ asset('images/candidates/' . $candidate->photo) }}" alt="{{ $candidate->first_name }}" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($candidate->first_name, 0, 1)) }}
                    @endif
                </div>
                <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100">
                    {{ $candidate->first_name }} {{ $candidate->middle_name ?? '' }} {{ $candidate->last_name }}
                </h3>
                <p class="text-sm text-violet-500 dark:text-violet-400 mt-0.5">{{ $candidate->position?->name ?? 'No position' }}</p>

                <div class="mt-5 pt-4 border-t border-violet-100 dark:border-violet-800/50 space-y-2">
                    <a href="{{ route('admin.candidates.edit', $candidate) }}"
                       class="block w-full py-2 rounded-xl text-sm font-semibold transition-all duration-200
                              text-sky-700 dark:text-sky-400 border border-sky-200 dark:border-sky-700 hover:bg-sky-50 dark:hover:bg-sky-900/20">
                        <i class="fas fa-pen mr-2"></i> Edit Candidate
                    </a>

                    <button type="button" @click="$dispatch('open-modal', 'delete-candidate')"
                            class="w-full py-2 rounded-xl text-sm font-semibold
                                   text-rose-600 dark:text-rose-400
                                   border border-rose-200 dark:border-rose-700
                                   hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all duration-200">
                        <i class="fas fa-trash mr-2"></i> Delete Candidate
                    </button>
                </div>
            </div>

            {{-- Academic Details --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-5">
                <h4 class="font-semibold text-sm text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                    <i class="fas fa-graduation-cap text-violet-500"></i> Academic Info
                </h4>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase">College</p>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-0.5">{{ $candidate->college?->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase">Course</p>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-0.5">{{ $candidate->course ?? '—' }}</p>
                    </div>
                </div>
            </div>

            {{-- Election Details --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-5">
                <h4 class="font-semibold text-sm text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                    <i class="fas fa-vote-yea text-emerald-500"></i> Election Info
                </h4>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase">Position</p>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-0.5">{{ $candidate->position?->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase">Party List</p>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-0.5">{{ $candidate->partylist?->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase">Organization</p>
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-0.5">{{ $candidate->organization?->name ?? '—' }}</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Right: Details --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Vote Statistics --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase">Total Votes</p>
                            {{-- Use votes() — that is the correct relationship name --}}
                            <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">
                                {{ $candidate->votes()->count() }}
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-100 to-sky-50
                                    dark:from-sky-900/30 dark:to-sky-900/10 flex items-center justify-center">
                            <i class="fas fa-vote-yea text-xl text-sky-500"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase">Created Date</p>
                            <p class="text-lg font-bold text-gray-800 dark:text-gray-100 mt-1">
                                {{ $candidate->created_at->format('M d, Y') }}
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-violet-100 to-violet-50
                                    dark:from-violet-900/30 dark:to-violet-900/10 flex items-center justify-center">
                            <i class="fas fa-calendar text-xl text-violet-500"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Platform --}}
            @if($candidate->platform)
                <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-6">
                    <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                        <i class="fas fa-microphone text-rose-500"></i> Campaign Platform
                    </h4>
                    <div class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed whitespace-pre-wrap">
                        {{ $candidate->platform }}
                    </div>
                </div>
            @endif

            {{-- Recent Votes --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-violet-100 dark:border-violet-800/50
                            bg-gradient-to-r from-violet-50 to-transparent dark:from-violet-900/20">
                    <h4 class="font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                        <i class="fas fa-list text-violet-500"></i> Recent Votes
                    </h4>
                </div>

                {{-- Use votes() — the correct relationship name --}}
                @if($candidate->votes()->exists())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-violet-100 dark:border-violet-800/50
                                           bg-gradient-to-r from-violet-50/50 to-transparent
                                           dark:from-violet-900/20">
                                    <th class="text-left px-6 py-3 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase">Transaction</th>
                                    <th class="text-left px-6 py-3 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase hidden md:table-cell">Voter</th>
                                    <th class="text-left px-6 py-3 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-violet-50 dark:divide-violet-800/30">
                                @foreach($candidate->votes()->with('voter')->latest('voted_at')->take(10)->get() as $vote)
                                <tr class="hover:bg-violet-50/30 dark:hover:bg-violet-900/10">
                                    <td class="px-6 py-3 font-mono text-xs text-gray-600 dark:text-gray-400">
                                        {{ $vote->transaction_number ?? '—' }}
                                    </td>
                                    <td class="px-6 py-3 hidden md:table-cell">
                                        <div class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{-- User model uses first_name/last_name, not name --}}
                                            {{ $vote->voter ? $vote->voter->full_name : 'Anonymous' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $vote->voted_at?->format('M d, Y H:i') ?? '—' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($candidate->votes()->count() > 10)
                        <div class="px-6 py-3 bg-violet-50/40 dark:bg-violet-900/10 text-center text-sm text-violet-600 dark:text-violet-400 font-medium">
                            Showing 10 of {{ $candidate->votes()->count() }} votes
                        </div>
                    @endif
                @else
                    <div class="px-6 py-8 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <i class="fas fa-inbox text-3xl text-violet-300 dark:text-violet-700"></i>
                            <p class="text-sm text-gray-500 dark:text-gray-400">No votes yet</p>
                        </div>
                    </div>
                @endif
            </div>

        </div>

    </div>

    {{-- Delete Modal --}}
    <x-modal name="delete-candidate" focusable>
        <div class="p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user-slash text-rose-500 text-lg"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-gray-100">Delete Candidate</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">This action cannot be undone.</p>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">
                Are you sure you want to delete <strong>{{ $candidate->first_name }} {{ $candidate->last_name }}</strong>? All associated data will be removed.
            </p>
            <div class="flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                <form method="POST" action="{{ route('admin.candidates.destroy', $candidate) }}">
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