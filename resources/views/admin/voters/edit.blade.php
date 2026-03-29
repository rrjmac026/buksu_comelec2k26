<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.voters.index') }}"
               class="w-8 h-8 flex items-center justify-center rounded-xl
                      text-violet-600 dark:text-violet-400
                      hover:bg-violet-100 dark:hover:bg-violet-800/40 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">Edit Voter</h2>
                <p class="text-sm text-violet-600 dark:text-violet-400 mt-0.5">Updating: <strong>{{ $voter->full_name }}</strong></p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <form method="POST" action="{{ route('admin.voters.update', $voter) }}" class="space-y-5">
            @csrf @method('PUT')

            {{-- Personal Info --}}
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
                        <input type="text" name="first_name" value="{{ old('first_name', $voter->first_name) }}"
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
                            Middle Name
                        </label>
                        <input type="text" name="middle_name" value="{{ old('middle_name', $voter->middle_name) }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm
                                      border border-violet-200 dark:border-violet-700
                                      bg-violet-50/40 dark:bg-violet-900/30
                                      text-gray-800 dark:text-gray-200
                                      focus:outline-none focus:ring-2 focus:ring-violet-400">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Last Name <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="last_name" value="{{ old('last_name', $voter->last_name) }}"
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

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Email Address <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', $voter->email) }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm
                                      border border-violet-200 dark:border-violet-700
                                      bg-violet-50/40 dark:bg-violet-900/30
                                      text-gray-800 dark:text-gray-200
                                      focus:outline-none focus:ring-2 focus:ring-violet-400
                                      @error('email') border-rose-400 @enderror">
                        @error('email')
                            <p class="mt-1 text-xs text-rose-500 flex items-center gap-1"><i class="fas fa-circle-exclamation"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Sex <span class="text-rose-500">*</span>
                        </label>
                        <select name="sex"
                                class="w-full px-4 py-2.5 rounded-xl text-sm
                                       border border-violet-200 dark:border-violet-700
                                       bg-violet-50/40 dark:bg-violet-900/30
                                       text-gray-800 dark:text-gray-200
                                       focus:outline-none focus:ring-2 focus:ring-violet-400">
                            <option value="male"   {{ old('sex', $voter->sex) === 'male'   ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('sex', $voter->sex) === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other"  {{ old('sex', $voter->sex) === 'other'  ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Academic Info --}}
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
                            Student Number <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="student_number" value="{{ old('student_number', $voter->student_number) }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm font-mono
                                      border border-violet-200 dark:border-violet-700
                                      bg-violet-50/40 dark:bg-violet-900/30
                                      text-gray-800 dark:text-gray-200
                                      focus:outline-none focus:ring-2 focus:ring-violet-400
                                      @error('student_number') border-rose-400 @enderror">
                        @error('student_number')
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
                                       focus:outline-none focus:ring-2 focus:ring-violet-400">
                            <option value="">Select college</option>
                            @foreach($colleges as $college)
                                <option value="{{ $college->id }}"
                                    {{ old('college_id', $voter->college_id) == $college->id ? 'selected' : '' }}>
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
                        <input type="text" name="course" value="{{ old('course', $voter->course) }}"
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

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Year Level <span class="text-rose-500">*</span>
                        </label>
                        <select name="year_level"
                                class="w-full px-4 py-2.5 rounded-xl text-sm
                                       border border-violet-200 dark:border-violet-700
                                       bg-violet-50/40 dark:bg-violet-900/30
                                       text-gray-800 dark:text-gray-200
                                       focus:outline-none focus:ring-2 focus:ring-violet-400">
                            @foreach([1=>'1st Year',2=>'2nd Year',3=>'3rd Year',4=>'4th Year',5=>'5th Year',6=>'6th Year'] as $val => $label)
                                <option value="{{ $val }}" {{ old('year_level', $voter->year_level) == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            Account Status <span class="text-rose-500">*</span>
                        </label>
                        <select name="status"
                                class="w-full px-4 py-2.5 rounded-xl text-sm
                                       border border-violet-200 dark:border-violet-700
                                       bg-violet-50/40 dark:bg-violet-900/30
                                       text-gray-800 dark:text-gray-200
                                       focus:outline-none focus:ring-2 focus:ring-violet-400">
                            <option value="active"   {{ old('status', $voter->status) === 'active'   ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $voter->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between">
                <form method="POST" action="{{ route('admin.voters.toggle-status', $voter) }}">
                    @csrf @method('PATCH')
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200
                                   {{ $voter->status === 'active'
                                       ? 'text-amber-700 border border-amber-200 dark:border-amber-700 hover:bg-amber-50 dark:hover:bg-amber-900/20'
                                       : 'text-emerald-700 border border-emerald-200 dark:border-emerald-700 hover:bg-emerald-50 dark:hover:bg-emerald-900/20' }}">
                        <i class="fas {{ $voter->status === 'active' ? 'fa-toggle-on text-amber-500' : 'fa-toggle-off text-emerald-500' }}"></i>
                        {{ $voter->status === 'active' ? 'Deactivate Account' : 'Activate Account' }}
                    </button>
                </form>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.voters.index') }}"
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