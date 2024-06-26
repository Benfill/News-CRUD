<?php

namespace App\Http\Controllers;

use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    function index()
    {
        $news = News::where('Date_expiration', '>', now())
            ->orderBy('Date_debut', 'desc')
            ->with('category.parent')
            ->get();
        if ($news->count() > 0) {
            return response()->json(['news' => $news, 'success' => true], 200);
        } else if ($news->count() === 0) {
            return response()->json(['news' => 'list is empty', 'success' => true], 200);
        } else {
            return response()->json(['success' => false])->status(400);
        }

    }

    function store(Request $request)
    {
        $data = $request->only('Titre', 'Contenu', 'category_id', 'Date_expiration');

        $validator = Validator::make($data, [
            'Titre' => 'required|string|unique:news',
            'Contenu' => 'required|string|min:12',
            'category_id' => 'required|numeric',
            'Date_expiration' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $news = News::create([
            'Titre' => $request->Titre,
            'slug' => substr(Str::slug($request->Titre), 0, 50),
            'Contenu' => $request->Contenu,
            'category_id' => $request->category_id,
            'Date_debut' => Carbon::now(),
            'Date_expiration' => Carbon::now()->addDays($request->Date_expiration),
        ]);
        return response()->json(['news' => $news, 'success' => true, 'message' => 'news added successfully'], 201);


    }

    function update(Request $request, $id)
    {
        $data = $request->only('Contenu', 'category_id', 'Date_expiration');
        $validator = Validator::make($data, [
            'category_id' => 'required|numeric',
            'Date_expiration' => 'required|numeric',
            'Contenu' => 'required|string|min:12'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $news = News::find($id);
        $news->Contenu = $data['Contenu'];
        $news->category_id = $data['category_id'];
        $news->Date_expiration = $data['Date_expiration'];
        $news->save();
        return response()->json(['news' => $news, 'success' => true, 'message' => 'news updated successfully'], 200);
    }

    function show($slug)
    {
        $news = News::where('slug', $slug)->first();
        if (!$news) {
            return response()->json(['errors' => 'Article doesnt exists'], 422);
        }
        return response()->json(['news' => $news, 'success' => true], 200);
    }

    function destroy($id)
    {
        $news = News::find($id);
        if ($news) {
            $news->delete();
            return response()->json(['success' => true, 'message' => 'news deleted successfully'], 204);
        } else {
            return response()->json(['success' => false])->status(400);
        }
    }
}
