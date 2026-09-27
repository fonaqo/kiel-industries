<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CmsSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CmsSeoController extends Controller
{
    public function edit(CmsSettings $cms): View
    {
        $seo = $cms->get('seo') ?? config('kiel.seo');

        return view('cms-admin.seo.edit', [
            'page' => 'admin',
            'title' => 'Référencement',
            'seo' => $seo,
        ]);
    }

    public function update(Request $request, CmsSettings $cms): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:120'],
            'default_title' => ['required', 'string', 'max:160'],
            'default_description' => ['required', 'string', 'max:500'],
            'default_keywords' => ['nullable', 'string', 'max:500'],
            'default_image' => ['nullable', 'string', 'max:255'],
        ]);

        $current = $cms->get('seo') ?? config('kiel.seo');
        $merged = array_replace_recursive($current, $data);
        $cms->put('seo', $merged);

        return back()->with('status', 'Référencement mis à jour.');
    }
}
