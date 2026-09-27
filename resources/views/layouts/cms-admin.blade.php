<!DOCTYPE html>
<html lang="fr">
<head>
@include('layouts.partials.cms-admin-head')
</head>
<body class="kiel-cms-admin" data-page="admin">
<div class="kiel-cms-admin__backdrop" id="kiel-cms-sidebar-backdrop" aria-hidden="true"></div>
<div class="kiel-cms-admin__shell">
@include('cms-admin.partials.sidebar')
<div class="kiel-cms-admin__main">
@include('cms-admin.partials.topbar')
@if(session('status'))
<div class="kiel-cms-admin__flash" role="status">{{ session('status') }}</div>
@endif
<div class="kiel-cms-admin__content">
@yield('panel')
</div>
</div>
</div>
<script src="{{ asset('assets/js/admin/kiel-cms-admin.js') }}" defer></script>
@stack('scripts')
</body>
</html>
