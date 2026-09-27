@php
  $entity = $entity ?? null;
  $showRobots = $showRobots ?? true;
  $showOg = $showOg ?? true;
@endphp
<section class="kiel-cms-seo-panel" aria-labelledby="seo-panel-title">
<h2 id="seo-panel-title" class="kiel-cms-seo-panel__title"><span class="material-symbols-outlined">travel_explore</span> Référencement</h2>
<p class="kiel-cms-seo-panel__hint">Optimise l’affichage Google, Open Graph et partages sociaux.</p>
<label>Meta title <span class="kiel-cms-char">160 car. max</span>
<input name="meta_title" maxlength="160" value="{{ old('meta_title', $entity?->meta_title) }}" placeholder="Titre SEO (sinon titre affiché)"/>
</label>
<label>Meta description <span class="kiel-cms-char">500 car. max</span>
<textarea name="meta_description" rows="3" maxlength="500" placeholder="Résumé pour les moteurs de recherche">{{ old('meta_description', $entity?->meta_description) }}</textarea>
</label>
<label>Mots-clés
<input name="meta_keywords" value="{{ old('meta_keywords', $entity?->meta_keywords) }}" placeholder="baobab, Parakou, KIEL…"/>
</label>
@if($showOg)
<label>Image Open Graph (chemin)
<input name="og_image" value="{{ old('og_image', $entity?->og_image) }}" placeholder="assets/img/…"/>
</label>
@endif
@if($showRobots)
<label>Robots (optionnel)
<input name="robots" value="{{ old('robots', $entity?->robots) }}" placeholder="index,follow"/>
</label>
@endif
</section>
