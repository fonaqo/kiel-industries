<div class="kiel-empty-state">
<p>{{ $message ?? 'Aucun élément pour le moment.' }}</p>
<a class="kiel-btn kiel-btn--primary" href="{{ $ctaUrl ?? route('boutique') }}" data-turbo-frame="_top">{{ $ctaLabel ?? 'Aller à la boutique' }}</a>
</div>
