<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = Tag::factory(20)->create();
        $articles = Article::all();
        foreach ($articles as $article){
            $randCount = rand(0, 5);
            $randTags = $tags->random($randCount);
            foreach ($randTags as $tag){
                $article->tags()->attach($tag);
            }
        }
    }
}
