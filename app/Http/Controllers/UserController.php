<?php

namespace App\Http\Controllers;

use App\Http\Requests\TokenRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * @param TokenRequest $request
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function login(TokenRequest $request) {
        $data = $request->validated();
        if (! $user = User::firstWhere('email', $data['email'])) {
            throw new AuthenticationException('пользователь не найден');
        }
        if (! Hash::check($data['password'], $user->password)) {
            throw new AuthenticationException('пользователь не найден');
        }
        // по умолчанию sanctum хранит в бд хешированную копию, по этому каждый раз создаем новый токен
        $token = $user->createToken('api', ['notes:create', 'notes:update']);
        return new JsonResponse([
            'name'  => $user->email,
            'email' => $user->email,
            'token' => $token->plainTextToken
        ]);
    }

    /**
     * @param TokenRequest $request
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function register(TokenRequest $request) {
        $data = $request->validated();
        if (User::firstWhere('email', $data['email'])) {
            throw new AuthenticationException('user exists');
        }
        $user = User::create([
            'name'     => $data['email'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $token = $user->createToken('api', ['notes:create', 'notes:update']);
        return new JsonResponse([
            'name'  => $user->name,
            'email' => $user->email,
            'token' => $token->plainTextToken
        ]);
    }
}
