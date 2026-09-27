<div class="nav-dropdown nav-mega rounded-xl bg-surface shadow-[0_16px_48px_rgba(44,0,10,.14)] border border-outline-variant/25">
<div class="nav-mega-grid">
@forelse($navExpertises ?? [] as $pole)
<a class="nav-mega-link" href="{{ route('expertises.show', $pole->slug) }}">
@include('partials.kiel-nav-mega-icon', ['image' => $pole->image, 'slug' => $pole->slug])
<span><strong>{{ $pole->title }}</strong>@if($pole->tag)<em>{{ $pole->tag }}</em>@elseif($pole->intro)<em>{{ \Illuminate\Support\Str::limit($pole->intro, 90) }}</em>@endif</span>
</a>
@empty
<a class="nav-mega-link" href="{{ route('expertises') }}"><span class="kiel-nav-mega-icon">@include('partials.kiel-category-icon', ['category' => 'filiere'])</span><span><strong>Nos expertises</strong><em>Valorisation du baobab au Borgou.</em></span></a>
@endforelse
</div>
</div>
