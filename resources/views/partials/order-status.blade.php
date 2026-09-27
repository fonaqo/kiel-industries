@php
  use App\Support\OrderStatus;
  $normalized = OrderStatus::normalize($status);
  $label = OrderStatus::label($status);
  $class = match ($normalized) {
      'delivered' => 'kiel-order-status--ok',
      'cancelled' => 'kiel-order-status--muted',
      'shipping' => 'kiel-order-status--progress',
      'processing' => 'kiel-order-status--pending',
      default => 'kiel-order-status--pending',
  };
@endphp
<span class="kiel-order-status {{ $class }}">{{ $label }}</span>
