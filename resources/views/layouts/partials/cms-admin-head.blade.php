@php
  $docTitle = filled($title ?? null) ? trim($title).' · KIEL Admin' : 'KIEL Admin';
@endphp
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<meta name="robots" content="noindex,nofollow"/>
<title>{{ $docTitle }}</title>
<link rel="icon" type="image/png" href="{{ asset('assets/img/brand/favicon.png') }}"/>
<link rel="apple-touch-icon" href="{{ asset('assets/img/brand/favicon.png') }}"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet"/>
<link href="{{ asset('assets/css/admin/kiel-cms-admin.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-logos.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-scrollbar.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/core/kiel-pagination.css') }}" rel="stylesheet"/>
@stack('head')
