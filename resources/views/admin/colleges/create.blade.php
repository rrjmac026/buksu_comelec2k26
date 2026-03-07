<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.colleges.index') }}"
               class="w-8 h-8 flex items-center justify-center rounded-xl
                      text-violet-600 dark:text-violet-400
                      hover:bg-violet-100 dark:hover:bg-violet-800/40 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">Add New College</h2>
                <p class="text-sm text-violet-600 dark:text-violet-400 mt-0.5">Create a new college</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('admin.colleges.store') }}" class="space-y-5">
            @csrf

            {{-- College Information --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-violet-100 dark:border-violet-800/50
                            bg-gradient-to-r from-violet-50 to-transparent dark:from-violet-900/20">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-violet-600 to-violet-400
                                    flex items-center justify-center text-white text-xs shadow-sm">
                            <i class="fas fa-building"></i>
                        </div>
                        College Information
                    </h3>
                </div>

                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            College Name <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               placeholder="e.g., College of Engineering"
                               class="w-full px-4 py-2.5 rounded-xl text-sm
                                      border border-violet-200 dark:border-violet-700
                                      bg-violet-50/40 dark:bg-violet-900/30
                                      text-gray-800 dark:text-gray-200
                                      focus:outline-none focus:ring-2 focus:ring-violet-400
                                      placeholder-violet-300 dark:placeholder-violet-600
                                      @error('name') border-rose-400 @enderror">
                        @error('name')
                            <p class="mt-1 text-xs text-rose-500 flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Acronym <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="acronym" value="{{ old('acronym') }}"
                               placeholder="e.g., COE"
                               class="w-full px-4 py-2.5 rounded-xl text-sm font-mono uppercase
                                      border border-violet-200 dark:border-violet-700
                                      bg-violet-50/40 dark:bg-violet-900/30
                                      text-gray-800 dark:text-gray-200
                                      focus:outline-none focus:ring-2 focus:ring-violet-400
                                      placeholder-violet-300 dark:placeholder-violet-600
                                      @error('acronym') border-rose-400 @enderror">
                        @error('acronym')
                            <p class="mt-1 text-xs text-rose-500 flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <p class="text-xs text-violet-500 dark:text-violet-400 flex items-center gap-1">
                        <i class="fas fa-info-circle"></i> Both fields must be unique
                    </p>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.colleges.index') }}"
                       class="px-5 py-2.5 rounded-xl text-sm font-semibold
                              text-violet-600 dark:text-violet-400
                              border border-violet-200 dark:border-violet-700
                              hover:bg-violet-50 dark:hover:bg-violet-900/30 transition-all duration-200">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold text-white
                                   bg-gradient-to-r from-violet-700 to-violet-500
                                   shadow-md shadow-violet-200 dark:shadow-violet-900/40
                                   hover:from-violet-800 hover:to-violet-600 hover:-translate-y-0.5
                                   transition-all duration-200">
                        <i class="fas fa-floppy-disk text-xs"></i> Create College
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
