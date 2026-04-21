<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ClassGroup;
use Illuminate\Contracts\View\View;

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
}
