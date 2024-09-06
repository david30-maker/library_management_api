<?php

namespace App\Http\Controllers;

use App\Models\BorroRecord;
use Illuminate\Http\Request;

class BorroRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:santum');
    }

    public function index(Request $request)
    {
        if (!in_array($request->user()->role, ['Admin', 'Librarian'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return BorroRecord::all();
    }

    public function show(Request $request, $id)
    {
       if (!in_array($request->user()->role, ['Admin', 'Librarian'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return BorroRecord::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'borrowed_at' => 'required|date',
            'returned_at' => 'nullable|date',
        ]);

        return BorroRecord::create($validated);
    }

    public function update(Request $request, $id)
    {
        $borroRecord = BorroRecord::findOrFail($id);

        $validated = $request->validate([
            'book_id' => 'sometimes|required|exists:books,id',
            'user_id' => 'sometimes|required|exists:users,id',
            'borrowed_at' => 'sometimes|required|date',
            'returned_at' => 'sometimes|nullable|date',
        ]);

        $borroRecord->update($validated);

        return $borroRecord;
    }

    public function destroy(Request $request, $id)
    {
        $borroRecord = BorroRecord::findOrFail($id);

        $borroRecord->delete();

        return response()->json(['message' => 'BorroRecord deleted']);
    }
}
