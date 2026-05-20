<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function dbIndex()
    {
        $articles = Article::query()
            ->orderByDesc('date')
            ->get();

        return view('article', compact('articles'));
    }
    public function index()
    {
        $articles = Article::query()
            ->orderByDesc('date')
            ->get();

        return view('article.index', compact('articles'));
    }

    public function create()
    {
        return response()->json(['message' => 'Form create article belum tersedia.']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'doctor_id' => ['required', 'integer', 'exists:doctors,id'],
        ]);

        Article::create($validated);

        return redirect()->route('article.index');
    }

    public function show(Article $articles)
    {
        return view('article.show', compact('articles'));
    }

    public function edit(Article $article)
    {
        return response()->json(['data' => $article]);
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'doctor_id' => ['required', 'integer', 'exists:doctors,id'],
        ]);

        $article->update($validated);

        return redirect()->route('article.index');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('article.index');
    }
}