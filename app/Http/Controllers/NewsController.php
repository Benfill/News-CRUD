<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    function index()
    {
        $news = News::where('Date_expiration', '>', now())
            ->orderBy('Date_debut', 'desc')
            ->get();
        if ($news->count() > 0) {
            return response()->json(['news' => $news, 'success' => true])->status(200);
        } else {
            return response()->json(['success' => false])->status(400);
        }

    }

    function store(Request $request)
    {

    }

    function update($id)
    {

    }

    function show($slug)
    {

    }

    function destroy(Request $request)
    {

    }
}
