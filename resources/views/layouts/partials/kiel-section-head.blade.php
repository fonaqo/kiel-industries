@php
  $eyebrow = $eyebrow ?? '';
  $title = $title ?? '';
  $lead = $lead ?? null;
  $centered = $centered ?? false;
  $showIcon = $showIcon ?? true;
@endphp
<div class="kiel-section-head {{ $centered ? 'kiel-section-head--center' : '' }} {{ $class ?? '' }}">
@if($showIcon)
@include('partials.kiel-section-eyebrow', ['label' => $eyebrow, 'centered' => $centered ?? false])
@else
<span class="kiel-eyebrow font-label-md text-label-md text-secondary uppercase tracking-widest">{{ $eyebrow }}</span>
@endif
<h2 class="font-headline-lg text-headline-lg lg:text-[2.75rem] text-primary font-title leading-tight mt-1">{{ $title }}</h2>
@if($lead)
<p class="font-body-md text-body-md text-on-surface-variant leading-relaxed mt-3 {{ $centered ? 'mx-auto' : '' }} max-w-2xl {{ $leadClass ?? '' }}">{{ $lead }}</p>
@endif
</div>
