@php
  $fcfa = (int) ($fcfa ?? 0);
  $eur = $eur ?? null;
  $usd = $usd ?? null;
@endphp
data-price-fcfa="{{ $fcfa }}"
@if($eur !== null && $eur !== '') data-price-eur="{{ $eur }}" @endif
@if($usd !== null && $usd !== '') data-price-usd="{{ $usd }}" @endif
