@php
  $items = old('gallery_lines', isset($gallery) && is_array($gallery) ? implode("\n", $gallery) : '');
  $previews = is_array($gallery ?? null) ? $gallery : [];
@endphp
<div class="kiel-cms-gallery-field" data-kiel-cms-gallery>
<p class="kiel-cms-media-field__label">Galerie produit</p>
<div class="kiel-cms-media-field__shell">
<div class="kiel-cms-media-tabs" role="tablist" aria-label="Galerie">
<button type="button" class="kiel-cms-media-tabs__btn is-active" data-kiel-gallery-tab="link">Liens</button>
<button type="button" class="kiel-cms-media-tabs__btn" data-kiel-gallery-tab="upload">Fichiers</button>
</div>
<div class="kiel-cms-media-panel" data-kiel-gallery-panel="link">
<textarea class="kiel-cms-media-field__input kiel-cms-media-field__input--compact" name="gallery_lines" rows="2" placeholder="assets/img/… — une URL par ligne">{{ $items }}</textarea>
</div>
<div class="kiel-cms-media-panel" data-kiel-gallery-panel="upload" hidden>
<label class="kiel-cms-media-drop kiel-cms-media-drop--compact">
<span class="material-symbols-outlined" aria-hidden="true">photo_library</span>
<span>Ajouter des photos</span>
<input type="file" name="gallery_files[]" accept="image/jpeg,image/png,image/webp" multiple/>
</label>
</div>
@if($previews !== [])
<ul class="kiel-cms-gallery-field__list">
@foreach($previews as $src)
<li><img src="{{ \App\Support\CmsUploads::publicUrl($src) }}" alt="" loading="lazy"/></li>
@endforeach
</ul>
@endif
</div>
</div>
