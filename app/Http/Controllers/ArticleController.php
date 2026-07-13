<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    // public function index()
    // {
    //     $user = auth()->user();

    //     if ($user->role === 'admin') {
    //         $articles = Article::query()
    //             ->orderByDesc('date')
    //             ->get();

    //         $doctors = Doctor::all();
    //         return view('article.index', compact('articles', 'doctors'));
    //     } else {
    //         abort(403, '403 Forbidden Access');
    //     }
    // }

    public function index()
    {
        $articles = Article::latest()->get();
        $doctors = Doctor::orderBy('fullname')->get();

        return view('article', compact('articles', 'doctors'));
    }

    public function storeAjax(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'date'      => 'required|date',
            'content'   => 'required|string',
            'photo'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        $filename = null;

        if ($request->hasFile('photo')) {
            $filename = Str::uuid() . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->storeAs('photos', $filename, 'public');
        }

        $article = Article::create([
            'title'     => $request->title,
            'date'      => $request->date,
            'content'   => $request->content,
            'photo'     => $filename,
            'doctor_id' => $request->doctor_id,
        ]);

        $article->load('doctor');

        return response()->json([
            'status' => 'oke',
            'article' => [
                'id'          => $article->id,
                'title'       => $article->title,
                'date'        => $article->date,
                'content'     => $article->content,
                'photo_url'   => $article->photo ? asset('storage/photos/' . $article->photo) : null,
                'doctor_id'   => $article->doctor_id,
                'doctor_name' => $article->doctor->fullname ?? '-',
                'created_at'  => $article->created_at->toDateTimeString(),
                'updated_at'  => $article->updated_at->toDateTimeString(),
            ]
        ]);
    }

    public function getEditForm(Request $request)
    {
        $article = Article::findOrFail($request->id);

        return response()->json([
            'id'        => $article->id,
            'title'     => $article->title,
            'date'      => $article->date,
            'content'   => $article->content,
            'doctor_id' => $article->doctor_id,
            'photo_url' => $article->photo ? asset('storage/photos/' . $article->photo) : null,
        ]);
    }

    public function saveDataUpdate(Request $request)
    {
        $request->validate([
            'id'        => 'required|exists:articles,id',
            'title'     => 'required|string|max:255',
            'date'      => 'required|date',
            'content'   => 'required|string',
            'photo'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        $article = Article::find($request->id);

        if ($article) {
            $article->title = $request->title;
            $article->date = $request->date;
            $article->content = $request->content;
            $article->doctor_id = $request->doctor_id;

            if ($request->hasFile('photo')) {
                if ($article->photo && Storage::disk('public')->exists('photos/' . $article->photo)) {
                    Storage::disk('public')->delete('photos/' . $article->photo);
                }

                $filename = Str::uuid() . '.' . $request->file('photo')->getClientOriginalExtension();
                $request->file('photo')->storeAs('photos', $filename, 'public');
                $article->photo = $filename;
            }

            $article->save();
            $article->load('doctor');

            return response()->json([
                'status'      => 'oke',
                'title'       => $article->title,
                'date'        => $article->date,
                'content'     => $article->content,
                'doctor_id'   => $article->doctor_id,
                'doctor_name' => $article->doctor->fullname ?? '-',
                'photo_url'   => $article->photo ? asset('storage/photos/' . $article->photo) : null,
                'updated_at'  => $article->updated_at->toDateTimeString()
            ]);
        }

        return response()->json([
            'status' => 'gagal',
            'msg' => 'Artikel tidak ditemukan.'
        ]);
    }

    public function deleteData(Request $request)
    {
        $article = Article::find($request->id);

        if ($article) {
            if ($article->photo && Storage::disk('public')->exists('photos/' . $article->photo)) {
                Storage::disk('public')->delete('photos/' . $article->photo);
            }

            $article->delete();

            return response()->json(['status' => 'oke']);
        }

        return response()->json([
            'status' => 'gagal',
            'msg' => 'Artikel tidak ditemukan.'
        ]);
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
        $doctors = Doctor::all();

        return view('members.article', compact('articles', 'doctors'));
    }

    public function show(Article $article)
    {
        return view('article.show', compact('article'));
    }
}