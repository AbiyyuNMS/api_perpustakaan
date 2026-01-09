<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Helpers\ApiFormatter;

class UserController extends Controller
{
    public function index()
    {
        try {
            return ApiFormatter::createJson(
                200,
                "List user",
                User::all()
            );
        } catch (\Exception $e) {
            return ApiFormatter::createJson(
                500,
                "Gagal mengambil data user",
                $e->getMessage()
            );
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name'     => 'required',
                    'email'    => 'required|email|unique:users',
                    'password' => 'required|min:6'
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
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return ApiFormatter::createJson(
                201,
                "User berhasil ditambahkan",
                $user
            );
        } catch (\Exception $e) {
            return ApiFormatter::createJson(
                500,
                "Gagal menambahkan user",
                $e->getMessage()
            );
        }
    }

    public function show($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return ApiFormatter::createJson(
                    404,
                    "User tidak ditemukan"
                );
            }

            return ApiFormatter::createJson(
                200,
                "Detail user",
                $user
            );
        } catch (\Exception $e) {
            return ApiFormatter::createJson(
                500,
                "Gagal mengambil detail user",
                $e->getMessage()
            );
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return ApiFormatter::createJson(
                    404,
                    "User tidak ditemukan"
                );
            }

            $user->update($request->only('name', 'email'));

            return ApiFormatter::createJson(
                200,
                "User berhasil diupdate",
                $user
            );
        } catch (\Exception $e) {
            return ApiFormatter::createJson(
                500,
                "Gagal mengupdate user",
                $e->getMessage()
            );
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return ApiFormatter::createJson(
                    404,
                    "User tidak ditemukan"
                );
            }

            $user->delete();

            return ApiFormatter::createJson(
                200,
                "User berhasil dihapus"
            );
        } catch (\Exception $e) {
            return ApiFormatter::createJson(
                500,
                "Gagal menghapus user",
                $e->getMessage()
            );
        }
    }
}
