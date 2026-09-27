@php
  $wine = (bool) ($wine ?? false);
  $mono = (bool) ($mono ?? false);
  $class = trim('baobab-sil '.($mono ? 'baobab-sil--mono ' : '').($wine ? 'baobab-sil--wine ' : '').($class ?? ''));
@endphp
<img alt="" class="{{ $class }}" loading="lazy" src="{{ asset('assets/img/filigrane/baobab-silhouette.png') }}"/>
