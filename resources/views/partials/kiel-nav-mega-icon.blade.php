@php
  use App\Support\CmsUploads;
  $imagePath = $image ?? null;
  $imageUrl = $imagePath ? CmsUploads::publicUrl($imagePath) : null;
  $slug = $slug ?? 'nutrition';
@endphp
<span class="kiel-nav-mega-icon">
@if($imageUrl)
<img class="kiel-nav-mega-icon__img" src="{{ $imageUrl }}" alt="" loading="lazy" width="48" height="48"/>
@else
@include('partials.kiel-category-icon', ['category' => $slug])
@endif
</span>
