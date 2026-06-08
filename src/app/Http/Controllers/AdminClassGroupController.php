<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ClassGroup;
use App\Models\Major;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class AdminClassGroupController extends Controller
{
    public function index(): View
    {
        $classGroups = ClassGroup::query()
            ->orderBy('major')
            ->orderBy('name')
            ->get();

        $majors = Major::query()
            ->orderBy('name')
            ->get();

        return view('admin.class_groups.index', [
            'classGroups' => $classGroups,
            'majors' => $majors,
        ]);
    }

    public function generateToken(ClassGroup $classGroup): RedirectResponse
    {
        try {
            $newToken = $this->generateUniqueToken($classGroup);

            $classGroup->update([
                'access_token' => $newToken,
            ]);

            return redirect()
                ->route('admin.class-groups.index')
                ->with('success', 'Access token untuk kelas ' . strtoupper($classGroup->major . $classGroup->name) . ' berhasil diperbarui.');
        } catch (Throwable $throwable) {
            report($throwable);

            return redirect()
                ->route('admin.class-groups.index')
                ->with('error', 'Gagal memperbarui access token. Silakan coba lagi.');
        }
    }

    /**
     * Store a new prodi (major).
     */
    public function storeProdi(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:majors,name'],
        ], [
            'name.required' => 'Nama prodi wajib diisi.',
            'name.max' => 'Nama prodi maksimal 50 karakter.',
            'name.unique' => 'Prodi dengan nama tersebut sudah ada.',
        ]);

        try {
            Major::create([
                'name' => strtoupper(trim($validated['name'])),
            ]);

            return redirect()
                ->route('admin.class-groups.index')
                ->with('success', 'Prodi ' . strtoupper(trim($validated['name'])) . ' berhasil ditambahkan.');
        } catch (Throwable $throwable) {
            report($throwable);

            return redirect()
                ->route('admin.class-groups.index')
                ->with('error', 'Gagal menambahkan prodi. Silakan coba lagi.');
        }
    }

    /**
     * Update an existing prodi (major) and sync all related class_groups.
     */
    public function updateProdi(Request $request, Major $major): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', Rule::unique('majors', 'name')->ignore($major->id)],
        ], [
            'name.required' => 'Nama prodi wajib diisi.',
            'name.max' => 'Nama prodi maksimal 50 karakter.',
            'name.unique' => 'Prodi dengan nama tersebut sudah ada.',
        ]);

        $oldName = $major->name;
        $newName = strtoupper(trim($validated['name']));

        if ($oldName === $newName) {
            return redirect()
                ->route('admin.class-groups.index')
                ->with('success', 'Tidak ada perubahan pada prodi ' . $oldName . '.');
        }

        try {
            DB::transaction(function () use ($major, $oldName, $newName): void {
                $major->update(['name' => $newName]);

                ClassGroup::query()
                    ->where('major', $oldName)
                    ->update(['major' => $newName]);
            });

            return redirect()
                ->route('admin.class-groups.index')
                ->with('success', 'Prodi ' . $oldName . ' berhasil diubah menjadi ' . $newName . '.');
        } catch (Throwable $throwable) {
            report($throwable);

            return redirect()
                ->route('admin.class-groups.index')
                ->with('error', 'Gagal memperbarui prodi. Silakan coba lagi.');
        }
    }

    /**
     * Delete a prodi (major) if no class groups are using it.
     */
    public function destroyProdi(Major $major): RedirectResponse
    {
        $classGroupCount = ClassGroup::query()
            ->where('major', $major->name)
            ->count();

        if ($classGroupCount > 0) {
            return redirect()
                ->route('admin.class-groups.index')
                ->with('error', 'Prodi ' . $major->name . ' tidak dapat dihapus karena masih digunakan oleh ' . $classGroupCount . ' kelas.');
        }

        try {
            $deletedName = $major->name;
            $major->delete();

            return redirect()
                ->route('admin.class-groups.index')
                ->with('success', 'Prodi ' . $deletedName . ' berhasil dihapus.');
        } catch (Throwable $throwable) {
            report($throwable);

            return redirect()
                ->route('admin.class-groups.index')
                ->with('error', 'Gagal menghapus prodi. Silakan coba lagi.');
        }
    }

    private function generateUniqueToken(ClassGroup $classGroup): string
    {
        $prefix = strtoupper(trim((string) $classGroup->major) . trim((string) $classGroup->name));

        do {
            $candidateToken = $prefix . '-' . strtolower(Str::random(6));
        } while (
            ClassGroup::query()
                ->where('access_token', $candidateToken)
                ->whereKeyNot($classGroup->id)
                ->exists()
        );

        return $candidateToken;
    }

    /**
     * Store a new class group.
     */
    public function storeClass(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'major' => ['required', 'string', 'exists:majors,name'],
            'name' => ['required', 'string', 'max:50'],
        ], [
            'major.required' => 'Prodi wajib dipilih.',
            'major.exists' => 'Prodi tidak ditemukan.',
            'name.required' => 'Nama kelas wajib diisi.',
            'name.max' => 'Nama kelas maksimal 50 karakter.',
        ]);

        $major = strtoupper(trim($validated['major']));
        $name = strtoupper(trim($validated['name']));

        $exists = ClassGroup::query()
            ->where('major', $major)
            ->where('name', $name)
            ->exists();

        if ($exists) {
            return redirect()
                ->route('admin.class-groups.index')
                ->with('error', 'Kelas ' . $name . ' pada prodi ' . $major . ' sudah ada.');
        }

        try {
            $classGroup = ClassGroup::create([
                'major' => $major,
                'name' => $name,
            ]);

            // Generate initial token
            $classGroup->update([
                'access_token' => $this->generateUniqueToken($classGroup),
            ]);

            return redirect()
                ->route('admin.class-groups.index')
                ->with('success', 'Kelas ' . $major . ' ' . $name . ' berhasil ditambahkan.');
        } catch (Throwable $throwable) {
            report($throwable);

            return redirect()
                ->route('admin.class-groups.index')
                ->with('error', 'Gagal menambahkan kelas. Silakan coba lagi.');
        }
    }

    /**
     * Update an existing class group.
     */
    public function updateClass(Request $request, ClassGroup $classGroup): RedirectResponse
    {
        $validated = $request->validate([
            'major' => ['required', 'string', 'exists:majors,name'],
            'name' => ['required', 'string', 'max:50'],
        ], [
            'major.required' => 'Prodi wajib dipilih.',
            'major.exists' => 'Prodi tidak ditemukan.',
            'name.required' => 'Nama kelas wajib diisi.',
            'name.max' => 'Nama kelas maksimal 50 karakter.',
        ]);

        $major = strtoupper(trim($validated['major']));
        $name = strtoupper(trim($validated['name']));

        if ($classGroup->major === $major && $classGroup->name === $name) {
            return redirect()
                ->route('admin.class-groups.index')
                ->with('success', 'Tidak ada perubahan pada kelas ' . $classGroup->major . ' ' . $classGroup->name . '.');
        }

        $exists = ClassGroup::query()
            ->where('major', $major)
            ->where('name', $name)
            ->whereKeyNot($classGroup->id)
            ->exists();

        if ($exists) {
            return redirect()
                ->route('admin.class-groups.index')
                ->with('error', 'Kelas ' . $name . ' pada prodi ' . $major . ' sudah ada.');
        }

        try {
            $oldName = $classGroup->major . ' ' . $classGroup->name;
            $classGroup->update([
                'major' => $major,
                'name' => $name,
            ]);

            return redirect()
                ->route('admin.class-groups.index')
                ->with('success', 'Kelas ' . $oldName . ' berhasil diubah menjadi ' . $major . ' ' . $name . '.');
        } catch (Throwable $throwable) {
            report($throwable);

            return redirect()
                ->route('admin.class-groups.index')
                ->with('error', 'Gagal memperbarui kelas. Silakan coba lagi.');
        }
    }

    /**
     * Delete a class group.
     */
    public function destroyClass(ClassGroup $classGroup): RedirectResponse
    {
        $hasUsers = $classGroup->users()->exists();
        $hasSchedules = $classGroup->schedules()->exists();

        if ($hasUsers || $hasSchedules) {
            $reason = [];
            if ($hasUsers) $reason[] = 'mahasiswa';
            if ($hasSchedules) $reason[] = 'jadwal';
            
            return redirect()
                ->route('admin.class-groups.index')
                ->with('error', 'Kelas ' . $classGroup->major . ' ' . $classGroup->name . ' tidak dapat dihapus karena masih terhubung dengan data ' . implode(' dan ', $reason) . '.');
        }

        try {
            $deletedName = $classGroup->major . ' ' . $classGroup->name;
            $classGroup->delete();

            return redirect()
                ->route('admin.class-groups.index')
                ->with('success', 'Kelas ' . $deletedName . ' berhasil dihapus.');
        } catch (Throwable $throwable) {
            report($throwable);

            return redirect()
                ->route('admin.class-groups.index')
                ->with('error', 'Gagal menghapus kelas. Silakan coba lagi.');
        }
    }
}
