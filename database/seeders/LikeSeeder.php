<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $articles = Article::all();
        foreach ($articles as $article){
            $randomCount = rand(0, $users->count());
            $likeUsers = $users->random($randomCount);
            $likes = Like::factory($randomCount)->make();
            foreach($likes as $like){
                $like->article_id = $article->id;
                $like->user_id = $likeUsers->pop()->id;
                $like->save();
            }
        }
    }
}
