<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminArticleController extends Controller
{
    /**
     * Display a listing of articles.
     */
    public function index(Request $request): View
    {
        $query = Article::query();

        // Status tab filter
        $tab = $request->query('tab', 'all');
        if ($tab === 'published') {
            $query->where('status', 'published');
        } elseif ($tab === 'draft') {
            $query->where('status', 'draft');
        } elseif ($tab === 'archived') {
            $query->where('status', 'archived');
        }

        // Search
        if ($request->filled('search')) {
            $search = trim($request->query('search'));
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author_name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $articles = $query->orderByDesc('id')->paginate(10)->withQueryString();

        $totalArticles  = Article::count();
        $publishedCount = Article::where('status', 'published')->count();
        $draftCount     = Article::where('status', 'draft')->count();
        $totalViews     = Article::sum('views');

        return view('admin.articles.index', [
            'articles'       => $articles,
            'currentTab'     => $tab,
            'totalArticles'  => number_format($totalArticles),
            'publishedCount' => number_format($publishedCount),
            'draftCount'     => number_format($draftCount),
            'totalViews'     => $totalViews >= 1000
                ? number_format($totalViews / 1000, 1).'K'
                : number_format($totalViews),
            'search'         => $request->query('search', ''),
        ]);
    }

    /**
     * Show form for creating a new article.
     */
    public function create(): View
    {
        return view('admin.articles.create');
    }

    /**
     * Store a new article in the database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255', 'unique:articles,slug'],
            'excerpt'          => ['nullable', 'string', 'max:500'],
            'content'          => ['nullable', 'string'],
            'category'         => ['required', 'string', 'max:100'],
            'tags'             => ['nullable', 'string'],
            'author_name'      => ['nullable', 'string', 'max:255'],
            'author_role'      => ['nullable', 'string', 'max:255'],
            'author_avatar'    => ['nullable', 'url', 'max:500'],
            'image'            => ['nullable', 'url', 'max:500'],
            'image_file'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'status'           => ['required', 'in:published,draft,archived'],
            'read_time'        => ['nullable', 'string', 'max:50'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]);

        $tagsArray = ! empty($validated['tags'])
            ? array_map('trim', explode(',', $validated['tags']))
            : null;

        // Determine image URL: either uploaded file or provided URL
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('public/articles');
            $imageUrl = Storage::url($path);
        } else {
            $imageUrl = $validated['image'] ?? null;
        }

        $article = Article::create([
            'title'         => $validated['title'],
            'slug'          => $validated['slug'] ?? null,
            'excerpt'       => $validated['excerpt'] ?? null,
            'content'       => $validated['content'] ?? null,
            'category'      => $validated['category'],
            'tags'          => $tagsArray,
            'author_name'   => $validated['author_name'] ?? 'Admin IndoTech',
            'author_role'   => $validated['author_role'] ?? null,
            'author_avatar' => $validated['author_avatar'] ?? null,
            'image'         => $imageUrl,
            'status'        => $validated['status'],
            'read_time'     => $validated['read_time'] ?? null,
        ]);
        
        return redirect()->route('admin.articles.index')
            ->with('success', "Artikel \"{$article->title}\" berhasil disimpan ke database!");
    }

    /**
     * Show form for editing an article.
     */
    public function edit(int $id): View
    {
        $article = Article::findOrFail($id);

        return view('admin.articles.edit', compact('article'));
    }

    /**
     * Update an article in the database.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255', "unique:articles,slug,{$id}"],
            'excerpt'          => ['nullable', 'string', 'max:500'],
            'content'          => ['nullable', 'string'],
            'category'         => ['required', 'string', 'max:100'],
            'tags'             => ['nullable', 'string'],
            'author_name'      => ['nullable', 'string', 'max:255'],
            'author_role'      => ['nullable', 'string', 'max:255'],
            'author_avatar'    => ['nullable', 'url', 'max:500'],
            'image'            => ['nullable', 'url', 'max:500'],
            'image_file'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'status'           => ['required', 'in:published,draft,archived'],
            'read_time'        => ['nullable', 'string', 'max:50'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]);

        $tagsArray = ! empty($validated['tags'])
            ? array_map('trim', explode(',', $validated['tags']))
            : null;

        // Determine image URL: uploaded file overrides URL if present
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('public/articles');
            $imageUrl = Storage::url($path);
        } else {
            $imageUrl = $validated['image'] ?? $article->image;
        }

        $article->update([
            'title'         => $validated['title'],
            'slug'          => ! empty($validated['slug']) ? $validated['slug'] : $article->slug,
            'excerpt'       => $validated['excerpt'] ?? null,
            'content'       => $validated['content'] ?? null,
            'category'      => $validated['category'],
            'tags'          => $tagsArray,
            'author_name'   => $validated['author_name'] ?? $article->author_name,
            'author_role'   => $validated['author_role'] ?? null,
            'author_avatar' => $validated['author_avatar'] ?? null,
            'image'         => $imageUrl,
            'status'        => $validated['status'],
            'read_time'     => $validated['read_time'] ?? null,
        ]);
        
        return redirect()->route('admin.articles.index')
            ->with('success', "Artikel \"{$article->title}\" berhasil diperbarui di database.");
    }

    /**
     * Delete an article from the database.
     */
    public function destroy(int $id): RedirectResponse
    {
        $article = Article::findOrFail($id);
        $title   = $article->title;
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', "Artikel \"{$title}\" berhasil dihapus dari database.");
    }
}
