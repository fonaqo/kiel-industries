@extends('layouts.cms-admin')

@section('panel')
<div class="kiel-cms-shortcuts">
@foreach($groups as $slug => $meta)
<a class="kiel-cms-btn kiel-cms-btn--secondary kiel-cms-btn--block" href="{{ route('admin.cms.blocks.edit', $slug) }}">{{ $meta['label'] }}</a>
@endforeach
</div>
@endsection
