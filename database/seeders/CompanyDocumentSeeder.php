<?php

namespace Database\Seeders;

use App\Models\CompanyDocument;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompanyDocumentSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Agrément d’exploitation — unité de transformation Parakou',
                'slug' => 'agrement-unite-transformation-parakou',
                'category' => 'agrement',
                'summary' => 'Autorisation d’exploitation de l’unité de transformation et de conditionnement KIEL INDUSTRIES à Parakou (Borgou).',
                'issuer' => 'Ministère de l’Industrie et du Commerce — République du Bénin',
                'issued_at' => '2023-06-15',
                'sort_order' => 1,
                'file' => 'agrement-unite-parakou.pdf',
            ],
            [
                'title' => 'Certificat de conformité sanitaire — gamme alimentaire baobab',
                'slug' => 'certificat-conformite-sanitaire-alimentaire',
                'category' => 'certification',
                'summary' => 'Attestation relative aux bonnes pratiques d’hygiène et à la conformité des produits alimentaires à base de baobab.',
                'issuer' => 'ABSSA — Agence béninoise de sécurité sanitaire des aliments',
                'issued_at' => '2024-02-20',
                'sort_order' => 2,
                'file' => 'certificat-sanitaire-alimentaire.pdf',
            ],
            [
                'title' => 'Certification qualité — processus de transformation zéro déchet',
                'slug' => 'certification-qualite-zero-dechet',
                'category' => 'certification',
                'summary' => 'Document de référence sur le modèle d’économie circulaire appliqué à la filière baobab (pulpe, feuilles, coques, graines).',
                'issuer' => 'KIEL INDUSTRIES — Direction qualité',
                'issued_at' => '2024-09-01',
                'sort_order' => 3,
                'file' => 'certification-qualite-circulaire.pdf',
            ],
            [
                'title' => 'Rapport d’analyses nutritionnelles — poudre de pulpe de baobab',
                'slug' => 'analyses-nutritionnelles-pulpe-baobab',
                'category' => 'qualite',
                'summary' => 'Synthèse des analyses (fibres, vitamine C, minéraux) réalisées sur un lot de production KIEL.',
                'issuer' => 'Laboratoire partenaire accrédité',
                'issued_at' => '2025-01-10',
                'sort_order' => 4,
                'file' => 'rapport-analyses-pulpe.pdf',
            ],
            [
                'title' => 'Fiche d’identification fiscale (IFU)',
                'slug' => 'ifu-kiel-industries',
                'category' => 'autre',
                'summary' => 'Identifiant fiscal unique KIEL INDUSTRIES : 0201710192397.',
                'issuer' => 'Direction générale des impôts — Bénin',
                'issued_at' => '2022-11-08',
                'sort_order' => 5,
                'file' => 'ifu-kiel-industries.pdf',
            ],
            [
                'title' => 'Convention de partenariat — coopératives féminines du Borgou',
                'slug' => 'convention-cooperatives-borgou',
                'category' => 'partenariat',
                'summary' => 'Cadre de collaboration pour la collecte durable, la rémunération équitable et la formation des productrices.',
                'issuer' => 'KIEL INDUSTRIES & réseau de coopératives partenaires',
                'issued_at' => '2024-05-22',
                'sort_order' => 6,
                'file' => 'convention-cooperatives-borgou.pdf',
            ],
            [
                'title' => 'Attestation d’origine et traçabilité — export',
                'slug' => 'attestation-origine-tracabilite-export',
                'category' => 'agrement',
                'summary' => 'Document attestant l’origine béninoise des matières premières et la traçabilité lot par lot.',
                'issuer' => 'KIEL INDUSTRIES — Export & conformité',
                'issued_at' => '2025-03-14',
                'sort_order' => 7,
                'file' => 'attestation-origine-export.pdf',
            ],
        ];

        foreach ($items as $row) {
            $filePath = $this->ensureSeedPdf($row['file']);

            CompanyDocument::query()->updateOrCreate(
                ['slug' => $row['slug']],
                [
                    'title' => $row['title'],
                    'category' => $row['category'],
                    'summary' => $row['summary'],
                    'issuer' => $row['issuer'],
                    'issued_at' => $row['issued_at'],
                    'file_path' => $filePath,
                    'sort_order' => $row['sort_order'],
                    'is_published' => true,
                    'published_at' => now(),
                ]
            );
        }
    }

    private function ensureSeedPdf(string $filename): string
    {
        $relative = 'cms/documents/seed/'.$filename;

        if (! Storage::disk('public')->exists($relative)) {
            Storage::disk('public')->put($relative, $this->minimalPdfPlaceholder($filename));
        }

        return 'storage/'.$relative;
    }

    private function minimalPdfPlaceholder(string $label): string
    {
        $safe = Str::ascii(Str::limit(str_replace('.pdf', '', $label), 80, ''));

        return <<<PDF
%PDF-1.4
1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj
2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj
3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >> endobj
4 0 obj << /Length 120 >> stream
BT /F1 14 Tf 72 720 Td (KIEL INDUSTRIES - Document de demonstration) Tj 0 -24 Td ({$safe}) Tj 0 -24 Td (Remplacez par le PDF officiel via l admin CMS.) Tj ET
endstream endobj
5 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj
xref
0 6
0000000000 65535 f 
0000000009 00000 n 
0000000058 00000 n 
0000000115 00000 n 
0000000266 00000 n 
0000000438 00000 n 
trailer << /Size 6 /Root 1 0 R >>
startxref
515
%%EOF
PDF;
    }
}
