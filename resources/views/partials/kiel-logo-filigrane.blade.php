@php
  $variant = $variant ?? 'wordmark';
  $useMark = in_array($variant, ['heading', 'mark'], true);
  $class = trim(
      ($useMark ? 'kiel-heading-mark' : 'kiel-logo-wordmark kiel-logo-filigrane')
      .' kiel-logo--'.$variant
      .' '.($class ?? '')
  );
  $src = $useMark
      ? asset('assets/img/filigrane/baobab-silhouette.png')
      : asset('assets/img/brand/logo-kiel.svg');
@endphp
<img
  alt=""
  class="{{ $class }}"
  loading="lazy"
  src="{{ $src }}"
  @if($width ?? null) width="{{ $width }}" @endif
  @if($height ?? null) height="{{ $height }}" @endif
/>
