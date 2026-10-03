@php
  $label = $label ?? '';
  $class = trim($class ?? '');
  $centered = $centered ?? false;
  $textClass = trim($textClass ?? 'font-label-md text-label-md text-secondary uppercase tracking-widest');
@endphp
<div @class(['kiel-section-eyebrow', $class, 'justify-center' => $centered])>
@if(empty($withoutIcon))
@include('partials.kiel-baobab-heading-icon', array_filter([
  'width' => $iconWidth ?? null,
  'height' => $iconHeight ?? null,
]))
@endif
<span class="kiel-eyebrow {{ $textClass }}">{{ $label }}</span>
</div>
