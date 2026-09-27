<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpertisePole;
use App\Support\CmsSeoRules;
use App\Support\CmsUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CmsExpertiseController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'published' => ['nullable', 'string', Rule::in(['', '1', '0'])],
        ]);

        $query = ExpertisePole::query()->orderBy('sort_order');

        if (! empty($filters['q'])) {
            $term = $filters['q'];
            $query->where(function ($builder) use ($term) {
                $builder->where('title', 'like', '%'.$term.'%')
                    ->orWhere('tag', 'like', '%'.$term.'%')
                    ->orWhere('slug', 'like', '%'.$term.'%');
            });
        }

        if (($filters['published'] ?? '') === '1') {
            $query->where('is_published', true);
        } elseif (($filters['published'] ?? '') === '0') {
            $query->where('is_published', false);
        }

        return view('cms-admin.expertises.index', [
            'page' => 'admin',
            'title' => 'Expertises',
            'poles' => $query->get(),
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('cms-admin.expertises.edit', [
            'page' => 'admin',
            'title' => 'Nouvelle expertise',
            'pole' => new ExpertisePole([
                'is_published' => true,
                'sort_order' => (ExpertisePole::query()->max('sort_order') ?? 0) + 1,
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $pole = $this->savePole(new ExpertisePole, $request);

        return redirect()->route('admin.cms.expertises.edit', $pole)->with('status', 'Expertise créée.');
    }

    public function edit(ExpertisePole $expertise): View
    {
        return view('cms-admin.expertises.edit', [
            'page' => 'admin',
            'title' => $expertise->title,
            'pole' => $expertise,
        ]);
    }

    public function update(Request $request, ExpertisePole $expertise): RedirectResponse
    {
        $this->savePole($expertise, $request);

        return redirect()->route('admin.cms.expertises.index')->with('status', 'Expertise mise à jour.');
    }

    public function destroy(ExpertisePole $expertise): RedirectResponse
    {
        $expertise->delete();

        return redirect()->route('admin.cms.expertises.index')->with('status', 'Expertise supprimée.');
    }

    private function savePole(ExpertisePole $pole, Request $request): ExpertisePole
    {
        $data = $request->validate(array_merge([
            'slug' => ['nullable', 'string', 'max:120'],
            'tag' => ['required', 'string', 'max:80'],
            'title' => ['required', 'string', 'max:160'],
            'intro' => ['required', 'string', 'max:500'],
            'paragraphs' => ['required', 'string'],
            'image' => ['nullable', 'string', 'max:500'],
            'image_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:8192'],
            'boutique_category' => ['nullable', 'string', 'max:80'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_published' => ['sometimes', 'boolean'],
        ], CmsSeoRules::rules()));

        $lines = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $data['paragraphs']))));
        $slug = $data['slug'] ?: Str::slug($data['title']);

        $imagePath = CmsUploads::resolvePath($request, 'image', 'image_file', $pole->image);
        if ($imagePath === null || $imagePath === '') {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'image' => 'Indiquez un lien d’image ou téléversez un fichier.',
            ]);
        }

        $pole->fill([
            'slug' => $slug,
            'tag' => $data['tag'],
            'title' => $data['title'],
            'intro' => $data['intro'],
            'paragraphs' => $lines,
            'image' => $imagePath,
            'boutique_category' => $data['boutique_category'] ?: null,
            'sort_order' => $data['sort_order'] ?? $pole->sort_order ?? 0,
            'is_published' => $request->boolean('is_published'),
            ...CmsSeoRules::onlyMeta($data),
        ]);
        $pole->save();

        return $pole;
    }
}
