<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowRecord;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        return Book::all();
    }

    public function show($id)
    {
        return Book::findOrFail($id);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Book::class);

        $validated = $request->validate([
            'title' => 'required|string',
            'isbn' => 'required|string|unique:books',
            'published_date' => 'nullable|date',
            'author_id' => 'required|exists:authors,id',
            'status' => 'required|in:Available,Borrowed',
        ]);
        return Book::create($validated);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update', $book);
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string',
            'isbn' => 'required|string|unique:books,isbn,'.$id,
            'published_date' => 'nullable|date',
            'author_id' => 'required|exists:authors,id',
            'status' => 'required|in:Available,Borrowed',
        ]);

        $book->update($validated);

        return $book;
    }

    public function destroy($id)
    {
        $this->authorize('delete', Book::class);

        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json(['message' => 'Book deleted successfully'], 204);
    }

    public function borrow(Request $request, $id)
    {
       $user = $request->user();
       if ($user->role !== 'Member') {
        return response()->json(['message' => 'Only members can borrow books'], 403);
       }

         $book = Book::findOrFail($id);
            if ($book->status == 'Borrowed') {
                return response()->json(['message' => 'Book is already borrowed'], 400);
            }

						BorrowRecord::create([
								'user_id' => $user->id,
								'book_id' => $book->id,
								'borrowed_at' => now(),
								'due_at' => now()->addDays(14),
						]);

						$book->status = 'Borrowed';
						$book->save();

						return response()->json(['message' => 'Book borrowed successfully'], 200);
    }

		public function returnBook(Request $request, $id)
		{
			$user = $request->user();
			if ($user->role !== 'Member') {
				return response()->json(['message' => 'Only members can return books'], 403);
			}

			$book = Book::findOrFail($id);
			$borrowRecord = BorrowRecord::where('user_id', $user->id)
				->where('booh_id', $book->id)
				->whereNull('returned_at')
				->first();

				if (!$borrowRecord) {
					return response()->json(['message' => 'Book is not borrowed'], 400);
				}

				$borrowRecord->returned_at = now();
				$borrowRecord->save();

				$book->status = 'Available';
				$book->save();

				return response()->json(['message' => 'Book returned successfully'], 200);
		}
}
