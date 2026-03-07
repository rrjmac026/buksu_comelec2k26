<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.voters.index') }}"
                   class="w-8 h-8 flex items-center justify-center rounded-xl
                          text-violet-600 dark:text-violet-400
                          hover:bg-violet-100 dark:hover:bg-violet-800/40 transition-colors">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">Voter Profile</h2>
                    <p class="text-sm text-violet-600 dark:text-violet-400 mt-0.5">Viewing details for <strong>{{ $voter->name }}</strong></p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.voters.edit', $voter) }}"
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

            {{-- Avatar & Name --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-6 text-center">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-violet-600 to-violet-400
                            flex items-center justify-center text-white text-3xl font-bold
                            shadow-lg shadow-violet-200 dark:shadow-violet-900/40 mx-auto mb-4">
                    {{ strtoupper(substr($voter->name, 0, 1)) }}
                </div>
                <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100">{{ $voter->name }}</h3>
                <p class="text-sm text-violet-500 dark:text-violet-400 mt-0.5">{{ $voter->email }}</p>

                <div class="mt-3">
                    @if($voter->status === 'active')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold
                                     bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300
                                     border border-emerald-200 dark:border-emerald-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold
                                     bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400
                                     border border-rose-200 dark:border-rose-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> Inactive
                        </span>
                    @endif
                </div>

                <div class="mt-5 pt-4 border-t border-violet-100 dark:border-violet-800/50 space-y-2">
                    <form method="POST" action="{{ route('admin.voters.toggle-status', $voter) }}">
                        @csrf @method('PATCH')
                        <button type="submit"
                                class="w-full py-2 rounded-xl text-sm font-semibold transition-all duration-200
                                       {{ $voter->status === 'active'
                                           ? 'text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-700 hover:bg-amber-50 dark:hover:bg-amber-900/20'
                                           : 'text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-700 hover:bg-emerald-50 dark:hover:bg-emerald-900/20' }}">
                            <i class="fas {{ $voter->status === 'active' ? 'fa-ban' : 'fa-circle-check' }} mr-2"></i>
                            {{ $voter->status === 'active' ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>

                    <button type="button" @click="$dispatch('open-modal', 'delete-voter')"
                            class="w-full py-2 rounded-xl text-sm font-semibold
                                   text-rose-600 dark:text-rose-400
                                   border border-rose-200 dark:border-rose-700
                                   hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all duration-200">
                        <i class="fas fa-trash mr-2"></i> Delete Account
                    </button>
                </div>
            </div>

            {{-- Academic Details --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-5">
                <h4 class="font-semibold text-sm text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                    <i class="fas fa-graduation-cap text-violet-500"></i> Academic Info
                </h4>
                <div class="space-y-3">
                    @foreach([
                        ['label' => 'Student No.',  'value' => $voter->student_number ?? '—', 'mono' => true],
                        ['label' => 'College',      'value' => $voter->college?->name ?? '—', 'mono' => false],
                        ['label' => 'Course',       'value' => $voter->course ?? '—',         'mono' => false],
                        ['label' => 'Year Level',   'value' => $voter->year_level ? $voter->year_level . 'th Year' : '—', 'mono' => false],
                        ['label' => 'Sex',          'value' => $voter->sex ? ucfirst($voter->sex) : '—', 'mono' => false],
                    ] as $item)
                    <div class="flex items-start justify-between gap-2">
                        <span class="text-xs text-violet-500 dark:text-violet-400 font-medium shrink-0">{{ $item['label'] }}</span>
                        <span class="text-sm text-gray-700 dark:text-gray-300 text-right {{ $item['mono'] ? 'font-mono' : 'font-medium' }}">
                            {{ $item['value'] }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right: Vote History --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- Vote Summary --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                @php $voteCount = $voter->votes->count(); @endphp
                <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-4 text-center">
                    <div class="text-2xl font-bold text-violet-700 dark:text-violet-300">{{ $voteCount }}</div>
                    <div class="text-xs text-violet-500 dark:text-violet-400 font-medium mt-0.5">Votes Cast</div>
                </div>
                <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-4 text-center">
                    <div class="text-2xl font-bold {{ $voteCount > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-400' }}">
                        {{ $voteCount > 0 ? 'Yes' : 'No' }}
                    </div>
                    <div class="text-xs text-violet-500 dark:text-violet-400 font-medium mt-0.5">Has Voted</div>
                </div>
                <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-4 text-center">
                    <div class="text-xs font-bold text-gray-600 dark:text-gray-300 font-mono">
                        {{ $voter->created_at->format('M d, Y') }}
                    </div>
                    <div class="text-xs text-violet-500 dark:text-violet-400 font-medium mt-0.5">Registered</div>
                </div>
            </div>

            {{-- Vote History Table --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-violet-100 dark:border-violet-800/50
                            bg-gradient-to-r from-violet-50 to-transparent dark:from-violet-900/20">
                    <h4 class="font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                        <i class="fas fa-ballot-check text-violet-500"></i> Vote History
                    </h4>
                </div>

                @if($voter->votes->isEmpty())
                    <div class="py-14 text-center">
                        <div class="w-14 h-14 rounded-2xl bg-violet-100 dark:bg-violet-900/30
                                    flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-box-open text-2xl text-violet-400"></i>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">No votes cast yet</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-violet-100 dark:border-violet-800/50
                                           bg-violet-50/50 dark:bg-violet-900/20">
                                    <th class="text-left px-5 py-3 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Position</th>
                                    <th class="text-left px-5 py-3 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Candidate</th>
                                    <th class="text-left px-5 py-3 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider hidden sm:table-cell">Date & Time</th>
                                    <th class="text-left px-5 py-3 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider hidden md:table-cell">Transaction</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-violet-50 dark:divide-violet-800/30">
                                @foreach($voter->votes as $vote)
                                <tr class="hover:bg-violet-50/40 dark:hover:bg-violet-900/20 transition-colors">
                                    <td class="px-5 py-3.5">
                                        <span class="font-medium text-gray-700 dark:text-gray-300">
                                            {{ $vote->position->name ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="text-gray-800 dark:text-gray-200">
                                            {{ $vote->candidate ? $vote->candidate->first_name . ' ' . $vote->candidate->last_name : '—' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 hidden sm:table-cell">
                                        <span class="text-xs text-violet-500 dark:text-violet-400">
                                            {{ $vote->voted_at?->format('M d, Y h:i A') ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 hidden md:table-cell">
                                        <span class="font-mono text-xs bg-violet-100 dark:bg-violet-900/40
                                                     text-violet-700 dark:text-violet-300 px-2 py-0.5 rounded-lg">
                                            {{ $vote->transaction_number ?? '—' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <x-modal name="delete-voter" focusable>
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
                Are you sure you want to permanently delete <strong>{{ $voter->name }}</strong>'s account? All associated vote data will be removed.
            </p>
            <div class="flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                <form method="POST" action="{{ route('admin.voters.destroy', $voter) }}">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold
                                   text-white bg-rose-600 hover:bg-rose-700 transition-colors">
                        <i class="fas fa-trash text-xs"></i> Delete Account
                    </button>
                </form>
            </div>
        </div>
    </x-modal>
</x-app-layout>