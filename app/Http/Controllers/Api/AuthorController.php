<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;


class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Author::all();
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
        $author = Author::create($request->all()); // Create a new author
        return response()->json($author, 201); // Return the book and 201 status code
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $author = Author::find($id); // Find author
        if(!$author) {
            return response()->json(['message' => 'Author not found'], 404); // Return 404 if author doesn't exist
        }
        return $author; // Return author
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
        $author = Author::find($id); // Find author
        if(!$author) {
            return response()->json(['message' => 'Author not found'], 404); // Return 404 if author doesn't exist
        }
        $author->update($request->all()); // Update author
        return response()->json($author, 200); // Return the book and 200 status code
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $author = Author::find($id); // Find author
        if(!$author) {
            return response()->json(['message' => 'Author not found'], 404); // Return 404 if author doesn't exist
        }
        $author->delete(); // Delete author
        return response()->json(['message' => 'Author deleted'], 200); // Return 200 status code
    }
}
