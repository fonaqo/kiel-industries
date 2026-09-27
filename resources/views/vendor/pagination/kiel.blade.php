@if ($paginator->hasPages())
<nav class="kiel-pagination" role="navigation" aria-label="Pagination">
@if ($paginator->total() > 0)
<p class="kiel-pagination__meta">
<span class="kiel-pagination__meta-num">{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}</span>
sur {{ $paginator->total() }}
</p>
@endif
<ul class="kiel-pagination__list">
@if ($paginator->onFirstPage())
<li><span class="kiel-pagination__edge is-disabled" aria-disabled="true"><span class="material-symbols-outlined" aria-hidden="true">chevron_left</span><span class="kiel-pagination__edge-label">Préc.</span></span></li>
@else
<li><a class="kiel-pagination__edge" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Page précédente"><span class="material-symbols-outlined" aria-hidden="true">chevron_left</span><span class="kiel-pagination__edge-label">Préc.</span></a></li>
@endif

@foreach ($elements as $element)
@if (is_string($element))
<li><span class="kiel-pagination__dots" aria-hidden="true">{{ $element }}</span></li>
@endif
@if (is_array($element))
@foreach ($element as $page => $url)
@if ($page == $paginator->currentPage())
<li><span class="kiel-pagination__page is-active" aria-current="page">{{ $page }}</span></li>
@else
<li><a class="kiel-pagination__page" href="{{ $url }}">{{ $page }}</a></li>
@endif
@endforeach
@endif
@endforeach

@if ($paginator->hasMorePages())
<li><a class="kiel-pagination__edge" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Page suivante"><span class="kiel-pagination__edge-label">Suiv.</span><span class="material-symbols-outlined" aria-hidden="true">chevron_right</span></a></li>
@else
<li><span class="kiel-pagination__edge is-disabled" aria-disabled="true"><span class="kiel-pagination__edge-label">Suiv.</span><span class="material-symbols-outlined" aria-hidden="true">chevron_right</span></span></li>
@endif
</ul>
</nav>
@endif
