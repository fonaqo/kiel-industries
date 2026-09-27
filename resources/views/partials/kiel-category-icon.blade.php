@php
  $slug = $category ?? 'nutrition';
  $class = trim('kiel-category-icon '.($class ?? ''));
@endphp
<span class="{{ $class }}" aria-hidden="true">
@switch($slug)
@case('soins')
@case('cosmetique')
<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="24" cy="24" r="22" stroke="#318135" stroke-width="2" opacity=".25"/><path d="M18 32c0-6 2.5-14 6-14s6 8 6 14" stroke="#2c000a" stroke-width="2" stroke-linecap="round"/><path d="M24 14v4M24 34v2" stroke="#318135" stroke-width="2" stroke-linecap="round"/><ellipse cx="24" cy="20" rx="5" ry="3" fill="#318135" opacity=".35"/></svg>
@break
@case('breuvages')
@case('breuvage')
<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 38h20" stroke="#318135" stroke-width="2" stroke-linecap="round"/><path d="M18 38V18l6-6 6 6v20" stroke="#2c000a" stroke-width="2" stroke-linejoin="round"/><path d="M18 22h12" stroke="#318135" stroke-width="1.5"/></svg>
@break
@case('artisanat')
<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="24" cy="26" r="10" stroke="#2c000a" stroke-width="2"/><path d="M24 16V8M24 44v-8M8 26h8M32 26h8" stroke="#318135" stroke-width="2" stroke-linecap="round"/><circle cx="24" cy="26" r="3" fill="#318135" opacity=".5"/></svg>
@break
@case('filiere')
@case('pole-1')
<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M24 6c-7 2-11 9-11 16 0 9 4 15 11 15s11-6 11-15c0-7-4-14-11-16z" fill="#318135" opacity=".8"/><path d="M20 32h8" stroke="#2c000a" stroke-width="2" stroke-linecap="round"/></svg>
@break
@case('conseil')
@case('pole-2')
<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 36h24" stroke="#318135" stroke-width="2" stroke-linecap="round"/><path d="M16 36V20l8-8 8 8v16" stroke="#2c000a" stroke-width="2"/><circle cx="24" cy="18" r="4" fill="#318135" opacity=".4"/></svg>
@break
@case('projets')
@case('pole-4')
<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="10" y="14" width="28" height="20" rx="2" stroke="#2c000a" stroke-width="2"/><path d="M16 22h16M16 28h10" stroke="#318135" stroke-width="2" stroke-linecap="round"/></svg>
@break
@case('mentorat')
@case('pole-3')
<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="18" cy="16" r="5" stroke="#2c000a" stroke-width="2"/><circle cx="30" cy="20" r="4" stroke="#318135" stroke-width="2"/><path d="M8 38c0-6 4-10 10-10s10 4 10 10" stroke="#2c000a" stroke-width="2"/></svg>
@break
@case('packs')
@case('rituals')
<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="10" y="16" width="28" height="22" rx="3" stroke="#2c000a" stroke-width="2"/><path d="M10 22h28" stroke="#318135" stroke-width="2"/><path d="M18 16V12a6 6 0 0112 0v4" stroke="#318135" stroke-width="2"/></svg>
@break
@default
<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M24 8c-8 3-12 10-12 18 0 10 5 16 12 16s12-6 12-16c0-8-4-15-12-18z" fill="#318135" opacity=".85"/><path d="M24 10V6M16 12l8-6 8 6" stroke="#1a4520" stroke-width="1.5" stroke-linecap="round"/><path d="M20 34c-1 8-1 12 0 14h8c1-2 1-6 0-14" fill="#2c000a"/></svg>
@endswitch
</span>
