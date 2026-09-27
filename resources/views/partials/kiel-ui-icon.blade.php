@php
  $name = $name ?? 'arrow';
  $size = $size ?? 20;
  $class = trim('kiel-icon kiel-icon--'.$size.' '.($class ?? ''));
@endphp
<span class="{{ $class }}" aria-hidden="true">
@switch($name)
@case('location_on')
@case('location')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s7-4.5 7-11a7 7 0 10-14 0c0 6.5 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
@break
@case('call')
@case('phone')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 4h4l2 5-2 1a11 11 0 005 5l1-2 5 2v4a2 2 0 01-2 2A16 16 0 015 6a2 2 0 012-2z"/></svg>
@break
@case('mail')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
@break
@case('verified')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4"/><path d="M12 3l2.2 1.1 2.5-.3 1.4 2.1 2.3.8-.3 2.5 1.6 2-1.6 2 .3 2.5-2.3.8-1.4 2.1-2.5-.3L12 21l-2.2-1.1-2.5.3-1.4-2.1-2.3-.8.3-2.5L3.4 12l1.6-2-.3-2.5 2.3-.8 1.4-2.1 2.5.3L12 3z"/></svg>
@break
@case('local_shipping')
@case('shipping')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7h11v8H3z"/><path d="M14 10h4l3 3v2h-7v-5z"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg>
@break
@case('support_agent')
@case('support')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4a4 4 0 00-4 4v2H6a2 2 0 00-2 2v3h4v-3h1"/><path d="M12 20a4 4 0 004-4v-2h2a2 2 0 002-2V9h-4v3h-1"/><circle cx="12" cy="8" r="4"/></svg>
@break
@case('lock')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V8a4 4 0 118 0v3"/></svg>
@break
@case('eco')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5-3 8-7 8-12a8 8 0 10-16 0c0 5 3 9 8 12z"/></svg>
@break
@case('arrow_forward')
@case('arrow')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
@break
@case('handshake')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12l3 3 4-4 3 3 6-6"/><path d="M8 15l2 2 4-4"/></svg>
@break
@default
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/></svg>
@endswitch
</span>
