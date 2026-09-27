@extends('pages.legal._layout')

@php
  $legalTitle = $cmsPage->title;
  $legalLead = $cmsPage->lead ?? '';
  $legalCurrent = $cmsPage->title;
  $heroImage = $cmsPage->heroImageUrl() ?? asset(config('kiel.subhero_image'));
  $title = $cmsPage->meta_title ?: $cmsPage->title;
@endphp

@section('legal-content')
{!! $cmsPage->body !!}
@endsection
