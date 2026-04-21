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
                'token_quota' => (int) ($classGroup->token_quota ?? 0),
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

                <div class="mt-4 rounded-xl border border-emerald-100 bg-emerald-50/60 px-4 py-3">
                    <p class="text-[11px] uppercase tracking-widest font-semibold text-emerald-700">Sisa Kuota</p>
                    <p class="mt-1 text-lg font-display font-bold text-emerald-700" id="token-quota-value">0/3</p>
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
            <div class="flex items-center justify-between mb-4">
                <p class="text-xs font-semibold uppercase tracking-widest text-ink/50">Ringkasan Kelas</p>
                <p id="summary-page-label" class="text-sm font-semibold text-ink">Kelas 1</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50/80">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Prodi</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Kelas</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Access Token</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Sisa Kuota</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="summary-table-body" class="divide-y divide-gray-100">
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-sm font-medium text-gray-500">Memuat data kelas...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="px-0 pt-4 border-t border-gray-100 bg-white flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 text-sm">
                <span id="summary-range-label" class="text-gray-500">Data 1 &mdash; 4 dari 0</span>

                <div class="flex items-center gap-1.5">
                    <button id="summary-prev-button" type="button" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-ink hover:bg-gray-50 transition-colors disabled:opacity-40 disabled:cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <div id="summary-page-buttons" class="flex items-center gap-1">
                        <button type="button" data-summary-page="1" class="summary-page-button w-8 h-8 rounded-lg flex items-center justify-center bg-ink text-white font-medium text-sm shadow-sm">1</button>
                        <button type="button" data-summary-page="2" class="summary-page-button w-8 h-8 rounded-lg flex items-center justify-center hover:bg-gray-50 text-gray-600 font-medium text-sm transition-colors">2</button>
                        <button type="button" data-summary-page="3" class="summary-page-button w-8 h-8 rounded-lg flex items-center justify-center hover:bg-gray-50 text-gray-600 font-medium text-sm transition-colors">3</button>
                        <button type="button" data-summary-page="4" class="summary-page-button w-8 h-8 rounded-lg flex items-center justify-center hover:bg-gray-50 text-gray-600 font-medium text-sm transition-colors">4</button>
                    </div>

                    <button id="summary-next-button" type="button" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-600 hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
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
            const tokenQuotaValue = document.getElementById('token-quota-value');
            const generateTokenForm = document.getElementById('generate-token-form');
            const generateTokenButton = document.getElementById('generate-token-button');
            const generateTokenRouteTemplate = @json($generateTokenRouteTemplate);
            const summaryPrevButton = document.getElementById('summary-prev-button');
            const summaryNextButton = document.getElementById('summary-next-button');
            const summaryPageLabel = document.getElementById('summary-page-label');
            const summaryRangeLabel = document.getElementById('summary-range-label');
            const summaryPageButtons = document.querySelectorAll('.summary-page-button');
            const summaryTableBody = document.getElementById('summary-table-body');

            let selectedMajor = 'TI';
            let currentSummaryPage = 1;

            const byNameSorter = (left, right) => left.name.localeCompare(right.name, 'id');

            const buildSummaryPages = () => {
                const pages = [
                    { page: 1, label: 'Kelas 1', items: [] },
                    { page: 2, label: 'Kelas 2', items: [] },
                    { page: 3, label: 'Kelas 3', items: [] },
                    { page: 4, label: 'Kelas 4 + AJ', items: [] },
                ];
                const majorOrder = {
                    TI: 0,
                    SIB: 1,
                    UMUM: 2,
                };

                classGroups.forEach((item) => {
                    const className = String(item.name ?? '').toUpperCase();
                    const level = className === 'AJ' ? 4 : Number.parseInt(className.charAt(0), 10);
                    const targetPage = Number.isInteger(level) && level >= 1 && level <= 4 ? level : 4;

                    pages[targetPage - 1].items.push(item);
                });

                pages.forEach((page) => {
                    page.items.sort((left, right) => {
                        const leftMajor = String(left.major ?? '').toUpperCase();
                        const rightMajor = String(right.major ?? '').toUpperCase();
                        const leftOrder = majorOrder[leftMajor] ?? 99;
                        const rightOrder = majorOrder[rightMajor] ?? 99;

                        if (leftOrder !== rightOrder) {
                            return leftOrder - rightOrder;
                        }

                        if (left.name === 'AJ') {
                            return 1;
                        }

                        if (right.name === 'AJ') {
                            return -1;
                        }

                        return left.name.localeCompare(right.name, 'id');
                    });
                });

                return pages;
            };

            const summaryPages = buildSummaryPages();

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
                tokenQuotaValue.textContent = `${item.token_quota ?? 0}/3`;
                generateTokenForm.action = generateTokenRouteTemplate.replace('__CLASS_GROUP_ID__', String(item.id));
                generateTokenButton.disabled = false;
            };

            const resetSelection = () => {
                tokenCard.classList.add('hidden');
                emptyState.classList.remove('hidden');
                generateTokenForm.action = '#';
                generateTokenButton.disabled = true;
            };

            const renderSummaryPage = () => {
                const summaryPage = summaryPages[currentSummaryPage - 1];
                const totalItems = summaryPages.reduce((carry, page) => carry + page.items.length, 0);
                const currentStart = totalItems === 0 ? 0 : summaryPages.slice(0, currentSummaryPage - 1).reduce((carry, page) => carry + page.items.length, 0) + 1;
                const currentEnd = totalItems === 0 ? 0 : currentStart + summaryPage.items.length - 1;

                summaryPageLabel.textContent = summaryPage.label;
                summaryRangeLabel.textContent = totalItems > 0 ? `Data ${currentStart} — ${currentEnd} dari ${totalItems}` : 'Data 0 — 0 dari 0';
                summaryPrevButton.disabled = currentSummaryPage === 1;
                summaryNextButton.disabled = currentSummaryPage === summaryPages.length;

                summaryPageButtons.forEach((button) => {
                    const isActive = Number(button.dataset.summaryPage) === currentSummaryPage;

                    button.classList.toggle('bg-ink', isActive);
                    button.classList.toggle('text-white', isActive);
                    button.classList.toggle('shadow-sm', isActive);
                    button.classList.toggle('hover:bg-gray-50', !isActive);
                    button.classList.toggle('text-gray-600', !isActive);
                });

                if (!summaryPage.items.length) {
                    summaryTableBody.innerHTML = '<tr><td colspan="5" class="px-4 py-10 text-center text-sm font-medium text-gray-500">Data kelas belum tersedia.</td></tr>';
                    return;
                }

                summaryTableBody.innerHTML = summaryPage.items.map((item) => `
                    <tr class="hover:bg-gray-50/60 transition-colors">
                        <td class="px-4 py-3 text-sm font-semibold text-ink">${item.major}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-ink">${item.name}</td>
                        <td class="px-4 py-3 text-sm font-mono text-ink/80">${item.access_token ?? '-'}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-emerald-700">${Number(item.token_quota ?? 0)}/3</td>
                        <td class="px-4 py-3">
                            <form method="POST" action="${generateTokenRouteTemplate.replace('__CLASS_GROUP_ID__', String(item.id))}" onsubmit="return confirm('Generate ulang token untuk kelas ${item.major}${item.name}?')">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-ink hover:bg-ink/90 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Generate Ulang
                                </button>
                            </form>
                        </td>
                    </tr>
                `).join('');
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

            summaryPrevButton.addEventListener('click', () => {
                if (currentSummaryPage > 1) {
                    currentSummaryPage -= 1;
                    renderSummaryPage();
                }
            });

            summaryNextButton.addEventListener('click', () => {
                if (currentSummaryPage < summaryPages.length) {
                    currentSummaryPage += 1;
                    renderSummaryPage();
                }
            });

            summaryPageButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const targetPage = Number(button.dataset.summaryPage);

                    if (Number.isInteger(targetPage) && targetPage >= 1 && targetPage <= summaryPages.length) {
                        currentSummaryPage = targetPage;
                        renderSummaryPage();
                    }
                });
            });

            setMajorButtonState();
            buildClassOptions();
            renderSummaryPage();
        })();
    </script>
@endsection
