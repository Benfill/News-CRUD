<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function searchForArticlesByCategory($categoryName)
    {
        $category = Category::where('name', $categoryName)->first();

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $news = $this->getArticlesRecursive($category);

        $news = $news->reject(function ($article) {
            return $article->type === 'news' && Carbon::now()->gt($article->expiration_date);
        });

        return response()->json($news);
    }

    protected function getArticlesRecursive($category)
    {
        $news = $category->news;

        foreach ($category->children as $childCategory) {
            $news = $news->merge($this->getArticlesRecursive($childCategory));
        }

        return $news;
    }
}
