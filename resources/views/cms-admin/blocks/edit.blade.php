@extends('layouts.cms-admin')

@include('cms-admin.partials.wysiwyg-scripts')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-cms-upload]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const input = btn.parentElement.querySelector('input[type=file]');
      const target = document.querySelector(btn.dataset.cmsUpload);
      input.onchange = async () => {
        if (!input.files[0]) return;
        const fd = new FormData();
        fd.append('file', input.files[0]);
        fd.append('_token', '{{ csrf_token() }}');
        const res = await fetch('{{ route('admin.cms.media.store') }}', { method: 'POST', body: fd });
        const data = await res.json();
        if (target) target.value = data.path;
      };
      input.click();
    });
  });
});
</script>
@endpush

@section('panel')
<form class="kiel-cms-form" method="post" action="{{ route('admin.cms.blocks.update', $group) }}">
@csrf
@method('PUT')
@foreach($fields as $key => $field)
@php
  $block = $blocks->get($key);
  $val = old($key, $block?->type === 'json' ? json_encode($block->decodedContent(), JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) : ($block?->content ?? ''));
@endphp
<label>{{ $field['label'] }}
@if($field['type'] === 'json')
<textarea name="{{ $key }}" rows="8" class="kiel-cms-form__body">{{ $val }}</textarea>
@elseif($field['type'] === 'html')
<textarea name="{{ $key }}" data-wysiwyg="full" data-wysiwyg-height="280" rows="6">{{ $val }}</textarea>
@elseif($field['type'] === 'textarea')
<textarea name="{{ $key }}" data-wysiwyg="basic" rows="3">{{ $val }}</textarea>
@elseif($field['type'] === 'image')
<div class="kiel-cms-media-row">
<input id="field-{{ md5($key) }}" name="{{ $key }}" type="text" value="{{ $val }}" placeholder="assets/img/... ou storage/cms/..."/>
<input type="file" accept="image/*" hidden/>
<button type="button" class="kiel-cms-btn kiel-cms-btn--ghost" data-cms-upload="#field-{{ md5($key) }}">Uploader</button>
</div>
@else
<input name="{{ $key }}" type="text" value="{{ $val }}"/>
@endif
</label>
@endforeach
<div class="kiel-cms-form__actions">
<button class="kiel-cms-btn" type="submit">Enregistrer</button>
<a class="kiel-cms-btn kiel-cms-btn--ghost" href="{{ route('admin.cms.blocks.index') }}">Retour</a>
</div>
</form>
@endsection
