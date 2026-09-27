<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Support\CmsSeoRules;
use App\Support\CmsUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CmsPostController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'published' => ['nullable', 'string', Rule::in(['', '1', '0'])],
        ]);

        $query = Post::query()->latest('published_at');

        if (! empty($filters['q'])) {
            $term = $filters['q'];
            $query->where(function ($builder) use ($term) {
                $builder->where('title', 'like', '%'.$term.'%')
                    ->orWhere('excerpt', 'like', '%'.$term.'%')
                    ->orWhere('slug', 'like', '%'.$term.'%');
            });
        }

        if (($filters['published'] ?? '') === '1') {
            $query->published();
        } elseif (($filters['published'] ?? '') === '0') {
            $query->where(function ($builder) {
                $builder->whereNull('published_at')
                    ->orWhere('published_at', '>', now());
            });
        }

        return view('cms-admin.posts.index', [
            'page' => 'admin',
            'title' => 'Actualités',
            'posts' => $query->paginate(20)->withQueryString(),
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('cms-admin.posts.edit', [
            'page' => 'admin',
            'title' => 'Nouvelle actualité',
            'post' => new Post(['published_at' => now()]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $post = $this->savePost(new Post, $request);

        return redirect()->route('admin.cms.posts.edit', $post)->with('status', 'Actualité créée.');
    }

    public function edit(Post $post): View
    {
        return view('cms-admin.posts.edit', [
            'page' => 'admin',
            'title' => $post->title ?: 'Actualité',
            'post' => $post,
        ]);
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $this->savePost($post, $request);

        return back()->with('status', 'Actualité enregistrée.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('admin.cms.posts.index')->with('status', 'Actualité supprimée.');
    }

    private function savePost(Post $post, Request $request): Post
    {
        $data = $request->validate(array_merge([
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:200'],
            'category' => ['nullable', 'string', 'max:80'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'image_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:8192'],
            'published_at' => ['nullable', 'date'],
            'is_featured' => ['sometimes', 'boolean'],
        ], CmsSeoRules::rules()));

        $slug = $data['slug'] ?: Str::slug($data['title']);
        $post->fill([
            'title' => $data['title'],
            'slug' => $slug,
            'category' => $data['category'] ?? 'Actualités',
            'excerpt' => $data['excerpt'],
            'body' => $data['body'],
            'image_url' => CmsUploads::resolvePath(
                $request,
                'image_url',
                'image_file',
                $post->exists ? ($post->getAttributes()['image_url'] ?? null) : null,
            ),
            'published_at' => $data['published_at'] ?? now(),
            'is_featured' => $request->boolean('is_featured'),
            ...CmsSeoRules::onlyMeta($data),
        ]);
        $post->save();

        return $post;
    }
}
