@extends('layouts.admin')

@section('heroTitle', 'Utilisateurs')
@section('heroLead', 'Comptes clients et administrateurs.')
@section('heroCurrent', 'Admin · Utilisateurs')

@section('panel')
<div class="mt-2">
@if($users->isEmpty())
@include('pages.account.partials.empty-state', ['message' => 'Aucun utilisateur inscrit.'])
@else
<ul class="space-y-2">
@foreach($users as $user)
<li class="kiel-contact-v3-chip justify-between">
<div><strong>{{ $user->display_name }}</strong><p>{{ $user->email }}@if($user->phone) · {{ $user->phone }}@endif</p></div>
@if($user->is_admin)<span class="kiel-shop-tag">Admin</span>@endif
</li>
@endforeach
</ul>
<div class="mt-6">{{ $users->links() }}</div>
@endif
</div>
@endsection
