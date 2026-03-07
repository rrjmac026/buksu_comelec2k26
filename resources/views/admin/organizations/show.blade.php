<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.organizations.index') }}"
                   class="w-8 h-8 flex items-center justify-center rounded-xl
                          text-violet-600 dark:text-violet-400
                          hover:bg-violet-100 dark:hover:bg-violet-800/40 transition-colors">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">Organization Profile</h2>
                    <p class="text-sm text-violet-600 dark:text-violet-400 mt-0.5">Viewing details for <strong>{{ $organization->name }}</strong></p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.organizations.edit', $organization) }}"
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

        {{-- Left: Organization Card --}}
        <div class="lg:col-span-1 space-y-4">

            {{-- Organization Header --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-6 text-center">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-violet-600 to-violet-400
                            flex items-center justify-center text-white text-3xl font-bold
                            shadow-lg shadow-violet-200 dark:shadow-violet-900/40 mx-auto mb-4">
                    {{ strtoupper(substr($organization->name, 0, 2)) }}
                </div>
                <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100">{{ $organization->name }}</h3>
                <p class="text-sm text-violet-500 dark:text-violet-400 mt-1">{{ $organization->college?->name ?? '—' }}</p>

                <div class="mt-5 pt-4 border-t border-violet-100 dark:border-violet-800/50 space-y-2">
                    <a href="{{ route('admin.organizations.edit', $organization) }}"
                       class="w-full py-2 rounded-xl text-sm font-semibold transition-all duration-200
                              text-sky-700 dark:text-sky-400 border border-sky-200 dark:border-sky-700 hover:bg-sky-50 dark:hover:bg-sky-900/20">
                        <i class="fas fa-pen mr-2"></i> Edit Organization
                    </a>

                    <button type="button" @click="$dispatch('open-modal', 'delete-organization')"
                            class="w-full py-2 rounded-xl text-sm font-semibold
                                   text-rose-600 dark:text-rose-400
                                   border border-rose-200 dark:border-rose-700
                                   hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all duration-200">
                        <i class="fas fa-trash mr-2"></i> Delete Organization
                    </button>
                </div>
            </div>

        </div>

        {{-- Right: Details & Information --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Stats Row --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase">Total Positions</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">
                                {{ $organization->positions->count() ?? 0 }}
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-50
                                    dark:from-emerald-900/30 dark:to-emerald-900/10 flex items-center justify-center">
                            <i class="fas fa-list text-xl text-emerald-500"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase">Total Candidates</p>
                            <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">
                                {{ $organization->candidates->count() ?? 0 }}
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-100 to-sky-50
                                    dark:from-sky-900/30 dark:to-sky-900/10 flex items-center justify-center">
                            <i class="fas fa-user-tie text-xl text-sky-500"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Organization Information --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-6 overflow-hidden">
                <div class="mb-4">
                    <h4 class="font-semibold text-sm text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                        <i class="fas fa-circle-info text-violet-500"></i> Organization Information
                    </h4>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase">College</p>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-1">
                                {{ $organization->college?->name ?? '—' }}
                                @if($organization->college)
                                    <span class="ml-2 font-mono text-xs px-2 py-1 rounded bg-violet-100 dark:bg-violet-900/40 text-violet-700 dark:text-violet-300">
                                        {{ $organization->college->acronym }}
                                    </span>
                                @endif
                            </p>
                        </div>

                        @if($organization->description)
                        <div>
                            <p class="text-xs text-violet-500 dark:text-violet-400 font-semibold uppercase">Description</p>
                            <p class="text-sm text-gray-700 dark:text-gray-300 mt-1 whitespace-pre-wrap">{{ $organization->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Positions Section --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-violet-100 dark:border-violet-800/50
                            bg-gradient-to-r from-violet-50 to-transparent dark:from-violet-900/20">
                    <h4 class="font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                        <i class="fas fa-list text-violet-500"></i> Associated Positions ({{ $organization->positions->count() }})
                    </h4>
                </div>

                @if($organization->positions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-violet-100 dark:border-violet-800/50
                                           bg-gradient-to-r from-violet-50/50 to-transparent
                                           dark:from-violet-900/20">
                                    <th class="text-left px-6 py-3 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase">Position</th>
                                    <th class="text-center px-6 py-3 text-xs font-bold text-violet-600 dark:text-violet-400 uppercase">Candidates</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-violet-50 dark:divide-violet-800/30">
                                @foreach($organization->positions as $position)
                                <tr class="hover:bg-violet-50/30 dark:hover:bg-violet-900/10">
                                    <td class="px-6 py-3 font-medium text-gray-700 dark:text-gray-300">
                                        <a href="{{ route('admin.positions.show', $position) }}" class="hover:text-violet-600 dark:hover:text-violet-400">
                                            {{ $position->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold
                                                   bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300">
                                            {{ $position->candidates->count() }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="px-6 py-8 text-center">
                        <i class="fas fa-inbox text-3xl text-violet-200 dark:text-violet-800 mb-3 block"></i>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">No positions associated</p>
                    </div>
                @endif
            </div>

        </div>

    </div>

    {{-- Delete Modal --}}
    <x-modal name="delete-organization" :show="false" maxWidth="sm">
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
</x-app-layout>
