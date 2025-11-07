<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowings = Borrowing::with(['user:id,name', 'book:id,title'])->get();
        return response()->json($borrowings, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $book = Book::find($request->book_id);

        // Check stock availability
        if ($book->stock < $request->quantity) {
            return response()->json(['message' => 'Not enough stock available'], 400);
        }

        // Reduce stock
        $book->decrement('stock', $request->quantity);

        // Create borrowing record
        $borrowing = Borrowing::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'quantity' => $request->quantity,
            'borrowed_at' => now(),
        ]);

        return response()->json([
            'message' => 'Book borrowed successfully',
            'borrowing' => $borrowing
        ], 201);
    }

    /**
     * Return a borrowed book.
     */
    public function returnBook($id)
    {
        $borrowing = Borrowing::find($id);

        if (!$borrowing) {
            return response()->json(['message' => 'Borrowing record not found'], 404);
        }

        // Ensure it's not already returned
        if ($borrowing->returned_at) {
            return response()->json(['message' => 'Book already returned'], 400);
        }

        // Increase stock
        $book = Book::find($borrowing->book_id);
        $book->increment('stock', $borrowing->quantity);

        // Update borrowing record
        $borrowing->update([
            'returned_at' => now(),
        ]);

        return response()->json(['message' => 'Book returned successfully'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $borrowing = Borrowing::with(['user:id,name', 'book:id,title'])->find($id);

        if (!$borrowing) {
            return response()->json(['message' => 'Borrowing record not found'], 404);
        }

        return response()->json($borrowing, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
