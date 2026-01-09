<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Helpers\ApiFormatter;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:6'
                ],
                [
                    'name.required' => 'Nama wajib diisi',
                    'email.required' => 'Email wajib diisi',
                    'email.email' => 'Format email tidak valid',
                    'email.unique' => 'Email sudah terdaftar',
                    'password.required' => 'Password wajib diisi',
                    'password.min' => 'Password minimal 6 karakter'
                ]
            );

            if ($validator->fails()) {
                return ApiFormatter::createJson(
                    400,
                    "Validasi gagal",
                    $validator->errors()->all()
                );
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return ApiFormatter::createJson(
                201,
                "Register berhasil",
                $user
            );

        } catch (\Exception $e) {
            return ApiFormatter::createJson(
                500,
                "Register gagal",
                $e->getMessage()
            );
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ],
                [
                    'email.required' => 'Email wajib diisi',
                    'email.email' => 'Format email tidak valid',
                    'password.required' => 'Password wajib diisi'
                ]
            );

            if ($validator->fails()) {
                return ApiFormatter::createJson(
                    400,
                    "Validasi gagal",
                    $validator->errors()->all()
                );
            }

            $credentials = $request->only('email', 'password');

            if (!$token = auth('api')->attempt($credentials)) {
                return ApiFormatter::createJson(
                    401,
                    "Email atau password salah"
                );
            }

            return ApiFormatter::createJson(
                200,
                "Login berhasil",
                [
                    'token' => $token,
                    'type' => 'Bearer'
                ]
            );


        } catch (\Exception $e) {
            return ApiFormatter::createJson(
                500,
                "Login gagal",
                $e->getMessage()
            );
        }
    }

    public function me()
    {
        try {
            return ApiFormatter::createJson(
                200,
                "Data user",
                auth()->user()
            );
        } catch (\Exception $e) {
            return ApiFormatter::createJson(
                401,
                "Token tidak valid atau kadaluarsa",
                $e->getMessage()
            );
        }
    }


    public function logout()
    {
        try {
            auth()->logout();

            return ApiFormatter::createJson(
                200,
                "Logout berhasil"
            );
        } catch (\Exception $e) {
            return ApiFormatter::createJson(
                500,
                "Logout gagal",
                $e->getMessage()
            );
        }
    }
}
