@php
  $inputId = $inputId ?? 'cms-image-'.uniqid();
  $urlName = $urlName ?? 'image_url';
  $fileName = $fileName ?? 'image_file';
  $rawValue = old($urlName, $value ?? '');
  $previewUrl = \App\Support\CmsUploads::publicUrl($rawValue) ?? '';
  $labelText = $label ?? 'Image';
  $startTab = filled($rawValue) && ! str_starts_with($rawValue, 'storage/') ? 'link' : (filled($rawValue) ? 'link' : 'upload');
@endphp
<div class="kiel-cms-media-field" data-kiel-cms-media data-upload-url="{{ route('admin.cms.media.store') }}" data-initial-tab="{{ $startTab }}">
<p class="kiel-cms-media-field__label">{{ $labelText }}</p>
<div class="kiel-cms-media-field__shell">
<div class="kiel-cms-media-tabs" role="tablist" aria-label="{{ $labelText }}">
<button type="button" class="kiel-cms-media-tabs__btn is-active" role="tab" aria-selected="true" data-kiel-media-tab="link">Lien</button>
<button type="button" class="kiel-cms-media-tabs__btn" role="tab" aria-selected="false" data-kiel-media-tab="upload">Fichier</button>
</div>
<div class="kiel-cms-media-field__body">
<div class="kiel-cms-media-panel" data-kiel-media-panel="link">
<input id="{{ $inputId }}" name="{{ $urlName }}" type="text" class="kiel-cms-media-field__input" value="{{ $rawValue }}" placeholder="https://… ou assets/img/…" data-kiel-cms-media-url autocomplete="off"/>
</div>
<div class="kiel-cms-media-panel" data-kiel-media-panel="upload" hidden>
<label class="kiel-cms-media-drop">
<span class="material-symbols-outlined" aria-hidden="true">cloud_upload</span>
<span>Choisir une image</span>
<input type="file" name="{{ $fileName }}" accept="image/jpeg,image/png,image/webp,image/svg+xml" data-kiel-cms-media-file/>
</label>
<p class="kiel-cms-media-field__hint">JPG, PNG, WebP · 8 Mo max</p>
</div>
<figure class="kiel-cms-media-field__thumb @if(! $previewUrl) is-empty @endif" data-kiel-cms-media-preview-wrap">
<img src="{{ $previewUrl }}" alt="" loading="lazy" data-kiel-cms-media-preview @if(! $previewUrl) hidden @endif/>
<span class="kiel-cms-media-field__thumb-placeholder material-symbols-outlined" aria-hidden="true" @if($previewUrl) hidden @endif>image</span>
</figure>
</div>
</div>
</div>
