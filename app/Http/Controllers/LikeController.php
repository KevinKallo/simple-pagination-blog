<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Like;
use App\Http\Requests\StoreLikeRequest;
use App\Http\Requests\UpdateLikeRequest;

class LikeController extends Controller
{
   public function like(Article $article){
        if(auth()->user()->likes()->where('article_id', $article->id)->exists()){
           $like = auth()->user()->likes()->where('article_id', $article->id)->first();
           $like->delete();
        } else {
            $like = new Like();
            $like->user()->associate(auth()->user());
            $like->article()->associate($article);
            $like->save();
        }
        return redirect()->back();
   }
}
