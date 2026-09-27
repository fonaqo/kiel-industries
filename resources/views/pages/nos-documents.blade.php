@extends('layouts.app')

@push('head')
<link href="{{ asset('assets/css/pages/kiel-documents.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<main class="w-full pt-[118px] sm:pt-[122px] kiel-docs-page">

@include('layouts.partials.page-subhero', [
  'heroTitle' => 'Nos documents',
  'heroLead' => 'Agréments, certifications, partenariats institutionnels et pièces officielles de KIEL INDUSTRIES.',
  'heroCurrent' => 'Nos documents',
])

<section class="kiel-section kiel-docs-section">
<div class="kiel-wrap">
@include('layouts.partials.kiel-section-head', [
  'eyebrow' => 'Transparence & conformité',
  'title' => 'Agréments, certifications et références',
  'lead' => 'Retrouvez les documents que nous mettons à disposition de nos partenaires, clients et institutions.',
  'centered' => true,
])

<nav class="kiel-docs-filters" aria-label="Filtrer par catégorie">
<a href="{{ route('nos-documents') }}" @class(['is-active' => ! $activeCategory])>Tous</a>
@foreach($categories as $key => $label)
<a href="{{ route('nos-documents', ['cat' => $key]) }}" @class(['is-active' => $activeCategory === $key])>{{ $label }}</a>
@endforeach
</nav>

@if($documents->isEmpty())
<p class="text-center text-on-surface-variant py-8">Aucun document publié pour le moment dans cette catégorie.</p>
@else
@include('partials.kiel-documents-grid', ['documents' => $documents])
@endif
</div>
</section>

</main>
@endsection
