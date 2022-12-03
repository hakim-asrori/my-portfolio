<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Interfaces\UserInterface;
use Illuminate\Http\Request;

class CheckController extends Controller
{
    protected $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke()
    {
        $user = auth()->user();

        return response()->json([
            'data' => $user
        ]);
    }
}
