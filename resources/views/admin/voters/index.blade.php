<x-app-layout>
    <style>
        :root {
            --gold:      #f9b40f;
            --gold-lt:   #fcd558;
            --gold-dk:   #c98a00;
            --gold-pale: #fef3c7;
            --violet:    #380041;
            --violet-md: #520060;
            --violet-lt: #6b0080;
            --violet-xl: #1e0025;
            --cream:     #fffbf0;
            --ink:       #1a0020;
        }
    </style>

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="mb-4 flex items-center gap-3 px-4 py-3 rounded-xl
                    shadow-lg"
             style="background: rgba(52, 211, 153, 0.1); border: 1px solid rgba(52, 211, 153, 0.4); color: #34d399;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             class="mb-4 flex items-center gap-3 px-4 py-3 rounded-xl
                    shadow-lg"
             style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.4); color: #ef4444;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Stats Row --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        @foreach([
            ['label' => 'Total Voters',    'value' => $stats['total'],    'icon' => 'fa-users',           'color' => 'from-[#fcd558] to-[#f9b40f]'],
            ['label' => 'Active',          'value' => $stats['active'],   'icon' => 'fa-circle-check',     'color' => 'from-emerald-600 to-emerald-500'],
            ['label' => 'Inactive',        'value' => $stats['inactive'], 'icon' => 'fa-circle-xmark',     'color' => 'from-rose-600 to-rose-500'],
            ['label' => 'Already Voted',   'value' => $stats['voted'],    'icon' => 'fa-vote-yea',         'color' => 'from-[#6b0080] to-[#520060]'],
        ] as $stat)
        <div class="relative overflow-hidden rounded-2xl p-4 flex items-center gap-3 transition-all duration-300 hover:shadow-lg"
             style="background: linear-gradient(to bottom right, rgba(56, 0, 65, 0.4), rgba(30, 0, 37, 0.6)); border: 1px solid rgba(249, 180, 15, 0.2); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);">
            <div class="absolute inset-0 bg-gradient-to-r from-[#f9b40f]/5 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative w-12 h-12 rounded-lg bg-gradient-to-br {{ $stat['color'] }}
                        flex items-center justify-center text-white shadow-lg flex-shrink-0">
                <i class="fas {{ $stat['icon'] }} text-base"></i>
            </div>
            <div class="relative">
                <div class="text-2xl font-bold" style="color: #fcd558;">{{ $stat['value'] }}</div>
                <div class="text-xs font-medium uppercase tracking-wider" style="color: rgba(252, 213, 88, 0.7);">{{ $stat['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Filter Bar --}}
    <div class="relative rounded-2xl overflow-hidden mb-4 shadow-lg"
         style="background: linear-gradient(to bottom right, rgba(56, 0, 65, 0.4), rgba(30, 0, 37, 0.6)); border: 1px solid rgba(249, 180, 15, 0.2);">
        <div class="absolute inset-0 bg-gradient-to-r from-[#f9b40f]/5 to-transparent opacity-50"></div>
        <form method="GET" action="{{ route('admin.voters.index') }}" class="relative p-5 flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[180px]">
                <label class="block text-xs font-bold mb-2 uppercase tracking-wider" style="color: #fcd558;">Search</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-xs" style="color: rgba(249, 180, 15, 0.5);"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Name, email, student no..."
                           class="w-full pl-9 pr-4 py-2.5 text-sm rounded-lg
                                  border transition-all duration-200 shadow-inner
                                  focus:outline-none"
                           style="background: rgba(56, 0, 65, 0.4); border-color: rgba(249, 180, 15, 0.2); color: #fffbf0; --tw-ring-color: rgba(249, 180, 15, 0.5);"
                           onfocus="this.style.borderColor='rgba(249, 180, 15, 0.5)'; this.style.boxShadow='0 0 0 2px rgba(249, 180, 15, 0.2)';"
                           onblur="this.style.borderColor='rgba(249, 180, 15, 0.2)'; this.style.boxShadow='';">
                    <style>input::placeholder { color: rgba(249, 180, 15, 0.4); }</style>
                </div>
            </div>

            <div class="min-w-[160px]">
                <label class="block text-xs font-bold mb-2 uppercase tracking-wider" style="color: #fcd558;">College</label>
                <select name="college_id"
                        class="w-full py-2.5 px-4 text-sm rounded-lg
                               border transition-all duration-200 shadow-inner
                               focus:outline-none"
                        style="background: rgba(56, 0, 65, 0.4); border-color: rgba(249, 180, 15, 0.2); color: #fffbf0;">
                    <option value="" style="background: #1e0025; color: #fffbf0;">All Colleges</option>
                    @foreach($colleges as $college)
                        <option value="{{ $college->id }}" style="background: #1e0025; color: #fffbf0;" {{ request('college_id') == $college->id ? 'selected' : '' }}>
                            {{ $college->acronym }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="min-w-[130px]">
                <label class="block text-xs font-bold mb-2 uppercase tracking-wider" style="color: #fcd558;">Status</label>
                <select name="status"
                        class="w-full py-2.5 px-4 text-sm rounded-lg
                               border transition-all duration-200 shadow-inner
                               focus:outline-none"
                        style="background: rgba(56, 0, 65, 0.4); border-color: rgba(249, 180, 15, 0.2); color: #fffbf0;">
                    <option value="" style="background: #1e0025; color: #fffbf0;">All Status</option>
                    <option value="active" style="background: #1e0025; color: #fffbf0;" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" style="background: #1e0025; color: #fffbf0;" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <button type="submit"
                    class="px-5 py-2.5 rounded-lg text-sm font-bold
                           shadow-lg transition-all duration-200 uppercase tracking-wider"
                    style="background: linear-gradient(135deg, #f9b40f, #fcd558); color: #1e0025; box-shadow: 0 4px 24px rgba(249, 180, 15, 0.35);"
                    onmouseover="this.style.boxShadow='0 10px 32px rgba(249, 180, 15, 0.5)'; this.style.transform='translateY(-2px)';"
                    onmouseout="this.style.boxShadow='0 4px 24px rgba(249, 180, 15, 0.35)'; this.style.transform='translateY(0)';">
                <i class="fas fa-filter mr-1.5"></i> Filter
            </button>

            @if(request()->hasAny(['search','college_id','status']))
                <a href="{{ route('admin.voters.index') }}"
                   class="px-5 py-2.5 rounded-lg text-sm font-bold
                          border transition-all duration-200 uppercase tracking-wider"
                   style="color: #fcd558; border-color: rgba(249, 180, 15, 0.3);"
                   onmouseover="this.style.backgroundColor='rgba(249, 180, 15, 0.1)'; this.style.borderColor='rgba(249, 180, 15, 0.6)';"
                   onmouseout="this.style.backgroundColor='transparent'; this.style.borderColor='rgba(249, 180, 15, 0.3)';">
                    <i class="fas fa-xmark mr-1.5"></i> Clear
                </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="relative rounded-2xl overflow-hidden shadow-lg"
         style="background: linear-gradient(to bottom right, rgba(56, 0, 65, 0.4), rgba(30, 0, 37, 0.6)); border: 1px solid rgba(249, 180, 15, 0.2);">
        <div class="absolute inset-0 bg-gradient-to-r from-[#f9b40f]/5 to-transparent opacity-50 pointer-events-none"></div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr style="background: linear-gradient(to right, rgba(56, 0, 65, 0.6), transparent); border-bottom: 1px solid rgba(249, 180, 15, 0.2);">
                        <th class="text-left px-5 py-4 text-xs font-bold uppercase tracking-wider" style="color: #fcd558;">Voter Name</th>
                        <th class="text-left px-5 py-4 text-xs font-bold uppercase tracking-wider hidden md:table-cell" style="color: #fcd558;">Student No.</th>
                        <th class="text-left px-5 py-4 text-xs font-bold uppercase tracking-wider hidden lg:table-cell" style="color: #fcd558;">College / Course</th>
                        <th class="text-left px-5 py-4 text-xs font-bold uppercase tracking-wider hidden sm:table-cell" style="color: #fcd558;">Year</th>
                        <th class="text-left px-5 py-4 text-xs font-bold uppercase tracking-wider" style="color: #fcd558;">Status</th>
                        <th class="text-right px-5 py-4 text-xs font-bold uppercase tracking-wider" style="color: #fcd558;">Actions</th>
                    </tr>
                </thead>
                <tbody style="border-collapse: collapse;">
                    @forelse($voters as $voter)
                    <tr class="transition-colors duration-150 hover:shadow-lg" style="border-bottom: 1px solid rgba(249, 180, 15, 0.1); background: linear-gradient(to right, rgba(249, 180, 15, 0.02), transparent);">
                        {{-- Voter name --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-[#fcd558] to-[#f9b40f]
                                            flex items-center justify-center text-[#1e0025] font-bold text-sm flex-shrink-0
                                            shadow-lg"
                                     style="box-shadow: 0 4px 14px rgba(249, 180, 15, 0.3);">
                                    {{ strtoupper(substr($voter->full_name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold" style="color: #fffbf0;">{{ $voter->full_name }}</div>
                                    <div class="text-xs" style="color: rgba(255, 251, 240, 0.6);">{{ $voter->email }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Student no --}}
                        <td class="px-5 py-4 hidden md:table-cell">
                            <span class="font-mono text-xs px-2.5 py-1 rounded-lg"
                                  style="background: rgba(249, 180, 15, 0.2); color: #fcd558;">
                                {{ $voter->student_number ?? '—' }}
                            </span>
                        </td>

                        {{-- College / Course --}}
                        <td class="px-5 py-4 hidden lg:table-cell">
                            <div class="font-medium" style="color: #fffbf0;">{{ $voter->college->acronym ?? '—' }}</div>
                            <div class="text-xs" style="color: rgba(255, 251, 240, 0.6);">{{ $voter->course ?? '—' }}</div>
                        </td>

                        {{-- Year --}}
                        <td class="px-5 py-4 hidden sm:table-cell" style="color: rgba(255, 251, 240, 0.8);">
                            {{ $voter->year_level ? $voter->year_level . ($voter->year_level == 1 ? 'st' : ($voter->year_level == 2 ? 'nd' : ($voter->year_level == 3 ? 'rd' : 'th'))) : '—' }}
                        </td>

                        {{-- Status --}}
                        <td class="px-5 py-4">
                            @if($voter->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold"
                                      style="background: rgba(52, 211, 153, 0.3); color: #6ee7b7; border: 1px solid rgba(52, 211, 153, 0.5);">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold"
                                      style="background: rgba(239, 68, 68, 0.3); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.5);">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                    Inactive
                                </span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-2">
                                {{-- View --}}
                                <a href="{{ route('admin.voters.show', $voter) }}"
                                   title="View"
                                   class="w-8 h-8 flex items-center justify-center rounded-lg
                                          transition-all duration-200"
                                   style="color: #fcd558;"
                                   onmouseover="this.style.backgroundColor='rgba(249, 180, 15, 0.2)'; this.style.color='#fffbf0';"
                                   onmouseout="this.style.backgroundColor='transparent'; this.style.color='#fcd558';">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('admin.voters.edit', $voter) }}"
                                   title="Edit"
                                   class="w-8 h-8 flex items-center justify-center rounded-lg
                                          transition-all duration-200"
                                   style="color: #60a5fa;"
                                   onmouseover="this.style.backgroundColor='rgba(96, 165, 250, 0.2)'; this.style.color='#93c5fd';"
                                   onmouseout="this.style.backgroundColor='transparent'; this.style.color='#60a5fa';">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>

                                {{-- Toggle Status --}}
                                <form method="POST" action="{{ route('admin.voters.toggle-status', $voter) }}" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit"
                                            title="{{ $voter->status === 'active' ? 'Deactivate' : 'Activate' }}"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg transition-all duration-200"
                                            style="color: {{ $voter->status === 'active' ? '#fbbf24' : '#6ee7b7' }};"
                                            onmouseover="this.style.backgroundColor='{{ $voter->status === 'active' ? 'rgba(251, 191, 36, 0.2)' : 'rgba(110, 231, 183, 0.2)' }}';"
                                            onmouseout="this.style.backgroundColor='transparent';">
                                        <i class="fas {{ $voter->status === 'active' ? 'fa-toggle-on' : 'fa-toggle-off' }} text-sm"></i>
                                    </button>
                                </form>

                                {{-- Delete --}}
                                <button type="button"
                                        title="Delete"
                                        @click="$dispatch('open-modal', 'delete-voter-{{ $voter->id }}')"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg
                                               transition-all duration-200"
                                        style="color: #f87171;"
                                        onmouseover="this.style.backgroundColor='rgba(248, 113, 113, 0.2)'; this.style.color='#fca5a5';"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#f87171';">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>

                            {{-- Delete Modal --}}
                            <x-modal name="delete-voter-{{ $voter->id }}" focusable>
                                <div class="p-6" style="background: linear-gradient(to bottom right, rgba(56, 0, 65, 0.8), rgba(30, 0, 37, 0.8));">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0"
                                             style="background: rgba(239, 68, 68, 0.3); color: #f87171;">
                                            <i class="fas fa-user-slash text-lg"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-bold" style="color: #fffbf0;">Delete Voter Account</h3>
                                            <p class="text-sm" style="color: rgba(255, 251, 240, 0.6);">This action cannot be undone.</p>
                                        </div>
                                    </div>
                                    <p class="text-sm mb-6" style="color: rgba(255, 251, 240, 0.8);">
                                        Are you sure you want to delete <strong>{{ $voter->full_name }}</strong>'s account? All their vote data will also be removed.
                                    </p>
                                    <div class="flex justify-end gap-3">
                                        <button type="button" x-on:click="$dispatch('close')"
                                                class="px-4 py-2 rounded-lg text-sm font-semibold
                                                       border transition-all duration-200"
                                                style="color: #fcd558; border-color: rgba(249, 180, 15, 0.3);"
                                                onmouseover="this.style.backgroundColor='rgba(249, 180, 15, 0.1)';"
                                                onmouseout="this.style.backgroundColor='transparent';">
                                            Cancel
                                        </button>
                                        <form method="POST" action="{{ route('admin.voters.destroy', $voter) }}" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="px-4 py-2 rounded-lg text-sm font-bold
                                                           transition-all duration-200"
                                                    style="background: linear-gradient(135deg, #ef4444, #dc2626); color: #fef3c7; box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3);"
                                                    onmouseover="this.style.boxShadow='0 10px 20px rgba(239, 68, 68, 0.4)'; this.style.transform='translateY(-2px)';"
                                                    onmouseout="this.style.boxShadow='0 4px 14px rgba(239, 68, 68, 0.3)'; this.style.transform='translateY(0)';">
                                                <i class="fas fa-trash text-xs mr-1.5"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </x-modal>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 rounded-xl flex items-center justify-center" style="background: rgba(249, 180, 15, 0.2);">
                                    <i class="fas fa-users text-2xl" style="color: #f9b40f;"></i>
                                </div>
                                <p class="font-medium" style="color: rgba(255, 251, 240, 0.7);">No voters found</p>
                                <a href="{{ route('admin.voters.create') }}"
                                   class="text-sm transition-colors"
                                   style="color: #fcd558;"
                                   onmouseover="this.style.color='#fffbf0'; this.style.textDecoration='underline';"
                                   onmouseout="this.style.color='#fcd558'; this.style.textDecoration='none';">
                                    Add the first voter →
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($voters->hasPages())
            <div class="px-5 py-4" style="border-top: 1px solid rgba(249, 180, 15, 0.2);">
                {{ $voters->withQueryString()->links() }}
            </div>
        @endif
    </div>
</x-app-layout>