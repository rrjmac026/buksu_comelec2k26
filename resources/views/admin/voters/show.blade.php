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
             class="mb-4 flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg"
             style="background: rgba(52, 211, 153, 0.1); border: 1px solid rgba(52, 211, 153, 0.4); color: #34d399;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Left: Profile Card --}}
        <div class="lg:col-span-1 space-y-4">

            {{-- Avatar & Name --}}
            <div class="rounded-2xl shadow-lg overflow-hidden"
                 style="background: linear-gradient(to bottom right, rgba(56, 0, 65, 0.4), rgba(30, 0, 37, 0.6)); border: 1px solid rgba(249, 180, 15, 0.2); padding: 1.5rem; text-align: center;">
                <div class="w-20 h-20 rounded-lg bg-gradient-to-br from-[#fcd558] to-[#f9b40f]
                            flex items-center justify-center text-[#1e0025] text-3xl font-bold
                            shadow-lg mx-auto mb-4"
                     style="box-shadow: 0 4px 14px rgba(249, 180, 15, 0.3);">
                    {{ strtoupper(substr($voter->full_name, 0, 1)) }}
                </div>
                <h3 class="font-bold text-lg" style="color: #fffbf0;">{{ $voter->full_name }}</h3>
                <p class="text-sm mt-0.5" style="color: rgba(255, 251, 240, 0.6);">{{ $voter->email }}</p>

                <div class="mt-3">
                    @if($voter->status === 'active')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold"
                              style="background: rgba(52, 211, 153, 0.3); color: #6ee7b7; border: 1px solid rgba(52, 211, 153, 0.5);">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold"
                              style="background: rgba(239, 68, 68, 0.3); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.5);">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Inactive
                        </span>
                    @endif
                </div>

                <div class="mt-5 pt-4 space-y-2" style="border-top: 1px solid rgba(249, 180, 15, 0.2);">
                    <form method="POST" action="{{ route('admin.voters.toggle-status', $voter) }}">
                        @csrf @method('PATCH')
                        <button type="submit"
                                class="w-full py-2 rounded-lg text-sm font-semibold transition-all duration-200"
                                style="color: {{ $voter->status === 'active' ? '#fbbf24' : '#6ee7b7' }}; border: 1px solid {{ $voter->status === 'active' ? 'rgba(251, 191, 36, 0.3)' : 'rgba(110, 231, 183, 0.3)' }};"
                                onmouseover="this.style.backgroundColor='{{ $voter->status === 'active' ? 'rgba(251, 191, 36, 0.2)' : 'rgba(110, 231, 183, 0.2)' }}';"
                                onmouseout="this.style.backgroundColor='transparent';">
                            <i class="fas {{ $voter->status === 'active' ? 'fa-ban' : 'fa-circle-check' }} mr-2"></i>
                            {{ $voter->status === 'active' ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>

                    <button type="button" @click="$dispatch('open-modal', 'delete-voter')"
                            class="w-full py-2 rounded-lg text-sm font-semibold transition-all duration-200"
                            style="color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3);"
                            onmouseover="this.style.backgroundColor='rgba(239, 68, 68, 0.2)';"
                            onmouseout="this.style.backgroundColor='transparent';">
                        <i class="fas fa-trash mr-2"></i> Delete Account
                    </button>
                </div>
            </div>

            {{-- Academic Details --}}
            <div class="rounded-2xl shadow-lg overflow-hidden"
                 style="background: linear-gradient(to bottom right, rgba(56, 0, 65, 0.4), rgba(30, 0, 37, 0.6)); border: 1px solid rgba(249, 180, 15, 0.2); padding: 1.25rem;">
                <h4 class="font-semibold text-sm mb-4 flex items-center gap-2" style="color: #fcd558;">
                    <i class="fas fa-graduation-cap"></i> Academic Info
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
                        <span class="text-xs font-medium shrink-0" style="color: #fcd558;">{{ $item['label'] }}</span>
                        <span class="text-sm text-right {{ $item['mono'] ? 'font-mono' : 'font-medium' }}" style="color: #fffbf0;">
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
                <div class="rounded-2xl shadow-lg p-4 text-center"
                     style="background: linear-gradient(to bottom right, rgba(56, 0, 65, 0.4), rgba(30, 0, 37, 0.6)); border: 1px solid rgba(249, 180, 15, 0.2);">
                    <div class="text-2xl font-bold" style="color: #fcd558;">{{ $voteCount }}</div>
                    <div class="text-xs font-medium mt-0.5" style="color: rgba(255, 251, 240, 0.6);">Votes Cast</div>
                </div>
                <div class="rounded-2xl shadow-lg p-4 text-center"
                     style="background: linear-gradient(to bottom right, rgba(56, 0, 65, 0.4), rgba(30, 0, 37, 0.6)); border: 1px solid rgba(249, 180, 15, 0.2);">
                    <div class="text-2xl font-bold" style="color: {{ $voteCount > 0 ? '#6ee7b7' : 'rgba(255, 251, 240, 0.4)' }};">
                        {{ $voteCount > 0 ? 'Yes' : 'No' }}
                    </div>
                    <div class="text-xs font-medium mt-0.5" style="color: rgba(255, 251, 240, 0.6);">Has Voted</div>
                </div>
                <div class="rounded-2xl shadow-lg p-4 text-center"
                     style="background: linear-gradient(to bottom right, rgba(56, 0, 65, 0.4), rgba(30, 0, 37, 0.6)); border: 1px solid rgba(249, 180, 15, 0.2);">
                    <div class="text-xs font-bold font-mono" style="color: #fffbf0;">
                        {{ $voter->created_at?->format('M d, Y') ?? '—' }}
                    </div>
                    <div class="text-xs font-medium mt-0.5" style="color: rgba(255, 251, 240, 0.6);">Registered</div>
                </div>
            </div>

            {{-- Vote History Table --}}
            <div class="rounded-2xl shadow-lg overflow-hidden"
                 style="background: linear-gradient(to bottom right, rgba(56, 0, 65, 0.4), rgba(30, 0, 37, 0.6)); border: 1px solid rgba(249, 180, 15, 0.2);">
                <div class="px-5 py-4" style="background: linear-gradient(to right, rgba(56, 0, 65, 0.6), transparent); border-bottom: 1px solid rgba(249, 180, 15, 0.2);">
                    <h4 class="font-semibold flex items-center gap-2" style="color: #fcd558;">
                        <i class="fas fa-ballot-check"></i> Vote History
                    </h4>
                </div>

                @if($voter->votes->isEmpty())
                    <div class="py-14 text-center">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center mx-auto mb-3"
                             style="background: rgba(249, 180, 15, 0.2);">
                            <i class="fas fa-box-open text-2xl" style="color: #f9b40f;"></i>
                        </div>
                        <p class="text-sm font-medium" style="color: rgba(255, 251, 240, 0.7);">No votes cast yet</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr style="background: linear-gradient(to right, rgba(56, 0, 65, 0.6), transparent); border-bottom: 1px solid rgba(249, 180, 15, 0.2);">
                                    <th class="text-left px-5 py-3 text-xs font-bold uppercase tracking-wider" style="color: #fcd558;">Position</th>
                                    <th class="text-left px-5 py-3 text-xs font-bold uppercase tracking-wider" style="color: #fcd558;">Candidate</th>
                                    <th class="text-left px-5 py-3 text-xs font-bold uppercase tracking-wider hidden sm:table-cell" style="color: #fcd558;">Date & Time</th>
                                    <th class="text-left px-5 py-3 text-xs font-bold uppercase tracking-wider hidden md:table-cell" style="color: #fcd558;">Transaction</th>
                                </tr>
                            </thead>
                            <tbody style="border-collapse: collapse;">
                                @foreach($voter->votes as $vote)
                                <tr class="transition-colors duration-150" style="border-bottom: 1px solid rgba(249, 180, 15, 0.1); background: linear-gradient(to right, rgba(249, 180, 15, 0.02), transparent);">
                                    <td class="px-5 py-3.5"
                                        style="color: #fffbf0; font-weight: 500;">
                                        {{ $vote->position->name ?? '—' }}
                                    </td>
                                    <td class="px-5 py-3.5" style="color: #fffbf0;">
                                        {{ $vote->candidate ? $vote->candidate->first_name . ' ' . $vote->candidate->last_name : '—' }}
                                    </td>
                                    <td class="px-5 py-3.5 hidden sm:table-cell text-xs"
                                        style="color: #fcd558;">
                                        {{ $vote->voted_at?->format('M d, Y h:i A') ?? '—' }}
                                    </td>
                                    <td class="px-5 py-3.5 hidden md:table-cell">
                                        <span class="font-mono text-xs px-2.5 py-1 rounded-lg"
                                              style="background: rgba(249, 180, 15, 0.2); color: #fcd558;">
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
                Are you sure you want to permanently delete <strong>{{ $voter->full_name }}</strong>'s account? All associated vote data will be removed.
            </p>
            <div class="flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                        class="px-4 py-2 rounded-lg text-sm font-semibold border transition-all duration-200"
                        style="color: #fcd558; border-color: rgba(249, 180, 15, 0.3);"
                        onmouseover="this.style.backgroundColor='rgba(249, 180, 15, 0.1)';"
                        onmouseout="this.style.backgroundColor='transparent';">
                    Cancel
                </button>
                <form method="POST" action="{{ route('admin.voters.destroy', $voter) }}" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 rounded-lg text-sm font-bold transition-all duration-200"
                            style="background: linear-gradient(135deg, #ef4444, #dc2626); color: #fef3c7; box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3);"
                            onmouseover="this.style.boxShadow='0 10px 20px rgba(239, 68, 68, 0.4)'; this.style.transform='translateY(-2px)';"
                            onmouseout="this.style.boxShadow='0 4px 14px rgba(239, 68, 68, 0.3)'; this.style.transform='translateY(0)';">
                        <i class="fas fa-trash text-xs mr-1.5"></i> Delete Account
                    </button>
                </form>
            </div>
        </div>
    </x-modal>
</x-app-layout>