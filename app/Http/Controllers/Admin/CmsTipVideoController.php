<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipVideo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CmsTipVideoController extends Controller
{
    public function index(Request $request): View
    {
        $categories = config('kiel.tip_video_categories', []);
        $filters = $request->validate([
            'cat' => ['nullable', 'string', Rule::in(array_keys($categories))],
            'q' => ['nullable', 'string', 'max:120'],
            'published' => ['nullable', 'string', Rule::in(['', '1', '0'])],
        ]);

        $query = TipVideo::query()->orderBy('sort_order')->orderByDesc('published_at');

        if (! empty($filters['cat'])) {
            $query->where('category', $filters['cat']);
        }

        if (! empty($filters['q'])) {
            $term = $filters['q'];
            $query->where(function ($builder) use ($term) {
                $builder->where('title', 'like', '%'.$term.'%')
                    ->orWhere('description', 'like', '%'.$term.'%')
                    ->orWhere('youtube_id', 'like', '%'.$term.'%');
            });
        }

        if (($filters['published'] ?? '') === '1') {
            $query->where('is_published', true);
        } elseif (($filters['published'] ?? '') === '0') {
            $query->where('is_published', false);
        }

        return view('cms-admin.tips.index', [
            'page' => 'admin',
            'title' => 'Nos astuces',
            'videos' => $query->paginate(25)->withQueryString(),
            'categories' => $categories,
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('cms-admin.tips.edit', [
            'page' => 'admin',
            'title' => 'Nouvelle vidéo',
            'video' => new TipVideo(['is_published' => true, 'published_at' => now(), 'category' => 'filiere']),
            'categories' => config('kiel.tip_video_categories', []),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $video = $this->save(new TipVideo, $request);

        return redirect()->route('admin.cms.tips.edit', $video)->with('status', 'Vidéo créée.');
    }

    public function edit(TipVideo $tip): View
    {
        return view('cms-admin.tips.edit', [
            'page' => 'admin',
            'title' => $tip->title ?: 'Astuce vidéo',
            'video' => $tip,
            'categories' => config('kiel.tip_video_categories', []),
        ]);
    }

    public function update(Request $request, TipVideo $tip): RedirectResponse
    {
        $this->save($tip, $request);

        return back()->with('status', 'Vidéo enregistrée.');
    }

    public function destroy(TipVideo $tip): RedirectResponse
    {
        $tip->delete();

        return redirect()->route('admin.cms.tips.index')->with('status', 'Vidéo supprimée.');
    }

    private function save(TipVideo $video, Request $request): TipVideo
    {
        $categories = array_keys(config('kiel.tip_video_categories', []));
        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:200'],
            'category' => ['required', 'string', Rule::in($categories)],
            'description' => ['nullable', 'string', 'max:2000'],
            'youtube_id' => ['required', 'string', 'max:32'],
            'duration_seconds' => ['nullable', 'integer', 'min:0', 'max:86400'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['sometimes', 'boolean'],
        ]);

        $slug = $data['slug'] ?: Str::slug($data['title']);
        $video->fill([
            'title' => $data['title'],
            'slug' => $slug,
            'category' => $data['category'],
            'description' => $data['description'] ?? null,
            'youtube_id' => trim($data['youtube_id']),
            'duration_seconds' => $data['duration_seconds'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'published_at' => $data['published_at'] ?? null,
            'is_published' => $request->boolean('is_published'),
        ]);
        $video->save();

        return $video;
    }
}
