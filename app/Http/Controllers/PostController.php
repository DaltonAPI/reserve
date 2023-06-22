<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $posts = Post::with('comments','author','likedBy')->latest()->filter(request(['search']))->paginate(6);
        return view('posts.posts', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createPost(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif',
            'excerpt' => 'required',
            'body' => 'required',
            'price' => 'nullable|numeric',
            'published_at' => 'nullable|date',
        ]);

        // Handle thumbnail image upload if present |max:2048
        if ($request->hasFile('thumbnail')) {
            $validatedData['thumbnail'] = $request->file('thumbnail')->store('thumbnail', 'public');
        }
        $validatedData['user_id'] = auth()->id();
        // Save the data to the database
        $post = Post::create($validatedData);

        // Redirect or perform additional actions as needed
        return redirect('/posts')->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('comments', 'author')->findOrFail($id);

        return view('posts.singlePost', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'excerpt' => 'required',
            'body' => 'required',
            'price' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        $post = Post::findOrFail($id);
        $post->title = $validatedData['title'];
        $post->excerpt = $validatedData['excerpt'];
        $post->body = $validatedData['body'];
        $post->price = $validatedData['price'];

        if ($request->hasFile('thumbnail')) {
            $post->thumbnail = $request->file('thumbnail')->store('thumbnail', 'public');
        }

        $post->save();

        return redirect()->route('posts.show', $post->id)->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        // Optionally, you can redirect to a different page after deleting the post
        return redirect()->route('posts')->with('success', 'Post deleted successfully');
    }
}
