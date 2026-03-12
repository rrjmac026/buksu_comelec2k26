<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.candidates.index') }}"
               class="w-8 h-8 flex items-center justify-center rounded-xl
                      text-violet-600 dark:text-violet-400
                      hover:bg-violet-100 dark:hover:bg-violet-800/40 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">Edit Candidate</h2>
                <p class="text-sm text-violet-600 dark:text-violet-400 mt-0.5">Updating: <strong>{{ $candidate->first_name }} {{ $candidate->last_name }}</strong></p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <form method="POST" action="{{ route('admin.candidates.update', $candidate) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')

            {{-- Personal Information --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-violet-100 dark:border-violet-800/50
                            bg-gradient-to-r from-violet-50 to-transparent dark:from-violet-900/20">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-violet-600 to-violet-400
                                    flex items-center justify-center text-white text-xs shadow-sm">
                            <i class="fas fa-user"></i>
                        </div>
                        Personal Information
                    </h3>
                </div>

                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            First Name <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="first_name" value="{{ old('first_name', $candidate->first_name) }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm
                                      border border-violet-200 dark:border-violet-700
                                      bg-violet-50/40 dark:bg-violet-900/30
                                      text-gray-800 dark:text-gray-200
                                      focus:outline-none focus:ring-2 focus:ring-violet-400
                                      @error('first_name') border-rose-400 @enderror">
                        @error('first_name')
                            <p class="mt-1 text-xs text-rose-500 flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Last Name <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="last_name" value="{{ old('last_name', $candidate->last_name) }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm
                                      border border-violet-200 dark:border-violet-700
                                      bg-violet-50/40 dark:bg-violet-900/30
                                      text-gray-800 dark:text-gray-200
                                      focus:outline-none focus:ring-2 focus:ring-violet-400
                                      @error('last_name') border-rose-400 @enderror">
                        @error('last_name')
                            <p class="mt-1 text-xs text-rose-500 flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Middle Name
                        </label>
                        <input type="text" name="middle_name" value="{{ old('middle_name', $candidate->middle_name) }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm
                                      border border-violet-200 dark:border-violet-700
                                      bg-violet-50/40 dark:bg-violet-900/30
                                      text-gray-800 dark:text-gray-200
                                      focus:outline-none focus:ring-2 focus:ring-violet-400">
                    </div>
                </div>
            </div>

            {{-- Academic Information --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-violet-100 dark:border-violet-800/50
                            bg-gradient-to-r from-violet-50 to-transparent dark:from-violet-900/20">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-sky-600 to-sky-400
                                    flex items-center justify-center text-white text-xs shadow-sm">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        Academic Information
                    </h3>
                </div>

                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
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
                            <option value="">Select college</option>
                            @foreach($colleges as $college)
                                {{-- Use $college->id — the actual PK column from migration --}}
                                <option value="{{ $college->id }}" {{ old('college_id', $candidate->college_id) == $college->id ? 'selected' : '' }}>
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
                            Course <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="course" value="{{ old('course', $candidate->course) }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm
                                      border border-violet-200 dark:border-violet-700
                                      bg-violet-50/40 dark:bg-violet-900/30
                                      text-gray-800 dark:text-gray-200
                                      focus:outline-none focus:ring-2 focus:ring-violet-400
                                      @error('course') border-rose-400 @enderror">
                        @error('course')
                            <p class="mt-1 text-xs text-rose-500 flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Election Information --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-violet-100 dark:border-violet-800/50
                            bg-gradient-to-r from-violet-50 to-transparent dark:from-violet-900/20">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-emerald-600 to-emerald-400
                                    flex items-center justify-center text-white text-xs shadow-sm">
                            <i class="fas fa-vote-yea"></i>
                        </div>
                        Election Position
                    </h3>
                </div>

                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Party List <span class="text-rose-500">*</span>
                        </label>
                        <select name="partylist_id"
                                class="w-full px-4 py-2.5 rounded-xl text-sm
                                       border border-violet-200 dark:border-violet-700
                                       bg-violet-50/40 dark:bg-violet-900/30
                                       text-gray-800 dark:text-gray-200
                                       focus:outline-none focus:ring-2 focus:ring-violet-400
                                       @error('partylist_id') border-rose-400 @enderror">
                            <option value="">Select party list</option>
                            @foreach($partylists as $partylist)
                                {{-- Use $partylist->id — the actual PK column from migration --}}
                                <option value="{{ $partylist->id }}" {{ old('partylist_id', $candidate->partylist_id) == $partylist->id ? 'selected' : '' }}>
                                    {{ $partylist->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('partylist_id')
                            <p class="mt-1 text-xs text-rose-500 flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Organization <span class="text-rose-500">*</span>
                        </label>
                        <select name="organization_id"
                                class="w-full px-4 py-2.5 rounded-xl text-sm
                                       border border-violet-200 dark:border-violet-700
                                       bg-violet-50/40 dark:bg-violet-900/30
                                       text-gray-800 dark:text-gray-200
                                       focus:outline-none focus:ring-2 focus:ring-violet-400
                                       @error('organization_id') border-rose-400 @enderror">
                            <option value="">Select organization</option>
                            @foreach($organizations as $organization)
                                {{-- Use $organization->id — the actual PK column from migration --}}
                                <option value="{{ $organization->id }}" {{ old('organization_id', $candidate->organization_id) == $organization->id ? 'selected' : '' }}>
                                    {{ $organization->name }} ({{ $organization->college?->acronym ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                        @error('organization_id')
                            <p class="mt-1 text-xs text-rose-500 flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Position <span class="text-rose-500">*</span>
                        </label>
                        <select name="position_id"
                                class="w-full px-4 py-2.5 rounded-xl text-sm
                                       border border-violet-200 dark:border-violet-700
                                       bg-violet-50/40 dark:bg-violet-900/30
                                       text-gray-800 dark:text-gray-200
                                       focus:outline-none focus:ring-2 focus:ring-violet-400
                                       @error('position_id') border-rose-400 @enderror">
                            <option value="">Select position</option>
                            @foreach($positions as $position)
                                {{-- Use $position->id — the actual PK column from migration --}}
                                <option value="{{ $position->id }}" {{ old('position_id', $candidate->position_id) == $position->id ? 'selected' : '' }}>
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('position_id')
                            <p class="mt-1 text-xs text-rose-500 flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Campaign Information --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-violet-100 dark:border-violet-800/50
                            bg-gradient-to-r from-violet-50 to-transparent dark:from-violet-900/20">
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-rose-600 to-rose-400
                                    flex items-center justify-center text-white text-xs shadow-sm">
                            <i class="fas fa-microphone"></i>
                        </div>
                        Campaign Information
                    </h3>
                </div>

                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Platform
                        </label>
                        <textarea name="platform" rows="4"
                                  placeholder="Enter candidate's campaign platform and promises..."
                                  class="w-full px-4 py-2.5 rounded-xl text-sm
                                         border border-violet-200 dark:border-violet-700
                                         bg-violet-50/40 dark:bg-violet-900/30
                                         text-gray-800 dark:text-gray-200
                                         focus:outline-none focus:ring-2 focus:ring-violet-400
                                         placeholder-violet-300 dark:placeholder-violet-600">{{ old('platform', $candidate->platform) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Candidate Photo
                        </label>
                        @if($candidate->photo)
                            <div class="mb-3 flex items-center gap-3">
                                <img src="{{ asset('images/candidates/' . $candidate->photo) }}" alt="{{ $candidate->first_name }}"
                                     class="w-16 h-16 rounded-lg object-cover border border-violet-200 dark:border-violet-700">
                                <div>
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Current Photo</p>
                                    <p class="text-xs text-violet-500 dark:text-violet-400">Replace to upload new photo</p>
                                </div>
                            </div>
                        @endif
                        <div class="relative">
                            <input type="file" name="photo" accept="image/*"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm
                                          border border-violet-200 dark:border-violet-700
                                          bg-violet-50/40 dark:bg-violet-900/30
                                          text-gray-800 dark:text-gray-200
                                          focus:outline-none focus:ring-2 focus:ring-violet-400
                                          file:mr-4 file:px-3 file:py-1.5 file:rounded-lg
                                          file:border-0 file:text-sm file:font-semibold
                                          file:bg-violet-100 dark:file:bg-violet-900/40
                                          file:text-violet-700 dark:file:text-violet-300
                                          @error('photo') border-rose-400 @enderror">
                            <p class="text-xs text-violet-500 dark:text-violet-400 mt-1.5">
                                <i class="fas fa-info-circle"></i> JPG, PNG, or WEBP (max 2MB)
                            </p>
                        </div>
                        @error('photo')
                            <p class="mt-1 text-xs text-rose-500 flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="bg-white dark:bg-violet-950/40 rounded-2xl border border-violet-100 dark:border-violet-800/50 shadow-sm p-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.candidates.index') }}"
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
                        <i class="fas fa-floppy-disk text-xs"></i> Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>