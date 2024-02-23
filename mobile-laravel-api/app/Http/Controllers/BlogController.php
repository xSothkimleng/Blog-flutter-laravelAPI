<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Http\Requests\BlogRequest;
use App\Http\Resources\BlogResource;

class BlogController extends Controller
{
    public function index()
    {
        return BlogResource::collection(Blog::all());
    }

    public function store(BlogRequest $request)
    {

        $validatedData = $request->validated();
        $validatedData['author_id'] = $request->user()->id;
        $blog = Blog::create($validatedData);
        return new BlogResource($blog);
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json($blog);
    }

    public function update(BlogRequest $request, Blog $blog)
    {
    
        $blog->update($request->validated());
        return new BlogResource($blog);
    }
    
    public function destroy($id)
    {
        Blog::destroy($id);
        return response()->json(['message' => 'Blog post deleted successfully']);
    }
}
