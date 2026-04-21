@extends('layouts.dashboard')

@section('title', 'Manajemen Kelas')

@section('content')
    @php
        $generateTokenRouteTemplate = route('admin.class-groups.generate-token', ['classGroup' => '__CLASS_GROUP_ID__']);

        $serializedClassGroups = $classGroups
            ->map(fn ($classGroup) => [
                'id' => $classGroup->id,
                'major' => strtoupper((string) $classGroup->major),
                'name' => strtoupper((string) $classGroup->name),
                'access_token' => $classGroup->access_token,
            ])
            ->values();
    @endphp

    <div class="mb-8 bg-white editorial-panel p-8 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-orange-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></div>
                <span class="font-display font-semibold uppercase tracking-widest text-[11px] text-ink/50">Administrasi Akademik</span>
            </div>
            <h1 class="font-display text-3xl sm:text-4xl font-bold tracking-tight text-ink leading-tight">Manajemen Kelas</h1>
            <p class="text-sm font-medium text-ink/60 mt-2 max-w-2xl">
                Pilih prodi dan kelas pada panel berikut untuk melihat access token secara instan tanpa berpindah halaman.
            </p>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800 flex items-center gap-2">
            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <section class="lg:col-span-1 bg-white editorial-panel p-6">
            <div class="mb-6">
                <p class="text-xs font-semibold uppercase tracking-widest text-ink/50 mb-3">Pilih Prodi</p>
                <div class="grid grid-cols-2 gap-2" id="major-selector">
                    <button type="button" data-major="TI" class="major-button px-4 py-2.5 rounded-xl text-sm font-semibold border border-gray-200 text-ink/70 hover:bg-gray-50 transition-colors">
                        TI
                    </button>
                    <button type="button" data-major="SIB" class="major-button px-4 py-2.5 rounded-xl text-sm font-semibold border border-gray-200 text-ink/70 hover:bg-gray-50 transition-colors">
                        SIB
                    </button>
                </div>
            </div>

            <div>
                <label for="class-select" class="block text-xs font-semibold uppercase tracking-widest text-ink/50 mb-2">Pilih Kelas</label>
                <select id="class-select" class="w-full rounded-xl border-gray-200 text-sm font-medium text-ink focus:border-orange-300 focus:ring-orange-200">
                    <option value="">Pilih kelas...</option>
                </select>
            </div>
        </section>

        <section class="lg:col-span-2 bg-white editorial-panel p-6">
            <p class="text-xs font-semibold uppercase tracking-widest text-ink/50 mb-4">Detail Access Token</p>

            <div id="empty-state" class="rounded-2xl border border-dashed border-gray-300 p-8 text-center text-sm font-medium text-gray-500">
                Pilih prodi dan kelas untuk menampilkan access token.
            </div>

            <div id="token-card" class="hidden rounded-2xl border border-orange-100 bg-orange-50/40 p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                    <div>
                        <p class="text-[11px] uppercase tracking-widest font-semibold text-ink/50">Prodi</p>
                        <p id="token-major" class="mt-1 text-lg font-display font-bold text-ink"></p>
                    </div>
                    <div>
                        <p class="text-[11px] uppercase tracking-widest font-semibold text-ink/50">Kelas</p>
                        <p id="token-class" class="mt-1 text-lg font-display font-bold text-ink"></p>
                    </div>
                </div>

                <div>
                    <p class="text-[11px] uppercase tracking-widest font-semibold text-ink/50 mb-2">Access Token</p>
                    <div class="rounded-xl bg-ink px-4 py-3 text-sm sm:text-base font-mono font-semibold text-orange-200 break-all" id="token-value">-</div>
                </div>

                <form id="generate-token-form" method="POST" action="#" class="mt-5" onsubmit="return confirm('Generate ulang token untuk kelas ini? Token lama akan tidak berlaku.')">
                    @csrf
                    <button id="generate-token-button" type="submit" disabled class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-semibold rounded-xl transition-colors bg-orange-500 text-white hover:bg-orange-600 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-orange-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Generate Ulang Token
                    </button>
                </form>
            </div>
        </section>

        <section class="lg:col-span-3 bg-white editorial-panel p-6">
            <p class="text-xs font-semibold uppercase tracking-widest text-ink/50 mb-4">Ringkasan Kelas</p>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50/80">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Prodi</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Kelas</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Access Token</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($classGroups as $classGroup)
                            <tr class="hover:bg-gray-50/60 transition-colors">
                                <td class="px-4 py-3 text-sm font-semibold text-ink">{{ strtoupper((string) $classGroup->major) }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-ink">{{ strtoupper((string) $classGroup->name) }}</td>
                                <td class="px-4 py-3 text-sm font-mono text-ink/80">{{ $classGroup->access_token ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <form method="POST" action="{{ route('admin.class-groups.generate-token', $classGroup) }}" onsubmit="return confirm('Generate ulang token untuk kelas {{ strtoupper((string) $classGroup->major) }}{{ strtoupper((string) $classGroup->name) }}?')">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-ink hover:bg-ink/90 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Generate Ulang
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-10 text-center text-sm font-medium text-gray-500">Data kelas belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <script>
        (() => {
            const classGroups = @json($serializedClassGroups);
            const majorButtons = document.querySelectorAll('.major-button');
            const classSelect = document.getElementById('class-select');
            const emptyState = document.getElementById('empty-state');
            const tokenCard = document.getElementById('token-card');
            const tokenMajor = document.getElementById('token-major');
            const tokenClass = document.getElementById('token-class');
            const tokenValue = document.getElementById('token-value');
            const generateTokenForm = document.getElementById('generate-token-form');
            const generateTokenButton = document.getElementById('generate-token-button');
            const generateTokenRouteTemplate = @json($generateTokenRouteTemplate);

            let selectedMajor = 'TI';

            const byNameSorter = (left, right) => left.name.localeCompare(right.name, 'id');

            const getClassesByMajor = (major) => {
                return classGroups
                    .filter((item) => item.major === major)
                    .sort(byNameSorter);
            };

            const setMajorButtonState = () => {
                majorButtons.forEach((button) => {
                    const isActive = button.dataset.major === selectedMajor;

                    button.classList.toggle('bg-ink', isActive);
                    button.classList.toggle('text-white', isActive);
                    button.classList.toggle('border-ink', isActive);
                    button.classList.toggle('text-ink/70', !isActive);
                    button.classList.toggle('border-gray-200', !isActive);
                });
            };

            const showSelection = (item) => {
                emptyState.classList.add('hidden');
                tokenCard.classList.remove('hidden');

                tokenMajor.textContent = item.major;
                tokenClass.textContent = item.name;
                tokenValue.textContent = item.access_token ?? '-';
                generateTokenForm.action = generateTokenRouteTemplate.replace('__CLASS_GROUP_ID__', String(item.id));
                generateTokenButton.disabled = false;
            };

            const resetSelection = () => {
                tokenCard.classList.add('hidden');
                emptyState.classList.remove('hidden');
                generateTokenForm.action = '#';
                generateTokenButton.disabled = true;
            };

            const buildClassOptions = () => {
                const classes = getClassesByMajor(selectedMajor);

                classSelect.innerHTML = '<option value="">Pilih kelas...</option>';

                classes.forEach((item) => {
                    const option = document.createElement('option');
                    option.value = String(item.id);
                    option.textContent = item.name;
                    classSelect.appendChild(option);
                });

                resetSelection();
            };

            majorButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    selectedMajor = button.dataset.major ?? 'TI';
                    setMajorButtonState();
                    buildClassOptions();
                });
            });

            classSelect.addEventListener('change', (event) => {
                const value = Number(event.target.value);

                if (!value) {
                    resetSelection();
                    return;
                }

                const selectedClass = classGroups.find((item) => item.id === value);

                if (!selectedClass) {
                    resetSelection();
                    return;
                }

                showSelection(selectedClass);
            });

            setMajorButtonState();
            buildClassOptions();
        })();
    </script>
@endsection
