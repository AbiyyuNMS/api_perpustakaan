<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Helpers\ApiFormatter;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index()
    {
        return ApiFormatter::createJson(
            200,
            "List buku",
            Book::with('category')->get()
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'author' => 'required',
            'year' => 'required|numeric',
            'category_id' => 'required|exists:categories,id'
        ]);

        if ($validator->fails()) {
            return ApiFormatter::createJson(
                400,
                "Validasi gagal",
                $validator->errors()->all()
            );
        }

        $book = Book::create($request->all());

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Tambah buku',
            'endpoint' => request()->path()
        ]);
        return ApiFormatter::createJson(
            201,
            "Buku berhasil ditambahkan",
            $book
        );
    }

    public function show($id)
    {
        $book = Book::with('category')->find($id);

        if (!$book) {
            return ApiFormatter::createJson(
                404,
                "Buku tidak ditemukan"
            );
        }

        return ApiFormatter::createJson(
            200,
            "Detail buku",
            $book
        );
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return ApiFormatter::createJson(
                404,
                "Buku tidak ditemukan"
            );
        }

        $book->update($request->all());

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Update buku',
            'endpoint' => request()->path()
        ]);

        return ApiFormatter::createJson(
            200,
            "Buku berhasil diupdate",
            $book
        );
    }

    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return ApiFormatter::createJson(
                404,
                "Buku tidak ditemukan"
            );
        }

        $book->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Delete buku',
            'endpoint' => request()->path()
        ]);

        return ApiFormatter::createJson(
            200,
            "Buku berhasil dihapus"
        );
    }
}
