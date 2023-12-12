<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Image;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$articles = User::find(3)->articles()->latest()->paginate();
        $articles = auth()->user()->articles()->latest()->paginate();
        return view('articles.index', compact('articles'));
    }

    /**
     * Display a listing of the deleted resource.
     */
    public function deleted()
    {
        $articles = Article::onlyTrashed()->orderBy('deleted_at')->paginate();
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        return view('articles.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $article = new Article($request->validated());
        $article->user()->associate(auth()->user());
        $article->save();

        if($request->file('images')){
            foreach($request->file('images') as $image){
                $file = $image->store('/public');
                $img = new Image();
                $img->path = Storage::url($file);
                $img->article()->associate($article);
                $img->save();
            }
        }

        if($request->input('tags')){
            foreach($request->input('tags') as $tagId){
                $article->tags()->attach($tagId);
            }
        }
        return redirect()->route('articles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
//        $article->title = $request->validated('title');
//        $article->body = $request->validated('body');
        $article->fill($request->validated());
        $article->save();
        return redirect()->route('articles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index');
    }
}
