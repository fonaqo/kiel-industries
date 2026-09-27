@php
  $headline = $headline ?? '';
  $preheader = $preheader ?? '';
  $logoUrl = asset('assets/img/brand/logo-kiel.svg');
  $credit = config('kiel.site_credit.company', 'Fonaqo SARL');
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>{{ $headline ?: 'KIEL INDUSTRIES' }}</title>
</head>
<body style="margin:0;padding:0;background:#ffffff;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;color:#2c000a;">
@if(($preheader ?? '') !== '')
<div style="display:none;max-height:0;overflow:hidden;opacity:0;">{{ $preheader }}</div>
@endif
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#ffffff;padding:28px 12px 16px;">
<tr><td align="center">
<table role="presentation" width="600" cellspacing="0" cellpadding="0" style="max-width:600px;width:100%;">
<tr><td align="center" style="padding:8px 0 20px;">
<img src="{{ $logoUrl }}" alt="KIEL INDUSTRIES" width="200" style="display:block;height:auto;max-width:200px;width:100%;object-fit:contain;"/>
</td></tr>
</table>
</td></tr>
</table>
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#ffffff;padding:0 12px 32px;">
<tr><td align="center">
<table role="presentation" width="600" cellspacing="0" cellpadding="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid rgba(44,0,10,.1);">
@if($headline !== '')
<tr><td style="padding:28px 32px 8px;background:#ffffff;">
<p style="margin:0;font-size:11px;font-weight:800;letter-spacing:.18em;text-transform:uppercase;color:#318135;">KIEL INDUSTRIES · Parakou</p>
<h1 style="margin:10px 0 0;font-family:Georgia,'Times New Roman',serif;font-size:26px;line-height:1.25;color:#2c000a;">{{ $headline }}</h1>
</td></tr>
@endif
<tr><td style="padding:{{ $headline !== '' ? '12px 32px 32px' : '32px' }};font-size:15px;line-height:1.65;color:#534344;background:#ffffff;">
@yield('content')
</td></tr>
<tr><td style="padding:20px 32px 28px;background:#ffffff;border-top:1px solid rgba(216,193,195,.45);">
<p style="margin:0 0 6px;font-size:13px;color:#2c000a;font-weight:700;">KIEL INDUSTRIES</p>
<p style="margin:0;font-size:12px;line-height:1.55;color:#534344;">Parakou, Borgou, Bénin · <a href="mailto:kielbienetre@gmail.com" style="color:#318135;">kielbienetre@gmail.com</a></p>
</td></tr>
</table>
<p style="margin:16px 0 0;font-size:11px;color:#74313d;text-align:center;">© {{ date('Y') }} KIEL INDUSTRIES · Développé par {{ $credit }}</p>
</td></tr>
</table>
</body>
</html>
