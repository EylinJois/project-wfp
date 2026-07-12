<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    //ADMINISTRATOR
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            $articles = Article::query()
                ->orderByDesc('date')
                ->get();

            $doctors = Doctor::all();
            return view('article.index', compact('articles', 'doctors'));
        } else {
            abort(403, '403 Forbidden Access');
        }
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return response()->json(['message' => 'Form create article belum tersedia.']);
        } else {
            abort(403, '403 Forbidden Access');
        }
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            try {
                $validated = $request->validate([
                    'title' => ['required', 'string', 'max:255'],
                    'date' => ['required', 'date'],
                    'content' => ['required', 'string'],
                    'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png'],
                    'doctor_id' => ['required', 'integer', 'exists:doctors,id'],
                ]);

                unset($validated['photo']);

                $article = Article::create($validated);

                if ($request->hasFile('photo')) {
                    $extension = $request->file('photo')->extension();
                    $filename = 'a' . $article->id . '.' . $extension;

                    $request->file('photo')->storeAs('public/photos', $filename);

                    $article->photo = $filename;
                    $article->save();
                }

                return redirect()
                    ->route('article.index')
                    ->with('success', 'Article created successfully.');

            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                ]);
            }
        } else {
            abort(403, '403 Forbidden Access');
        }
    }



    public function edit(Article $article)
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return response()->json(['data' => $article]);
        } else {
            abort(403, '403 Forbidden Access');
        }
    }

    public function update(Request $request, Article $article)
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            $validated = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'date' => ['required', 'date'],
                'content' => ['required', 'string'],
                'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png'],
                'doctor_id' => ['required', 'integer', 'exists:doctors,id'],
            ]);


            $article->update($validated);

            if ($request->hasFile('photo')) {
                if ($article->photo) {
                    Storage::delete('public/photos/' . $article->photo);
                }

                $extension = $request->file('photo')->extension();
                $filename = 'a' . $article->id . '.' . $extension;

                $request->file('photo')->storeAs('public/photos', $filename);

                $article->photo = $filename;
            }

            $article->save();

            return redirect()
                ->route('article.index')
                ->with('success', 'Article data updated successfully.');
        } else {
            abort(403, '403 Forbidden Access');
        }
    }

    public function destroy(Article $article)
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            if ($article->photo) {
                Storage::delete('public/photos/' . $article->photo);
            }

            $article->delete();

            return redirect()
                ->route('article.index')
                ->with('success', 'Article deleted successfully.');
        } else {
            abort(403, '403 Forbidden Access');
        }
    }

    //MEMBER
    public function memberIndex(Request $request)
    {
        $query = Article::query()->with('doctor')->orderByDesc('date');

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $articles = $query->get();

        return view('article.member_index', compact('articles'));
    }

    public function show(Article $article)
    {
        return view('article.show', compact('article'));
    }
}