<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $posts =  Post::create($fields);

        return response()->json(['post' => $posts],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return  $post;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {

        $fields = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $posts =  $post->update($fields);

        return response()->json(['post' => $post],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => "The post was deleted"],200);
    }
}
