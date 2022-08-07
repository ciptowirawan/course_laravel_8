<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Validation\ValidationException;
use Validator;

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
            'image' => 'required|mimes:jpeg,jpg,png,bmp,tiff|max:1024',
        ]);
        
        // If there's error
        if(count($validator->errors()->toArray()) > 0) {
            $error_message = $validator->errors()->toArray();
            $error = ValidationException::withMessages($error_message);
            throw $error;
        }

        if ($request->file('image')) {
            $request->image = $request->file('image')->store('post-images');
        }

        // Add field user_id & excerpt to request
        $request->request->add([
            'user_id' => auth()->user()->id,
            'excerpt' => Str::limit(strip_tags($request->body, 200))
        ]);
        // $request->user_id = auth()->user()->id;
        // $request->excerpt = Str::limit(strip_tags($request->body, 200));

        Post::create($request->all());

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
            'body' => 'required'
        ];

        if ($request->slug != $post->slug) {
           $rules['slug'] = 'required|unique:posts';
        }

        $validatedData = $request->validate($rules);

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body, 200));

        Post::where('id', $post->id)
                ->update($validatedData);

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
        Post::destroy($post->id);

        return redirect('/dashboard/posts')->with('success', 'post has been deleted!');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }
}
