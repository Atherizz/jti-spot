<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ClassGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Throwable;

class AdminClassGroupController extends Controller
{
    public function index(): View
    {
        $classGroups = ClassGroup::query()
            ->orderBy('major')
            ->orderBy('name')
            ->get();

        return view('admin.class_groups.index', [
            'classGroups' => $classGroups,
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
}
