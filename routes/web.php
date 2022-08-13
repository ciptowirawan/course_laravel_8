<?php


// use App\Models\Post;
// use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\DashboardPostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () 
{
    return view('home', [
        "title" => "Home",
        "active" => "home"
    ]);
});

Route::get('/about', function () {
    return view('about', [
        "title" => "About",
        "active" => "about",
        "name" => "Cipto Wirawan",
        "email" => "ciptowirawan.CW@gmail.com",
        "image" => "My Sample.jpeg"
    ]);
});


Route::get('/blog', [PostController::class, 'index']);

Route::prefix('posts')->group(function() {
    Route::get('/', [PostController::class, 'index']);
    Route::get('{post:slug}/{search?}', [PostController::class, 'show']);
    // Route::get('?author={authors:username}', [PostController::class, 'index']);
});

Route::prefix('/categories')->group(function() {
    Route::get('/', function () {
        return view('categories', [
            'title' => 'Post Categories',
            'active' => 'categories',
            'categories' => Category::all()
        ]);
    });
});

Route::prefix('/login')->group(function() {
    Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
    Route::post('/', [LoginController::class, 'authenticate']);
});

Route::prefix('/register')->group(function() {
    Route::get('/', [RegisterController::class, 'index'])->middleware('guest');
    Route::post('/', [RegisterController::class, 'store']);
});

Route::prefix('/dashboard')->group(function() {
    Route::get('/', function() {
        return view('dashboard.index');
    })->middleware('auth');
    Route::get('/posts/checkSlug', [DashboardPostController::class, 'CheckSlug'])->middleware('auth');
    Route::resource('/posts', DashboardPostController::class)->middleware('auth');
    Route::resource('/categories', AdminCategoryController::class)->except('show')->middleware('admin');
});

Route::prefix('/logout')->group(function() {
    Route::post('/', [LoginController::class, 'logout']);
});

// Route::get('{category:slug}', function(Category $category) {
//     return view('posts', [
//         'title' => "Post By Category : $category->name",
//         'active' => 'categories',
//         'posts' => $category->posts->load('author', 'category')
//     ]);
// });

// Route::get('/authors/{author:username}', function(User $author) {
//     return view('posts', [
//         'title' => "Post by Author : $author->name",
//         'active' => 'posts',
//         'posts' => $author->posts->load('category', 'author')
//     ]);
// });