<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Helpers\ApiFormatter;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    public function index()
    {
        return ApiFormatter::createJson(
            200,
            "List peminjaman",
            Loan::with(['user', 'book'])->get()
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id'
        ]);

        if ($validator->fails()) {
            return ApiFormatter::createJson(
                400,
                "Validasi gagal",
                $validator->errors()->all()
            );
        }

        $loan = Loan::create([
            'user_id' => auth()->id(),
            'book_id' => $request->book_id,
            'loan_date' => now(),
            'status' => 'dipinjam'
        ]);
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Pinjam buku',
            'endpoint' => request()->path()
        ]);

        return ApiFormatter::createJson(
            201,
            "Buku berhasil dipinjam",
            $loan
        );
    }

    public function update($id)
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return ApiFormatter::createJson(
                404,
                "Data peminjaman tidak ditemukan"
            );
        }

        $loan->update([
            'status' => 'dikembalikan',
            'return_date' => now()
        ]);
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Update Peminjaman',
            'endpoint' => request()->path()
        ]);

        return ApiFormatter::createJson(
            200,
            "Buku berhasil dikembalikan",
            $loan
        );
    }
}