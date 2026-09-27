@include('partials.money-attrs', [
  'fcfa' => $product->price_fcfa,
  'eur' => $product->price_eur,
  'usd' => $product->price_usd,
])
