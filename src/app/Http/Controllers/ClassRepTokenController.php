<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ClassGroup;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ClassRepTokenController extends Controller
{
    public function claim(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'token' => ['required', 'string', 'max:64'],
        ]);

        $user = $request->user();

        try {
            DB::transaction(function () use ($user, $validated): void {
                $classGroup = ClassGroup::query()
                    ->where('access_token', trim($validated['token']))
                    ->lockForUpdate()
                    ->first();

                if (! $classGroup) {
                    throw new DomainException('Token tidak valid.');
                }

                if ((int) $classGroup->token_quota <= 0) {
                    throw new DomainException('Kuota klaim untuk kelas ini sudah penuh.');
                }

                if ($user->role === 'class_rep') {
                    throw new DomainException('Anda sudah memiliki akses class representative.');
                }

                if ($user->role !== 'student') {
                    throw new DomainException('Role akun Anda tidak dapat melakukan klaim token.');
                }

                if (! $user->class_group_id) {
                    throw new DomainException('Akun Anda belum terhubung ke kelas.');
                }

                if ((int) $user->class_group_id !== (int) $classGroup->id) {
                    throw new DomainException('Token ini bukan untuk kelas Anda.');
                }

                $user->update([
                    'role' => 'class_rep',
                ]);

                $classGroup->decrement('token_quota');
            });

            return redirect()
                ->route('profile.show')
                ->with('success', 'Berhasil! Role Anda diperbarui menjadi Ketua Kelas.')
                ->with('claim_success', true);
        } catch (DomainException $exception) {
            return redirect()
                ->route('profile.show')
                ->withErrors(['token' => $exception->getMessage()])
                ->withInput();
        } catch (Throwable $throwable) {
            report($throwable);

            return redirect()
                ->route('profile.show')
                ->withErrors(['token' => 'Terjadi kesalahan saat klaim token. Silakan coba lagi.'])
                ->withInput();
        }
    }
}
