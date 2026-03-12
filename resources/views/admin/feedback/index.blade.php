<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">Feedback Management</h2>
                <p class="text-sm text-violet-600 dark:text-violet-400 mt-0.5">View and manage voter feedback submissions</p>
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

    {{-- Stats Row --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
        @php
            $total = $feedbacks->total();
            $avgRating = round($averageRating, 1) ?? 0;
        @endphp

        @foreach([
            ['label' => 'Total Feedback', 'value' => $total,      'icon' => 'fa-comments',    'color' => 'from-violet-600 to-violet-400'],
            ['label' => 'Average Rating', 'value' => $avgRating . ' ★',    'icon' => 'fa-star',        'color' => 'from-amber-600 to-amber-400'],
            ['label' => '5★ Ratings',     'value' => $ratingCounts->get(5, 0) ?? 0,      'icon' => 'fa-heart',           'color' => 'from-rose-600 to-rose-400'],
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

    {{-- Rating Distribution --}}
    <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-5 mb-6">
        <h3 class="font-semibold text-sm text-gray-700 dark:text-gray-300 mb-4">Rating Distribution</h3>
        <div class="space-y-3">
            @foreach([5, 4, 3, 2, 1] as $rating)
            @php
                $count = $ratingCounts->get($rating, 0) ?? 0;
                $percentage = $total > 0 ? ($count / $total) * 100 : 0;
            @endphp
            <div class="flex items-center gap-3">
                <div class="w-12 text-right">
                    <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">{{ $rating }}★</span>
                </div>
                <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-amber-400 to-amber-500 transition-all duration-300"
                         style="width: {{ $percentage }}%"></div>
                </div>
                <div class="w-12 text-right">
                    <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">{{ $count }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-4 mb-4">
        <form method="GET" action="{{ route('admin.feedback.index') }}" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[180px]">
                <label class="block text-xs font-semibold text-violet-600 dark:text-violet-400 mb-1">Search</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-violet-300 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Name or feedback text..."
                           class="w-full pl-8 pr-3 py-2 text-sm rounded-xl
                                  border border-violet-200 dark:border-violet-700
                                  bg-violet-50/50 dark:bg-violet-900/30
                                  text-gray-800 dark:text-gray-200
                                  focus:outline-none focus:ring-2 focus:ring-violet-400
                                  placeholder-violet-300 dark:placeholder-violet-600">
                </div>
            </div>

            <div class="min-w-[160px]">
                <label class="block text-xs font-semibold text-violet-600 dark:text-violet-400 mb-1">Rating</label>
                <select name="rating"
                        class="w-full py-2 px-3 text-sm rounded-xl
                               border border-violet-200 dark:border-violet-700
                               bg-violet-50/50 dark:bg-violet-900/30
                               text-gray-800 dark:text-gray-200
                               focus:outline-none focus:ring-2 focus:ring-violet-400">
                    <option value="">All Ratings</option>
                    @foreach([5, 4, 3, 2, 1] as $rating)
                        <option value="{{ $rating }}" {{ request('rating') == $rating ? 'selected' : '' }}>
                            {{ $rating }} Star{{ $rating > 1 ? 's' : '' }}
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

            @if(request()->hasAny(['search','rating']))
                <a href="{{ route('admin.feedback.index') }}"
                   class="px-4 py-2 rounded-xl text-sm font-semibold
                          text-violet-600 dark:text-violet-400
                          border border-violet-200 dark:border-violet-700
                          hover:bg-violet-50 dark:hover:bg-violet-900/30 transition-all duration-200">
                    <i class="fas fa-xmark mr-1"></i> Clear
                </a>
            @endif
        </form>
    </div>

    {{-- Feedback List --}}
    <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-violet-100 dark:border-violet-800/50
                               bg-gradient-to-r from-violet-50 to-violet-50/30
                               dark:from-violet-900/30 dark:to-transparent">
                        <th class="text-left px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Voter</th>
                        <th class="text-left px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider hidden md:table-cell">Feedback</th>
                        <th class="text-center px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Rating</th>
                        <th class="text-left px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider hidden sm:table-cell">Date</th>
                        <th class="text-right px-5 py-3.5 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-violet-50 dark:divide-violet-800/30">
                    @forelse($feedbacks as $feedback)
                    <tr class="hover:bg-violet-50/40 dark:hover:bg-violet-900/20 transition-colors duration-150">
                        {{-- Voter info --}}
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-600 to-violet-400
                                            flex items-center justify-center text-white font-bold text-sm flex-shrink-0
                                            shadow-sm">
                                    {{ strtoupper(substr($feedback->user->full_name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800 dark:text-gray-100">
                                        {{ $feedback->user->full_name ?? 'Unknown User' }}
                                    </div>
                                    <div class="text-xs text-violet-500 dark:text-violet-400">
                                        {{ $feedback->user->email ?? '—' }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Feedback Preview --}}
                        <td class="px-5 py-3.5 hidden md:table-cell">
                            <div class="text-gray-700 dark:text-gray-300 line-clamp-2">
                                {{ strlen($feedback->feedback) > 60 ? substr($feedback->feedback, 0, 60) . '...' : $feedback->feedback }}
                            </div>
                        </td>

                        {{-- Rating --}}
                        <td class="px-5 py-3.5">
                            <div class="flex justify-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold
                                           {{ $feedback->rating >= 4 ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300'
                                              : ($feedback->rating >= 3 ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300'
                                              : 'bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300') }}">
                                    <i class="fas fa-star"></i>
                                    {{ $feedback->rating }}
                                </span>
                            </div>
                        </td>

                        {{-- Date --}}
                        <td class="px-5 py-3.5 hidden sm:table-cell">
                            <span class="text-gray-600 dark:text-gray-400 text-xs">
                                {{ $feedback->created_at->format('M d, Y') }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td class="px-5 py-3.5">
                            <div class="flex items-center justify-end gap-1.5">
                                {{-- View --}}
                                <a href="{{ route('admin.feedback.show', $feedback) }}"
                                   title="View"
                                   class="w-8 h-8 flex items-center justify-center rounded-lg
                                          text-violet-600 dark:text-violet-400
                                          hover:bg-violet-100 dark:hover:bg-violet-800/40 transition-colors">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>

                                {{-- Delete --}}
                                <button type="button"
                                        title="Delete"
                                        @click="$dispatch('open-modal', 'delete-feedback-{{ $feedback->id }}')"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg
                                               text-rose-500 dark:text-rose-400
                                               hover:bg-rose-100 dark:hover:bg-rose-800/40 transition-colors">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>

                            {{-- Delete Modal --}}
                            <x-modal name="delete-feedback-{{ $feedback->id }}" focusable>
                                <div class="p-6">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-12 h-12 rounded-2xl bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-trash text-rose-500 text-lg"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-gray-900 dark:text-white">Delete Feedback</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">This action cannot be undone.</p>
                                        </div>
                                    </div>

                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                                        Are you sure you want to delete the feedback from <strong>{{ $feedback->user->full_name ?? 'Unknown User' }}</strong>?
                                    </p>

                                    <div class="flex gap-3 justify-end">
                                        <button @click="$dispatch('close-modal', 'delete-feedback-{{ $feedback->id }}')"
                                                class="px-4 py-2 rounded-xl text-sm font-semibold
                                                       text-gray-700 dark:text-gray-300
                                                       border border-gray-300 dark:border-gray-600
                                                       hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                            Cancel
                                        </button>

                                        <form method="POST" action="{{ route('admin.feedback.destroy', $feedback) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-4 py-2 rounded-xl text-sm font-semibold text-white
                                                           bg-gradient-to-r from-rose-600 to-rose-500
                                                           hover:from-rose-700 hover:to-rose-600 transition-all duration-200">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </x-modal>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <i class="fas fa-inbox text-3xl text-gray-300 dark:text-gray-600"></i>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">No feedback found</p>
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
        {{ $feedbacks->links() }}
    </div>
</x-app-layout>
