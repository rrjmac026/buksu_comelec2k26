<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.votes.index') }}"
                   class="w-8 h-8 flex items-center justify-center rounded-xl
                          text-violet-600 dark:text-violet-400
                          hover:bg-violet-100 dark:hover:bg-violet-800/40 transition-colors">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">Vote Record</h2>
                    <p class="text-sm text-violet-600 dark:text-violet-400 mt-0.5">Transaction: <strong>{{ $castedVote->transaction_number }}</strong></p>
                </div>
            </div>
            <button type="button" @click="$dispatch('open-modal', 'delete-vote')"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold
                           text-rose-600 dark:text-rose-400
                           border border-rose-200 dark:border-rose-700
                           hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all duration-200">
                <i class="fas fa-trash text-xs"></i> Delete
            </button>
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

        {{-- Left: Vote Summary Card --}}
        <div class="lg:col-span-1 space-y-4">

            {{-- Main Vote Info --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-6">
                <div class="text-center mb-4">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-600 to-emerald-400
                                flex items-center justify-center text-white text-2xl font-bold
                                shadow-lg shadow-emerald-200 dark:shadow-emerald-900/40 mx-auto">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100 mt-3">Vote Casted</h3>
                    <p class="text-sm text-violet-500 dark:text-violet-400 mt-1">
                        {{ $castedVote->voted_at?->format('M d, Y • H:i A') ?? 'Date unknown' }}
                    </p>
                </div>

                <div class="space-y-3 pt-4 border-t border-violet-100 dark:border-violet-800/50">
                    <div class="flex justify-between items-center">
                        <span class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase">Status</span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-emerald-100 dark:bg-emerald-900/30
                                   text-emerald-700 dark:text-emerald-300 text-xs font-semibold">
                            <i class="fas fa-circle text-xs"></i> Confirmed
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase mb-1">Transaction ID</p>
                        <code class="text-xs font-mono bg-violet-100/50 dark:bg-violet-900/30
                                   text-violet-700 dark:text-violet-300 px-3 py-2 rounded-lg block break-all">
                            {{ $castedVote->transaction_number }}
                        </code>
                    </div>
                </div>
            </div>

            {{-- Voter Info Card --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-5">
                <h4 class="font-semibold text-sm text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                    <i class="fas fa-user text-violet-500"></i> Voter Information
                </h4>
                <div class="space-y-3">
                    @foreach([
                        ['label' => 'Name',      'value' => $castedVote->voter?->full_name ?? '—',      'mono' => false],
                        ['label' => 'Email',     'value' => $castedVote->voter?->email ?? '—',     'mono' => false],
                    ] as $item)
                    <div>
                        <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase">{{ $item['label'] }}</p>
                        <p class="text-sm {{ $item['mono'] ? 'font-mono' : 'font-medium' }} text-gray-700 dark:text-gray-300 mt-0.5">
                            {{ $item['value'] }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right: Vote Details --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- Position & Candidate Card --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-6">
                <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100 mb-6">Vote Details</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Position --}}
                    <div>
                        <label class="block text-xs font-semibold text-violet-600 dark:text-violet-400 uppercase mb-3">Position</label>
                        <div class="bg-gradient-to-br from-violet-50 to-violet-50/30 dark:from-violet-900/20 dark:to-transparent
                                    rounded-xl p-4 border border-violet-200 dark:border-violet-700/30">
                            <p class="font-bold text-lg text-gray-800 dark:text-gray-100">
                                {{ $castedVote->position?->name ?? 'Unknown Position' }}
                            </p>
                        </div>
                    </div>

                    {{-- Candidate --}}
                    <div>
                        <label class="block text-xs font-semibold text-violet-600 dark:text-violet-400 uppercase mb-3">Candidate Voted For</label>
                        <div class="bg-gradient-to-br from-emerald-50 to-emerald-50/30 dark:from-emerald-900/20 dark:to-transparent
                                    rounded-xl p-4 border border-emerald-200 dark:border-emerald-700/30">
                            <p class="font-bold text-lg text-gray-800 dark:text-gray-100">
                                {{ $castedVote->candidate?->first_name ?? '—' }} {{ $castedVote->candidate?->last_name ?? '' }}
                            </p>
                            <p class="text-sm text-emerald-600 dark:text-emerald-400 mt-1">
                                {{ $castedVote->candidate?->partylist?->name ?? 'Independent' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Candidate Details --}}
            @if($castedVote->candidate)
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-6">
                <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100 mb-6">Candidate Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Photo & Basic Info --}}
                    <div class="flex flex-col items-center text-center">
                        <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-violet-600 to-violet-400
                                    flex items-center justify-center text-white text-3xl font-bold
                                    shadow-lg shadow-violet-200 dark:shadow-violet-900/40 overflow-hidden mb-4">
                            @if($castedVote->candidate->photo)
                                <img src="{{ asset('images/candidates/' . $castedVote->candidate->photo) }}"
                                     alt="{{ $castedVote->candidate->first_name }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($castedVote->candidate->first_name, 0, 1)) }}
                            @endif
                        </div>
                        <p class="font-bold text-gray-800 dark:text-gray-100 text-lg">
                            {{ $castedVote->candidate->first_name }} {{ $castedVote->candidate->last_name }}
                        </p>
                        <p class="text-sm text-violet-500 dark:text-violet-400 mt-1">
                            {{ $castedVote->candidate->position?->name ?? '—' }}
                        </p>
                    </div>

                    {{-- Academic Info --}}
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase mb-1">College</p>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ $castedVote->candidate->college?->name ?? '—' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase mb-1">Course</p>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ $castedVote->candidate->course ?? '—' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase mb-1">Party List</p>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ $castedVote->candidate->partylist?->name ?? 'Independent' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Audit Trail --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-6">
                <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100 mb-6">Audit Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase mb-2">Voted At</p>
                        <p class="font-medium text-gray-700 dark:text-gray-300">
                            {{ $castedVote->voted_at?->format('M d, Y • H:i:s A') ?? 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase mb-2">Created At</p>
                        <p class="font-medium text-gray-700 dark:text-gray-300">
                            {{ $castedVote->created_at?->format('M d, Y • H:i:s A') ?? 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <x-modal name="delete-vote" focusable>
        <div class="p-6">
            <div class="flex items-center gap-4 mb-4">
                <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-lg
                            bg-rose-100 dark:bg-rose-900/30">
                    <i class="fas fa-exclamation-triangle text-rose-600 dark:text-rose-400"></i>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Delete Vote Record</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Are you sure you want to delete this vote record? This action cannot be undone.
                    </p>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="button"
                        @click="$dispatch('close-modal', 'delete-vote')"
                        class="flex-1 px-4 py-2 rounded-lg text-sm font-medium
                               text-gray-700 dark:text-gray-300
                               bg-gray-100 dark:bg-gray-800
                               hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    Cancel
                </button>
                <form method="POST" action="{{ route('admin.votes.destroy', $castedVote) }}" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full px-4 py-2 rounded-lg text-sm font-medium
                                   text-white bg-rose-600 hover:bg-rose-700 transition-colors">
                        Delete Vote Record
                    </button>
                </form>
            </div>
        </div>
    </x-modal>
</x-app-layout>
