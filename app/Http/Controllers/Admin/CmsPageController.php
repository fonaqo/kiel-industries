<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CmsPageController extends Controller
{
    public function index(): View
    {
        return view('cms-admin.pages.index', [
            'page' => 'admin',
            'title' => 'Pages & légal',
            'pages' => CmsPage::query()->orderBy('section')->orderBy('sort_order')->get(),
        ]);
    }

    public function edit(CmsPage $cms_page): View
    {
        return view('cms-admin.pages.edit', [
            'page' => 'admin',
            'title' => 'Modifier '.$cms_page->title,
            'cmsPage' => $cms_page,
        ]);
    }

    public function update(Request $request, CmsPage $cms_page): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'lead' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:160'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'hero_image' => ['nullable', 'string', 'max:255'],
            'is_published' => ['sometimes', 'boolean'],
        ]);

        $data['is_published'] = $request->boolean('is_published');

        $cms_page->update($data);

        return redirect()->route('admin.cms.pages.index')->with('status', 'Page enregistrée.');
    }
}
