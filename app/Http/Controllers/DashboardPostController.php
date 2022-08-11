<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Cviebrock\EloquentSluggable\Services\SlugService;

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.posts.index', [
            "posts" => Post::Where("user_id", Auth()->user()->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            
        return view('dashboard.posts.create', [
            "categories" => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
        // $request->file('image')->store('post-images'); --> just for testing
        // $validatedData = $request->validate([
        //     'title' => 'required|max:255',
        //     'slug' => 'required|unique:posts',
        //     'category_id' => 'required',
        //     'image' => 'image|file|max:1024',
        //     'body' => 'required'
        // ]);
        $validator = Validator::make($request->all(),[
            'title' => 'required|max:255',
            'slug' => 'required|unique:posts',
            'category_id' => 'required',
            'body' => 'required',
            'image' => 'mimes:jpeg,jpg,png,bmp,tiff|file|max:1024',
        ]);
        
        // If there's error
        if(count($validator->errors()->toArray()) > 0) {
            $error_message = $validator->errors()->toArray();
            $error = ValidationException::withMessages($error_message);
            throw $error;
        }
        
        if ($request->file('image')) {
            $img = $request->file('image')->store('post-images');
            $request->request->add(['image_path' => $img]);
        }

        // Add field user_id & excerpt to request
        $request->request->add([
            'user_id' => auth()->user()->id,
            'excerpt' => Str::limit(strip_tags($request->body, 200))
        ]);
        // $request->user_id = auth()->user()->id;
        // $request->excerpt = Str::limit(strip_tags($request->body, 200));

        Post::create([
            "title" => $request->title,
            "slug" => $request->slug,
            "category_id" => $request->category_id,
            "body" => $request->body,
            "image" => $request->image_path,
            "user_id" => $request->user_id,
            "excerpt" => $request->excerpt
        ]);

        return redirect('/dashboard/posts')->with('success', 'New post has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('dashboard.posts.show', [
            "post" => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', [
            "post" => $post,
            "categories" => Category::All()

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'image' => 'mimes:jpeg,jpg,png,bmp,tiff|file|max:1024',
            'slug' => '',
            'body' => 'required'
        ];

        if ($request->slug != $post->slug) {
           $rules['slug'] = 'required|unique:posts';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }

            $img = $request->file('image')->store('post-images');
            $request->request->add(['image_path' => $img]);
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body, 200));

        Post::where('id', $post->id)
                ->update([
                    "title" => $validatedData['title'],
                    // ($request->slug != $post->slug) ? "slug" => $validatedData['slug'],
                    "slug" => $validatedData['slug'],
                    "category_id" => $validatedData['category_id'],
                    "body" => $validatedData['body'],
                    "image" => $request->image_path,
                    "user_id" => $validatedData['user_id'],
                    "excerpt" => $validatedData['excerpt']
                ]);

        return redirect('/dashboard/posts')->with('success', 'post has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::delete($post->image);
        }
        
        Post::destroy($post->id);

        return redirect('/dashboard/posts')->with('success', 'post has been deleted!');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }
}
