@php
    $isEdit = isset($user);
    $isEditingAdmin = $isEdit && ($user->role ?? null) === 'admin';
@endphp

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-5 sm:p-6 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-900">{{ $isEdit ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</h2>
        <p class="text-sm text-gray-500 mt-0.5">Lengkapi data akun pengguna sesuai kebutuhan sistem.</p>
    </div>

    <div class="p-5 sm:p-6 space-y-5">
        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                <p class="text-sm font-semibold text-red-700 mb-1">Terdapat input yang belum valid:</p>
                <ul class="text-xs text-red-600 list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name ?? '') }}"
                    required
                    {{ $isEdit ? 'readonly' : '' }}
                    class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent {{ $isEdit ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : '' }}"
                >
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email ?? '') }}"
                    required
                    {{ $isEdit ? 'readonly' : '' }}
                    class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent {{ $isEdit ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : '' }}"
                >
            </div>

            <div>
                <label for="reg_number" class="block text-sm font-semibold text-gray-700 mb-1.5">NIM/NIP</label>
                <input
                    id="reg_number"
                    type="text"
                    name="reg_number"
                    value="{{ old('reg_number', $user->reg_number ?? '') }}"
                    {{ $isEdit ? 'readonly' : '' }}
                    class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent {{ $isEdit ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : '' }}"
                >
            </div>

            <div>
                <label for="role" class="block text-sm font-semibold text-gray-700 mb-1.5">Peran</label>
                @php
                    $selectedRole = old('role', $user->role ?? 'admin');
                @endphp

                @if ($isEdit && $isEditingAdmin)
                    <select
                        id="role"
                        disabled
                        class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-100 text-gray-500 cursor-not-allowed"
                    >
                        <option value="admin" selected>Admin</option>
                    </select>
                    <input type="hidden" name="role" value="admin">
                @elseif ($isEdit)
                    <select
                        id="role"
                        name="role"
                        required
                        class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    >
                        <option value="class_rep" {{ $selectedRole === 'class_rep' ? 'selected' : '' }}>Ketua Kelas</option>
                        <option value="student" {{ $selectedRole === 'student' ? 'selected' : '' }}>Mahasiswa</option>
                    </select>
                @else
                    <input
                        type="text"
                        value="Admin"
                        readonly
                        class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl bg-gray-100 text-gray-500 cursor-not-allowed"
                    >
                    <input type="hidden" name="role" value="admin">
                @endif
            </div>

            @if ($isEdit)
                <div id="class-group-wrapper" class="md:col-span-2">
                    <label for="class_group_id" class="block text-sm font-semibold text-gray-700 mb-1.5">Kelas</label>
                    <select
                        id="class_group_id"
                        name="class_group_id"
                        disabled
                        class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-gray-100 text-gray-500 cursor-not-allowed"
                    >
                        <option value="">Pilih kelas</option>
                        @foreach ($classGroups as $classGroup)
                            <option
                                value="{{ $classGroup->id }}"
                                {{ (string) old('class_group_id', $user->class_group_id ?? '') === (string) $classGroup->id ? 'selected' : '' }}
                            >
                                {{ $classGroup->major }} {{ $classGroup->name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="class_group_id" value="{{ old('class_group_id', $user->class_group_id ?? '') }}">
                    <p class="text-xs text-gray-500 mt-1">Wajib untuk role Mahasiswa dan Ketua Kelas.</p>
                </div>
            @endif

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Kata Sandi {{ $isEdit ? '(kosongkan jika tidak diubah)' : '' }}
                </label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    {{ $isEdit ? '' : 'required' }}
                    class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                >
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Kata Sandi</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    {{ $isEdit ? '' : 'required' }}
                    class="w-full px-3.5 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                >
            </div>
        </div>
    </div>

    <div class="px-5 sm:px-6 py-4 border-t border-gray-100 bg-gray-50/60 flex items-center justify-end gap-2.5">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
            Batal
        </a>
        <button type="submit" class="inline-flex items-center px-4 py-2.5 text-sm font-semibold text-white bg-orange-900 rounded-xl hover:bg-orange-800 transition-colors">
            {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Pengguna' }}
        </button>
    </div>
</div>

@push('scripts')
    <script>
        (function () {
            const roleElement = document.getElementById('role');
            const classGroupWrapper = document.getElementById('class-group-wrapper');
            const classGroupField = document.getElementById('class_group_id');

            if (!roleElement || !classGroupWrapper || !classGroupField) {
                return;
            }

            const refreshClassGroupVisibility = () => {
                const role = roleElement.value;
                const needsClass = role === 'student' || role === 'class_rep';

                classGroupWrapper.classList.toggle('hidden', !needsClass);
                classGroupField.required = needsClass;

                if (!needsClass) {
                    classGroupField.value = '';
                }
            };

            roleElement.addEventListener('change', refreshClassGroupVisibility);
            refreshClassGroupVisibility();
        })();
    </script>
@endpush

