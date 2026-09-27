@php
  try {
    $cmsIntegrations = app(\App\Services\CmsSettings::class)->get('integrations') ?? [];
  } catch (\Throwable) {
    $cmsIntegrations = [];
  }
  $gtmId = trim((string) ($cmsIntegrations['google_tag_manager_id'] ?? ''));
  $metaPixel = trim((string) ($cmsIntegrations['meta_pixel_id'] ?? ''));
@endphp
@if($gtmId !== '')
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}" height="0" width="0" style="display:none;visibility:hidden" title="Google Tag Manager"></iframe></noscript>
@endif
@if($metaPixel !== '')
<script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init','{{ $metaPixel }}');fbq('track','PageView');</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ $metaPixel }}&ev=PageView&noscript=1" alt=""/></noscript>
@endif
@if(! empty($cmsIntegrations['body_html']))
{!! $cmsIntegrations['body_html'] !!}
@endif
