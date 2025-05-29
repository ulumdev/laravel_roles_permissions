<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ArticleController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view articles', only: ['index']),
            new Middleware('permission:create articles', only: ['create', 'store']),
            new Middleware('permission:edit articles', only: ['edit', 'update']),
            new Middleware('permission:delete articles', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::latest()->paginate(10)->withQueryString();
        return view('articles.index', [
            'articles' => $articles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:5',
            'content' => 'required|string',
            'author' => 'nullable|string|min:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->passes()) {
            Article::create($request->all());
            return redirect()->route('articles.index')->with('success', 'Article created successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.edit', [
            'article' => $article,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:5',
            'content' => 'required|string',
            'author' => 'nullable|string|min:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->passes()) {
            $article = Article::findOrFail($id);
            $article->update($request->all());
            return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;

        $article = Article::findOrFail($id);

        if ($article == null) {
            session()->flash('error', 'Article not found!');
            return response()->json([
                'status' => false,
            ]);
        }

        $article->delete();
        session()->flash('success', 'Article deleted successfully!');
        return response()->json([
            'status' => true,
        ]);
    }
}
