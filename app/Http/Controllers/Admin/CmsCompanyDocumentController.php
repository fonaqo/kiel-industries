<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyDocument;
use App\Support\CmsUploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CmsCompanyDocumentController extends Controller
{
    public function index(): View
    {
        return view('cms-admin.documents.index', [
            'page' => 'admin',
            'title' => 'Documents officiels',
            'documents' => CompanyDocument::query()->orderBy('sort_order')->orderByDesc('published_at')->paginate(25),
            'categories' => config('kiel.document_categories', []),
        ]);
    }

    public function create(): View
    {
        return view('cms-admin.documents.edit', [
            'page' => 'admin',
            'title' => 'Nouveau document',
            'document' => new CompanyDocument(['is_published' => true, 'published_at' => now(), 'category' => 'certification']),
            'categories' => config('kiel.document_categories', []),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $document = $this->save(new CompanyDocument, $request);

        return redirect()->route('admin.cms.documents.edit', $document)->with('status', 'Document créé.');
    }

    public function edit(CompanyDocument $document): View
    {
        return view('cms-admin.documents.edit', [
            'page' => 'admin',
            'title' => $document->title ?: 'Document',
            'document' => $document,
            'categories' => config('kiel.document_categories', []),
        ]);
    }

    public function update(Request $request, CompanyDocument $document): RedirectResponse
    {
        $this->save($document, $request);

        return back()->with('status', 'Document enregistré.');
    }

    public function destroy(CompanyDocument $document): RedirectResponse
    {
        $document->delete();

        return redirect()->route('admin.cms.documents.index')->with('status', 'Document supprimé.');
    }

    private function save(CompanyDocument $document, Request $request): CompanyDocument
    {
        $categories = array_keys(config('kiel.document_categories', []));
        $isNew = ! $document->exists;

        $data = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:200'],
            'category' => ['required', 'string', Rule::in($categories)],
            'summary' => ['nullable', 'string', 'max:1000'],
            'issuer' => ['nullable', 'string', 'max:160'],
            'issued_at' => ['nullable', 'date'],
            'file_url' => ['nullable', 'string', 'max:500'],
            'file_upload' => [$isNew ? 'required_without:file_url' : 'nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:12288'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['sometimes', 'boolean'],
        ]);

        $filePath = $document->file_path;
        if ($request->hasFile('file_upload')) {
            $stored = CmsUploads::storeDocument($request->file('file_upload'));
            if ($stored !== null) {
                $filePath = $stored;
            }
        } elseif (trim((string) ($data['file_url'] ?? '')) !== '') {
            $filePath = trim($data['file_url']);
        }

        $slug = $data['slug'] ?: Str::slug($data['title']);
        if ($filePath === null || $filePath === '') {
            throw ValidationException::withMessages([
                'file_upload' => 'Un fichier ou une URL de document est requis.',
            ]);
        }

        $document->fill([
            'title' => $data['title'],
            'slug' => $slug,
            'category' => $data['category'],
            'summary' => $data['summary'] ?? null,
            'issuer' => $data['issuer'] ?? null,
            'issued_at' => $data['issued_at'] ?? null,
            'file_path' => $filePath,
            'sort_order' => $data['sort_order'] ?? 0,
            'published_at' => $data['published_at'] ?? null,
            'is_published' => $request->boolean('is_published'),
        ]);
        $document->save();

        return $document;
    }
}
