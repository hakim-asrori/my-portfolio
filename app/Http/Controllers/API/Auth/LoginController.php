<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Interfaces\UserInterface;
use App\Http\Requests\API\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    protected $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('guest');
    }

    public function __invoke(LoginRequest $loginRequest)
    {
        $user = $this->userRepository->findByCriteria(['email' => $loginRequest->email]);
        if (!$user) {
            return response()->json([
                'errors' => 'email or password not found!',
            ], Response::HTTP_BAD_REQUEST);
        }

        if (!Hash::check($loginRequest->password, $user->password)) {
            return response()->json([
                'errors' => 'email or password not found!',
            ], Response::HTTP_BAD_REQUEST);
        }

        $token = $user->createToken('api', ['logged']);

        Auth::login($user);

        return response()->json([
            'message' => 'login success!',
            'type' => 'success',
            'data' => $user,
            'token' => $token->plainTextToken
        ]);
    }
}
