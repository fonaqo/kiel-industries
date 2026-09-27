@php
  $icon = $icon ?? 'dashboard';
  $class = trim('kiel-cms-sidebar__nav-icon '.($class ?? ''));
@endphp
<span class="{{ $class }}" aria-hidden="true">
@switch($icon)
@case('space_dashboard')
@case('dashboard')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="8" height="8" rx="1.5"/><rect x="13" y="3" width="8" height="5" rx="1.5"/><rect x="13" y="10" width="8" height="11" rx="1.5"/><rect x="3" y="13" width="8" height="8" rx="1.5"/></svg>
@break
@case('receipt_long')
@case('orders')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M7 3h10a2 2 0 012 2v16l-3-2-3 2-3-2-3 2-3-2V5a2 2 0 012-2z"/><path d="M9 7h6M9 11h6M9 15h4"/></svg>
@break
@case('inventory_2')
@case('products')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7.5L12 3l8 4.5v9L12 21l-8-4.5v-9z"/><path d="M12 12v9M4 7.5l8 4.5 8-4.5"/></svg>
@break
@case('category')
@case('categories')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h7v7H4zM13 6h7v4h-7zM13 12h7v7h-7zM4 15h7v4H4z"/></svg>
@break
@case('psychology')
@case('expertises')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3a5 5 0 00-5 5c0 2.2 1.2 4.1 3 5.1V17a2 2 0 002 2h0a2 2 0 002-2v-3.9c1.8-1 3-2.9 3-5.1a5 5 0 00-5-5z"/><path d="M9.5 21h5"/></svg>
@break
@case('newspaper')
@case('posts')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M5 4h14a1 1 0 011 1v15l-4-2-4 2-4-2-4 2V5a1 1 0 011-1z"/><path d="M8 8h8M8 12h8M8 16h5"/></svg>
@break
@case('smart_display')
@case('tips')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="12" rx="2"/><path d="M10 9l4 2-4 2V9z"/><path d="M8 21h8"/></svg>
@break
@case('description')
@case('documents')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3h8l4 4v14H8V3z"/><path d="M16 3v4h4M10 12h6M10 16h6"/></svg>
@break
@case('tune')
@case('settings')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h3M4 17h3M17 7h3M17 17h3"/><circle cx="10" cy="7" r="2"/><circle cx="14" cy="17" r="2"/><path d="M12 9v6"/></svg>
@break
@case('group')
@case('users')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3"/><path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6"/><circle cx="17" cy="9" r="2.5"/><path d="M15 20c.3-2.2 2-4 4-4"/></svg>
@break
@case('logout')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M10 7V5a2 2 0 012-2h6v18h-6a2 2 0 01-2-2v-2"/><path d="M14 12H4M7 9l-3 3 3 3"/></svg>
@break
@case('storefront')
@case('boutique')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M4 10h16l-1.5-6H5.5L4 10z"/><path d="M6 10v10h12V10"/><path d="M10 14v4M14 14v4"/></svg>
@break
@default
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="12" r="8"/></svg>
@endswitch
</span>
