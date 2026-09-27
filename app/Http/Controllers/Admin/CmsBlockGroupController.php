<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsBlock;
use App\Services\CmsBlocks;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CmsBlockGroupController extends Controller
{
    public function index(): View
    {
        $groups = config('cms-groups', []);

        return view('cms-admin.blocks.index', [
            'page' => 'admin',
            'title' => 'Blocs vitrine',
            'groups' => $groups,
        ]);
    }

    public function edit(string $group): View
    {
        $groups = config('cms-groups', []);
        abort_if(! isset($groups[$group]), 404);

        $fields = $groups[$group]['fields'];
        $blocks = CmsBlock::query()->whereIn('key', array_keys($fields))->get()->keyBy('key');

        return view('cms-admin.blocks.edit', [
            'page' => 'admin',
            'title' => $groups[$group]['label'],
            'group' => $group,
            'groupLabel' => $groups[$group]['label'],
            'fields' => $fields,
            'blocks' => $blocks,
        ]);
    }

    public function update(Request $request, string $group, CmsBlocks $cmsBlocks): RedirectResponse
    {
        $groups = config('cms-groups', []);
        abort_if(! isset($groups[$group]), 404);

        foreach ($groups[$group]['fields'] as $key => $field) {
            if (! $request->has($key)) {
                continue;
            }
            $value = $request->input($key);
            if ($field['type'] === 'json') {
                $decoded = json_decode($value, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return back()->withErrors([$key => 'JSON invalide pour '.$field['label']])->withInput();
                }
                $cmsBlocks->put($key, $decoded, 'json');
            } else {
                CmsBlock::query()->where('key', $key)->update([
                    'content' => is_string($value) ? $value : '',
                ]);
            }
        }

        $cmsBlocks->flush();

        return back()->with('status', 'Contenu « '.$groups[$group]['label'].' » enregistré.');
    }
}
