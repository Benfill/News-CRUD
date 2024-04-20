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
        $data = $request->only('Titre', 'Contenu', 'category_id');

        $validator = Validator::make($data, [
            'Titre' => 'required|string|unique:news',
            'Contenu' => 'required|string|min:12',
            'category_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $news = News::create([
            'Titre' => $request->Titre,
            'slug' => Str::slug($request->Titre),
            'Contenu' => $request->Contenu,
            'category_id' => $request->category_id,
            'Date_debut' => Carbon::now(),
            'Date_expiration' => Carbon::now()->addDays('2'),
        ]);
        return response()->json(['news' => $news, 'success' => true, 'message' => 'news added successfully'], 201);


    }

    function update(Request $request)
    {
        $data = $request->only('id', 'Contenu', 'category_id');
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:news,id',
            'category_id' => 'required|numeric',
            'Contenu' => 'required|string|min:12'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $news = News::find($data['id']);
        $news->Contenu = $data['Contenu'];
        $news->category_id = $data['category_id'];
        $news->save();
        return response()->json(['news' => $news, 'success' => true, 'message' => 'news updated successfully'], 200);
    }

    function show($slug)
    {
        $validator = Validator::make([$slug], [
            'slug' => 'required|string|exists:news,slug'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $news = News::where('slug', $slug)->first();
        return response()->json(['news' => $news, 'success' => true], 200);
    }

    function destroy(Request $request)
    {
        $data = $request->only('id');
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:news,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $news = News::find($data['id']);
        if ($news) {
            $news->delete();
            return response()->json(['success' => true, 'message' => 'news deleted successfully'], 204);
        } else {
            return response()->json(['success' => false])->status(400);
        }
    }
}
