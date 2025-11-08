<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Category::all();
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
        $category = Category::create($request->all()); // Create a new category
        return response()->json($category, 201); // Return category and 201 status code
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id); // Find category
        if(!$category) {
            return response()->json(['message' => 'Category not found'], 404); // Return 404 if category doesn't exist
        }
        return $category; // Return category
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
        $category = Category::find($id); // Find category
        if(!$category) {
            return response()->json(['message' => 'Category not found'], 404); // Return 404 if category doesn't exist
        }
        $category->update($request->all()); // Update category
        return response()->json($category, 200); // Return category and 200 status code
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id); // Find category
        if(!$category) {
            return response()->json(['message' => 'Category not found'], 404); // Return 404 if category doesn't exist
        }
        $category->delete(); // Delete category
        return response()->json(['message' => 'Category deleted'], 200); // Return 200 status code
    }
}
