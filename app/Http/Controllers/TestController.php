<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function test(Request $request) {
        $user = Auth::user();
        return new JsonResponse([
            'name' => $user->name,
            'tokens' => $user->tokens->count()
        ]);
    }
}
