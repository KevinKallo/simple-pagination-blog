<?php


use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PublicController::class, 'index']);
Route::get('/about', [PublicController::class, 'about']);
Route::get('/article/{article}', [PublicController::class, 'article'])->name('public.article');
Route::get('/tag/{tag}', [PublicController::class, 'tag'])->name('public.tag');

Route::get('/admin/articles/deleted', [ArticleController::class, 'deleted'])->name('articles.deleted');

//Route::get('/admin/articles', [ArticleController::class, 'index'])->name('articles.index');
//Route::get('/admin/articles/create', [ArticleController::class, 'create'])->name('articles.create');
//Route::post('/admin/articles', [ArticleController::class, 'store'])->name('articles.store');
//Route::get('/admin/articles/{article}', [ArticleController::class, 'edit'])->name('articles.edit');
//Route::put('/admin/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
//Route::delete('/admin/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::resource('/admin/articles', ArticleController::class);
    Route::post('/article/{article}', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/article/{article}/like', [LikeController::class, 'like'])->name('like');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
