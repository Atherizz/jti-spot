<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClassGroup;
use Illuminate\Http\JsonResponse;

class ClassGroupController extends Controller
{
    public function index(): JsonResponse
    {
        $classGroups = ClassGroup::query()
            ->orderBy('major')
            ->orderBy('name')
            ->get(['id', 'name', 'major']);

        return response()->json([
            'data' => $classGroups,
        ]);
    }
}
