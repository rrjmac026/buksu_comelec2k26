<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.organizations.index') }}"
               class="w-8 h-8 flex items-center justify-center rounded-xl
                      text-violet-600 dark:text-violet-400
                      hover:bg-violet-100 dark:hover:bg-violet-800/40 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">Add New Organization</h2>
                <p class="text-sm text-violet-600 dark:text-violet-400 mt-0.5">Create a new organization</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('admin.organizations.store') }}" class="space-y-5">
            @csrf

            {{-- Organization Information --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-violet-100 dark:border-violet-800/50
                            bg-gradient-to-r from-violet-50 to-transparent dark:from-violet-900/20">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-violet-600 to-violet-400
                                    flex items-center justify-center text-white text-xs shadow-sm">
                            <i class="fas fa-sitemap"></i>
                        </div>
                        Organization Information
                    </h3>
                </div>

                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Organization Name <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               placeholder="e.g., Business Club"
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
                            College <span class="text-rose-500">*</span>
                        </label>
                        <select name="college_id"
                                class="w-full px-4 py-2.5 rounded-xl text-sm
                                       border border-violet-200 dark:border-violet-700
                                       bg-violet-50/40 dark:bg-violet-900/30
                                       text-gray-800 dark:text-gray-200
                                       focus:outline-none focus:ring-2 focus:ring-violet-400
                                       @error('college_id') border-rose-400 @enderror">
                            <option value="">-- Select College --</option>
                            @foreach(\App\Models\College::orderBy('name')->get() as $college)
                                <option value="{{ $college->college_id }}" {{ old('college_id') == $college->college_id ? 'selected' : '' }}>
                                    {{ $college->name }} ({{ $college->acronym }})
                                </option>
                            @endforeach
                        </select>
                        @error('college_id')
                            <p class="mt-1 text-xs text-rose-500 flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Description
                        </label>
                        <textarea name="description" placeholder="This organization is..."
                                  rows="4"
                                  class="w-full px-4 py-2.5 rounded-xl text-sm
                                         border border-violet-200 dark:border-violet-700
                                         bg-violet-50/40 dark:bg-violet-900/30
                                         text-gray-800 dark:text-gray-200
                                         focus:outline-none focus:ring-2 focus:ring-violet-400
                                         placeholder-violet-300 dark:placeholder-violet-600
                                         @error('description') border-rose-400 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-rose-500 flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <p class="text-xs text-violet-500 dark:text-violet-400 flex items-center gap-1">
                        <i class="fas fa-info-circle"></i> Organization name must be unique
                    </p>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.organizations.index') }}"
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
                        <i class="fas fa-floppy-disk text-xs"></i> Create Organization
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
