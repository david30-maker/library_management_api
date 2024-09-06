<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:santum');
    }

    public function index()
    {
        return Author::all();
    }

    public function show($id)
    {
        return Author::findOrFail($id);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Author::class);

        $validated = $request->validate([
            'name' => 'required|required',
            'bio' => 'nullable|string',
            'birthdate' => 'nullable|date',
        ]);

        return Author::create($validated);
    }

        public function update(Reuest $request, $id)
        {
            $this->authorize('update', Author::class);

            $author = Author::findOrFail($id);

            $this->authorize('update', $author);

            $validated = $request->validate([
                'name' => 'required|required',
                'bio' => 'nullable|string',
                'birthdate' => 'nullable|date',
            ]);

            $author->update($validated);

            return $author;
        }

        public function destroy($id)
        {
            $this->authorize('delete', Author::class);

            $author = Author::findOrFail($id);

            $this->authorize('delete', $author);

            $author->delete();

            return response()->json(['message' => 'Author deleted successfully'], 204);
        }
}
