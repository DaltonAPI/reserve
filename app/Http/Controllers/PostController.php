<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        $filteredUsers = User::filter(['search' => $searchTerm])->paginate(30);
        $posts = Post::with('comments','author','likedBy')->latest()->filter(request(['search']))->paginate(30);
        return view('posts.posts', compact('posts','filteredUsers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        // Retrieve the filtered users for the sidebar
        $searchTerm = $request->input('search');
        $filteredUsers = User::filter(['search' => $searchTerm])->paginate(10);

        return view('posts.create', compact( 'filteredUsers', ));
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
            'image_url' => 'mimes:jpeg,png,gif,mp4,avi,mov|max:73728960',
            'body' => 'required',
            'price' => 'nullable|numeric',
            'published_at' => 'nullable|date',
            'url' => 'nullable|url',
            'filename' => ['nullable', 'regex:/^[A-Za-z0-9_-]+$/'],
            'image_extension' => ['nullable', 'mimes:jpeg,png,gif,mp4,avi,mov'],
        ]);

        // Handle thumbnail image upload if present
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');

            // Validate the file size
            $maxSize = 73728960; // 40 megabytes
            $fileSize = $file->getSize();

            if ($fileSize > $maxSize) {
                return redirect()->back()->withErrors(['thumbnail' => 'The  file size must be between 1 to 45 megabytes.']);
            }

            $validatedData['image_url'] = $file->store('thumbnail', 's3');
            $image = $file->store('thumbnail', 's3');
            Storage::disk('s3')->setVisibility($image, 'public');
            $validatedData['image_extension'] = $file->getClientOriginalExtension();
            $validatedData['filename'] = basename($image);
            $validatedData['url'] = Storage::disk('s3')->url($image);
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
    public function show($id, Request $request)
    {
        $post = Post::with('comments', 'author')->findOrFail($id);
        $searchTerm = $request->input('search');
        $filteredUsers = User::filter(['search' => $searchTerm])->paginate(10);
        return view('posts.singlePost', compact('post','filteredUsers'));
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

    public function destroy($postId)
    {
        $post = Post::findOrFail($postId);

        // Delete the post record from the database
        $post->delete();
        return redirect('/posts')->with('success', 'Post deleted successfully');
//        // Set the AWS credentials
//        $credentials = [
//            'key' => 'AKIARJ7DSW2PXG6WQTF6',
//            'secret' => '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',
//        ];
//
//        // Create an S3 client
//        $s3 = new S3Client([
//            'version' => 'latest',
//            'credentials' => $credentials,
//            'region' => 'us-east-2',
//            'use_path_style_endpoint' => false,
//        ]);
//
//        // Specify the bucket and file key
//        $bucket = 'reservifybucket';
//        $key = $bucket . '/' . $post->filename;
//
//        try {
//            // Delete the file from the bucket
//            $s3->deleteObject([
//                'Bucket' => $bucket,
//                'Key' => $key,
//            ]);
//
//            return redirect()->back()->with('success', 'Post and file deleted successfully.');
//        } catch (AwsException $e) {
//            // Log the error or handle it accordingly
//            return redirect()->back()->with('error', 'An error occurred while deleting the post and file.');
//        }
    }
}
