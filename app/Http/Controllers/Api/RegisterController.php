<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register(RegisterRequest $request)
    {
        try {
            if ($request->validator->fails()) {
                return response([
                    'error' => $request->validator->errors(),
                ], 400);
            }

            $this->userRepo->createUser([
                'fullname' => $request->input('fullname'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'role_id' => config('user.role_id'),
                'password' => bcrypt($request->input('password')),
            ]);

            return response()->json([
                'message' => __('Register success'),
            ], 200);
        } catch (\Exception $error) {
            return response()->json([
                'message' => __('Register Fail'),
                'error' => $error,
            ], 500);
        }
    }
}
