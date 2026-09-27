@php
  $documents = $documents ?? collect();
  $showAllLink = $showAllLink ?? false;
  $categories = config('kiel.document_categories', []);
@endphp
@if($documents->isNotEmpty())
<div class="kiel-docs-grid">
@foreach($documents as $doc)
<article class="kiel-docs-card">
<span class="kiel-docs-card__tag">{{ $categories[$doc->category] ?? $doc->category }}</span>
<h3 class="kiel-docs-card__title">{{ $doc->title }}</h3>
@if($doc->summary)
<p class="kiel-docs-card__summary">{{ $doc->summary }}</p>
@endif
<p class="kiel-docs-card__meta">
@if($doc->issuer)<span>{{ $doc->issuer }}</span>@endif
@if($doc->issued_at)<time datetime="{{ $doc->issued_at->format('Y-m-d') }}">{{ $doc->issued_at->format('d/m/Y') }}</time>@endif
</p>
@if($doc->fileUrl())
<a class="kiel-docs-card__btn" href="{{ $doc->fileUrl() }}" target="_blank" rel="noopener">
<span class="material-symbols-outlined" aria-hidden="true">download</span> Télécharger
</a>
@endif
</article>
@endforeach
</div>
@if($showAllLink)
<p class="kiel-docs-more"><a href="{{ route('nos-documents') }}">Voir tous les documents <span class="material-symbols-outlined">arrow_forward</span></a></p>
@endif
@endif
