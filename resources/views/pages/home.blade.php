@extends('layouts.app')

@section('content')
@include('pages.partials.home-main', [
  'h' => $h ?? [],
  'cms' => $cms ?? app(\App\Services\CmsBlocks::class),
  'featuredCarousel' => $featuredCarousel ?? collect(),
  'pickDayProducts' => $pickDayProducts ?? collect(),
  'pickGridProducts' => $pickGridProducts ?? collect(),
  'homeProducts' => $homeProducts ?? collect(),
  'shopCategories' => $shopCategories ?? collect(),
  'homeExpertisePoles' => $homeExpertisePoles ?? collect(),
])
@endsection
