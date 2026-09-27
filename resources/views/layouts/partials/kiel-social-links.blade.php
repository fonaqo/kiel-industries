@php
  $social = config('kiel.social', []);
  $context = $context ?? 'footer';
@endphp
@if($context === 'topbar')
<div class="kiel-site-topbar-social flex items-center gap-1.5" aria-label="Réseaux sociaux KIEL INDUSTRIES">
@foreach($social as $item)
<a href="{{ $item['url'] }}" rel="noopener noreferrer" target="_blank" aria-label="{{ $item['label'] }}" class="w-8 h-8 rounded-full flex items-center justify-center text-on-primary hover:bg-on-primary/15 transition-colors">
@include('layouts.partials.kiel-social-icon', ['icon' => $item['icon']])
</a>
@endforeach
</div>
@else
<div class="kiel-footer-social" aria-label="Réseaux sociaux KIEL INDUSTRIES">
@foreach($social as $item)
<a href="{{ $item['url'] }}" rel="noopener noreferrer" target="_blank" aria-label="{{ $item['label'] }}">
@include('layouts.partials.kiel-social-icon', ['icon' => $item['icon']])
</a>
@endforeach
</div>
@endif
