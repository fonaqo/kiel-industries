@extends('layouts.app')

@section('content')
<main class="w-full pt-[118px] sm:pt-[122px] bg-surface">

@include('layouts.partials.page-subhero', [
  'heroTitle' => $post->title,
  'heroLead' => $post->excerpt,
  'heroImage' => $post->resolved_image_url ?? asset('assets/img/sections/about/about-3.jpg'),
  'heroCurrent' => 'Actualité',
])

<section class="kiel-section kiel-section--cream">
<div class="kiel-wrap kiel-legal-prose">
<p class="kiel-hero__eyebrow">{{ $post->category }} · {{ $post->published_at->translatedFormat('d F Y') }}</p>
@if($post->body)
{!! $post->body !!}
@else
<p>{{ $post->excerpt }}</p>
@endif
<p style="margin-top:2rem"><a href="{{ route('actualites') }}" class="kiel-categories-all-link">← Retour aux actualités</a></p>
</div>
</section>
</main>
@endsection

@push('head')
<link href="{{ asset('assets/css/pages/kiel-legal.css') }}" rel="stylesheet"/>
@endpush
