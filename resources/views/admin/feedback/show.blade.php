<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.feedback.index') }}"
                   class="w-8 h-8 flex items-center justify-center rounded-xl
                          text-violet-600 dark:text-violet-400
                          hover:bg-violet-100 dark:hover:bg-violet-800/40 transition-colors">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">Feedback Details</h2>
                    <p class="text-sm text-violet-600 dark:text-violet-400 mt-0.5">From <strong>{{ $feedback->user->name ?? 'Unknown User' }}</strong></p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" @click="$dispatch('open-modal', 'delete-feedback')"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold
                               text-rose-600 dark:text-rose-400
                               border border-rose-200 dark:border-rose-700
                               hover:bg-rose-50 dark:hover:bg-rose-900/30 transition-all duration-200">
                    <i class="fas fa-trash text-xs"></i> Delete
                </button>
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

        {{-- Left: Voter Info Card --}}
        <div class="lg:col-span-1 space-y-4">

            {{-- Voter Card --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-6">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-violet-600 to-violet-400
                            flex items-center justify-center text-white text-2xl font-bold
                            shadow-lg shadow-violet-200 dark:shadow-violet-900/40 mx-auto mb-4">
                    {{ strtoupper(substr($feedback->user->name ?? 'U', 0, 1)) }}
                </div>

                <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100 text-center">
                    {{ $feedback->user->name ?? 'Unknown User' }}
                </h3>
                <p class="text-sm text-violet-500 dark:text-violet-400 mt-0.5 text-center break-all">
                    {{ $feedback->user->email ?? '—' }}
                </p>

                <div class="mt-5 pt-4 border-t border-violet-100 dark:border-violet-800/50">
                    <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase mb-2">Submitted on</p>
                    <p class="text-sm font-medium text-gray-800 dark:text-gray-100">
                        {{ $feedback->created_at->format('F d, Y \a\t g:i A') }}
                    </p>
                </div>
            </div>

        </div>

        {{-- Right: Feedback Content --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Rating Card --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-6">
                <h4 class="font-semibold text-sm text-gray-700 dark:text-gray-300 mb-4">Rating</h4>

                <div class="flex items-center gap-4">
                    <div class="flex gap-2">
                        @foreach(range(1, 5) as $star)
                            @if($star <= $feedback->rating)
                                <i class="fas fa-star text-2xl text-amber-400"></i>
                            @else
                                <i class="far fa-star text-2xl text-gray-300 dark:text-gray-600"></i>
                            @endif
                        @endforeach
                    </div>

                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold
                               {{ $feedback->rating >= 4 ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300'
                                  : ($feedback->rating >= 3 ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300'
                                  : 'bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300') }}">
                        {{ $feedback->rating }} / 5
                    </span>
                </div>

                <div class="mt-4 pt-4 border-t border-violet-100 dark:border-violet-800/50">
                    @php
                        $ratings = [
                            5 => 'Excellent',
                            4 => 'Good',
                            3 => 'Average',
                            2 => 'Poor',
                            1 => 'Very Poor'
                        ];
                    @endphp
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <span class="font-semibold text-gray-800 dark:text-gray-100">{{ $ratings[$feedback->rating] }}</span>
                    </p>
                </div>
            </div>

            {{-- Feedback Text Card --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-6">
                <h4 class="font-semibold text-sm text-gray-700 dark:text-gray-300 mb-4">Feedback Message</h4>

                <div class="prose prose-sm dark:prose-invert max-w-none
                            text-gray-700 dark:text-gray-300
                            leading-relaxed whitespace-pre-wrap break-words">
                    {{ $feedback->feedback }}
                </div>

                <div class="mt-4 pt-4 border-t border-violet-100 dark:border-violet-800/50">
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        <i class="fas fa-clock mr-1"></i>
                        Last updated {{ $feedback->updated_at->diffForHumans() }}
                    </p>
                </div>
            </div>

        </div>

    </div>

    {{-- Delete Modal --}}
    <x-modal name="delete-feedback" focusable>
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
                Are you sure you want to delete this feedback from <strong>{{ $feedback->user->name ?? 'Unknown User' }}</strong>? This will permanently remove the feedback submission.
            </p>

            <div class="flex gap-3 justify-end">
                <button @click="$dispatch('close-modal', 'delete-feedback')"
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
                        Delete Feedback
                    </button>
                </form>
            </div>
        </div>
    </x-modal>
</x-app-layout>
