@extends('layouts.app')

@push('head')
<link href="{{ asset('assets/css/pages/kiel-legal.css') }}" rel="stylesheet"/>
@endpush

@section('content')
<main class="w-full pt-[118px] sm:pt-[122px] bg-surface">

@include('layouts.partials.page-subhero', [
  'heroTitle' => $legalTitle ?? $title,
  'heroLead' => $legalLead ?? '',
  'heroImage' => $heroImage ?? asset(config('kiel.subhero_image')),
  'heroCurrent' => $legalCurrent ?? $title,
])

<section class="kiel-section kiel-section--content kiel-section--cream">
<div class="kiel-wrap">
<div class="kiel-subpage-frame kiel-legal-prose">
@yield('legal-content')
</div>
</div>
</section>
</main>
@endsection
