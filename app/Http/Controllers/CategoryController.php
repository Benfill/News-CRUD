<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
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

        $news = $news->map(function ($article) {
            $article->category = [
                'id' => $article->category_id,
                'name' => $article->category->name,
            ];

            if (isset($article->category->parent)) {
                $article->category['parent'] = [
                    'id' => $article->category->parent->id,
                    'name' => $article->category->parent->name,
                ];
            }

            return $article;
        });

        return response()->json($news);
    }

    protected function getArticlesRecursive($category)
    {
        $news = $category->news()->with('category', 'category.parent')->get();

        foreach ($category->children as $childCategory) {
            $news = $news->merge($this->getArticlesRecursive($childCategory));
        }

        return $news;
    }

}
