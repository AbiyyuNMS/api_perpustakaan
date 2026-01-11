<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        return ApiFormatter::createJson(
            200,
            "List kategori",
            Category::all()
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return ApiFormatter::createJson(
                400,
                "Validasi gagal",
                $validator->errors()->all()
            );
        }

        $category = Category::create([
            'name' => $request->name
        ]);

        return ApiFormatter::createJson(
            201,
            "Kategori berhasil ditambahkan",
            $category
        );
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return ApiFormatter::createJson(
                404,
                "Kategori tidak ditemukan"
            );
        }

        return ApiFormatter::createJson(
            200,
            "Detail kategori",
            $category
        );
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return ApiFormatter::createJson(
                404,
                "Kategori tidak ditemukan"
            );
        }

        $category->update($request->only('name'));

        return ApiFormatter::createJson(
            200,
            "Kategori berhasil diupdate",
            $category
        );
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return ApiFormatter::createJson(
                404,
                "Kategori tidak ditemukan"
            );
        }

        $category->delete();

        return ApiFormatter::createJson(
            200,
            "Kategori berhasil dihapus"
        );
    }
}
