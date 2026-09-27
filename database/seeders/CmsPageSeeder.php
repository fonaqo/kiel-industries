<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use Illuminate\Database\Seeder;

class CmsPageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            $this->mentionsLegales(),
            $this->politiqueConfidentialite(),
            $this->conditionsGenerales(),
            $this->conditionsUtilisation(),
            $this->pageContact(),
            $this->pagePartenaire(),
        ];

        foreach ($pages as $page) {
            CmsPage::query()->updateOrCreate(['slug' => $page['slug']], $page);
        }
    }

    /** @return array<string, mixed> */
    private function mentionsLegales(): array
    {
        return [
            'slug' => 'mentions-legales',
            'title' => 'Mentions légales',
            'lead' => 'Informations légales relatives à KIEL INDUSTRIES, éditeur du site, hébergement et propriété intellectuelle.',
            'section' => 'legal',
            'hero_image' => 'assets/img/banners/fond-vect.jpg',
            'meta_title' => 'Mentions légales — KIEL INDUSTRIES Parakou',
            'meta_description' => 'Éditeur, directeur de publication, hébergement, propriété intellectuelle et crédits du site KIEL INDUSTRIES au Bénin.',
            'meta_keywords' => 'mentions légales, KIEL INDUSTRIES, Parakou, IFU, éditeur site',
            'body' => <<<'HTML'
<h2>Éditeur du site</h2>
<p><strong>KIEL INDUSTRIES</strong>, entreprise de droit béninois, exerçant dans la valorisation intégrale du baobab (nutrition, cosmétique, artisanat, économie circulaire).</p>
<ul>
<li><strong>Dénomination :</strong> KIEL INDUSTRIES</li>
<li><strong>Siège :</strong> Parakou, Borgou, République du Bénin</li>
<li><strong>IFU :</strong> 0201710192397</li>
<li><strong>Téléphone :</strong> <a href="tel:+2290165728584">+229 0165728584</a></li>
<li><strong>E-mail :</strong> <a href="mailto:kielbienetre@gmail.com">kielbienetre@gmail.com</a></li>
</ul>

<h2>Directeur de la publication</h2>
<p>La direction générale de KIEL INDUSTRIES, représentée par la Présidente directrice générale.</p>

<h2>Activité</h2>
<p>Transformation et commercialisation de produits issus du baobab, programmes nutritionnels, soins dermo-botaniques, artisanat zéro déchet, recherche &amp; innovation (brevets OAPI), accompagnement de coopératives au Borgou.</p>

<h2>Hébergement</h2>
<p>Le site est hébergé par un prestataire professionnel. Les coordonnées techniques complètes (raison sociale, adresse, contact) sont tenues à la disposition des autorités et des utilisateurs sur demande écrite à <a href="mailto:kielbienetre@gmail.com">kielbienetre@gmail.com</a>.</p>

<h2>Propriété intellectuelle</h2>
<p>L’ensemble des éléments du site (structure, textes, graphismes, logo, marque KIEL, photographies, vidéos, bases de données, procédés décrits) est protégé par le droit d’auteur, le droit des marques et, le cas échéant, les titres OAPI. Toute reproduction, représentation, modification ou exploitation non autorisée, totale ou partielle, est interdite.</p>

<h2>Crédits visuels</h2>
<p>Photographies et visuels : KIEL INDUSTRIES, filière Borgou, sauf mention contraire. Icônes et filigranes baobab : charte graphique KIEL.</p>

<h2>Partenaires cités</h2>
<p>OAPI, PAVRIB, Land Accelerator et autres partenaires institutionnels mentionnés le sont avec leur accord ou dans un cadre public d’information.</p>

<h2>Limitation de responsabilité</h2>
<p>KIEL INDUSTRIES s’efforce d’assurer l’exactitude des informations publiées. Toutefois, des erreurs ou omissions peuvent subsister. L’utilisateur reconnaît utiliser le site sous sa responsabilité exclusive.</p>

<h2>Liens hypertextes</h2>
<p>Les liens vers des sites tiers n’engagent pas la responsabilité éditoriale de KIEL INDUSTRIES quant à leur contenu.</p>

<h2>Contact</h2>
<p>Pour toute question relative aux mentions légales : <a href="mailto:kielbienetre@gmail.com">kielbienetre@gmail.com</a> ou via la page <a href="/contact">Contact</a>.</p>
HTML,
        ];
    }

    /** @return array<string, mixed> */
    private function politiqueConfidentialite(): array
    {
        return [
            'slug' => 'politique-confidentialite',
            'title' => 'Politique de confidentialité',
            'lead' => 'Transparence sur la collecte, l’usage, la conservation et vos droits concernant vos données personnelles.',
            'section' => 'legal',
            'hero_image' => 'assets/img/ressources/pourquoi.jpg',
            'meta_title' => 'Politique de confidentialité — KIEL INDUSTRIES',
            'meta_description' => 'Données personnelles, cookies, commandes boutique, droits RGPD et contact DPO KIEL à Parakou, Bénin.',
            'meta_keywords' => 'confidentialité, données personnelles, cookies, KIEL, boutique Bénin',
            'body' => <<<'HTML'
<h2>Responsable du traitement</h2>
<p><strong>KIEL INDUSTRIES</strong>, Parakou (Borgou, Bénin), est responsable des traitements décrits ci-dessous. Contact données personnelles : <a href="mailto:kielbienetre@gmail.com">kielbienetre@gmail.com</a>.</p>

<h2>Données collectées</h2>
<ul>
<li><strong>Compte client :</strong> nom, e-mail, téléphone, adresse, ville, photo de profil (optionnelle), identifiant Google le cas échéant.</li>
<li><strong>Commande :</strong> coordonnées de livraison, historique d’achats, montants, références produits, notes de livraison.</li>
<li><strong>Contact &amp; partenariats :</strong> identité, e-mail, message, objet de la demande.</li>
<li><strong>Navigation :</strong> journaux techniques (adresse IP, horodatage, user-agent) pour la sécurité et la maintenance.</li>
<li><strong>Boutique :</strong> contenu du panier (stockage local navigateur + session serveur lors du checkout).</li>
</ul>

<h2>Finalités et bases légales</h2>
<ul>
<li>Exécution du contrat (commande, livraison, facturation, service après-vente).</li>
<li>Intérêt légitime (sécurité du site, amélioration de l’expérience, statistiques agrégées).</li>
<li>Consentement lorsque requis (newsletter ou cookies non essentiels, si activés ultérieurement).</li>
<li>Obligations légales (comptabilité, réponses aux autorités).</li>
</ul>

<h2>Destinataires</h2>
<p>Personnel habilité KIEL INDUSTRIES, prestataires techniques (hébergement, e-mail transactionnel), transporteurs pour la livraison. Aucune revente de données à des tiers à des fins commerciales.</p>

<h2>Durées de conservation</h2>
<ul>
<li>Compte client : tant que le compte est actif, puis archivage selon obligations légales.</li>
<li>Commandes : durée comptable et commerciale applicable au Bénin (generally 10 ans pour pièces comptables).</li>
<li>Messages contact : 24 mois après clôture du dossier, sauf litige.</li>
<li>Journaux serveur : 12 mois maximum.</li>
</ul>

<h2>Sécurité</h2>
<p>Mesures organisationnelles et techniques : accès restreint, mots de passe hashés, HTTPS en production, sauvegardes régulières. Aucune transmission n’est totalement inviolable ; nous appliquons le principe de minimisation des données.</p>

<h2>Vos droits</h2>
<p>Accès, rectification, effacement, limitation, opposition, portabilité lorsque applicable. Pour exercer vos droits : <a href="mailto:kielbienetre@gmail.com">kielbienetre@gmail.com</a> avec une copie d’identité si nécessaire. Réclamation possible auprès de l’autorité de protection des données compétente au Bénin.</p>

<h2>Cookies</h2>
<p>Cookies strictement nécessaires : session Laravel, panier, préférences de devise, authentification. Pas de publicité ciblée par défaut. Toute évolution (analytics, réseaux sociaux) fera l’objet d’un bandeau d’information et, si besoin, d’un consentement.</p>

<h2>Transferts hors du Bénin</h2>
<p>Certains prestataires (e-mail, hébergement cloud) peuvent traiter des données hors du territoire. Des garanties contractuelles appropriées sont recherchées.</p>

<h2>Mineurs</h2>
<p>Le site ne vise pas les moins de 16 ans sans autorisation parentale pour toute commande.</p>

<h2>Conditions de vente</h2>
<p>Les achats sur la boutique sont également régis par nos <a href="/conditions-generales">conditions générales de vente (CGV)</a>.</p>
HTML,
        ];
    }

    /** @return array<string, mixed> */
    private function conditionsGenerales(): array
    {
        return [
            'slug' => 'conditions-generales',
            'title' => 'Conditions générales de vente',
            'lead' => 'CGV applicables aux commandes passées sur la boutique KIEL INDUSTRIES et aux relations commerciales associées.',
            'section' => 'legal',
            'hero_image' => 'assets/img/galleries/3.png',
            'meta_title' => 'CGV — Conditions générales de vente KIEL INDUSTRIES',
            'meta_description' => 'Prix FCFA, commande, livraison Bénin et international, paiement, rétractation, garanties et litiges KIEL INDUSTRIES.',
            'meta_keywords' => 'CGV, conditions vente, KIEL, boutique baobab, livraison Bénin',
            'body' => <<<'HTML'
<h2>1. Objet et champ d’application</h2>
<p>Les présentes conditions générales de vente (CGV) régissent les ventes de produits KIEL INDUSTRIES via le site vitrine et la boutique en ligne, ainsi que les échanges commerciaux associés (B2C et, sur devis, B2B). Toute commande implique l’acceptation sans réserve des CGV en vigueur à la date de la commande.</p>

<h2>2. Vendeur</h2>
<p><strong>KIEL INDUSTRIES</strong> — Parakou, Borgou, Bénin — IFU 0201710192397 — <a href="mailto:kielbienetre@gmail.com">kielbienetre@gmail.com</a> — <a href="tel:+2290165728584">+229 0165728584</a>.</p>

<h2>3. Produits</h2>
<p>Les produits (nutrition, cosmétique, artisanat, coffrets) sont décrits sur les fiches produit. Les visuels sont illustratifs ; des variations naturelles liées au baobab, à la récolte ou au conditionnement peuvent exister sans affecter la qualité contractuelle.</p>

<h2>4. Prix</h2>
<p>Les prix sont indiqués en <strong>FCFA</strong> par défaut, avec affichage indicatif en EUR/USD selon le sélecteur de devise. Ils s’entendent hors frais de livraison sauf mention contraire. KIEL INDUSTRIES peut modifier ses tarifs ; le prix applicable est celui confirmé au moment de l’enregistrement de la commande.</p>

<h2>5. Commande</h2>
<p>Le client sélectionne les produits, valide le panier et renseigne les informations de livraison. L’enregistrement de la commande vaut offre d’achat. KIEL INDUSTRIES confirme la prise en charge par e-mail (référence commande). La disponibilité des stocks est indiquée de bonne foi ; en cas d’indisponibilité, le client est contacté pour un remplacement ou un remboursement.</p>

<h2>6. Compte client</h2>
<p>La création d’un compte est requise pour finaliser une commande en ligne et suivre l’historique. Le client est responsable de la confidentialité de ses identifiants.</p>

<h2>7. Paiement</h2>
<p>Les moyens de paiement en ligne (Mobile Money, carte, etc.) seront activés progressivement. Jusqu’à leur mise en service, la commande peut être enregistrée et le paiement convenu avec l’équipe KIEL (virement, espèces à la livraison, etc.) selon les modalités communiquées par e-mail. Aucune donnée bancaire complète n’est stockée sur les serveurs KIEL au-delà de ce que le prestataire de paiement certifié exige.</p>

<h2>8. Livraison</h2>
<p>Livraison au Bénin (Parakou, Cotonou, autres villes) et à l’international selon destination et transporteur. Les délais sont indicatifs et communiqués lors de la confirmation. Les frais de port sont calculés au checkout (offre fréquente au-delà d’un seuil de commande en FCFA). Le risque de perte ou avarie est transféré à la réception par le client ou un tiers mandaté.</p>

<h2>9. Droit de rétractation et retours</h2>
<p>Pour les ventes à distance, le consommateur dispose d’un délai de rétractation conforme au droit béninois applicable, sauf exceptions légales (produits périssables ou personnalisés). Les retours doivent être signalés sous 14 jours après réception pour tout produit non conforme ou endommagé. Les produits alimentaires ouverts peuvent être exclus pour des raisons d’hygiène.</p>

<h2>10. Garanties</h2>
<p>KIEL INDUSTRIES garantit la conformité des produits aux descriptions et aux normes d’hygiène en vigueur. En cas de défaut avéré, remplacement ou remboursement après examen du lot concerné.</p>

<h2>11. Responsabilité</h2>
<p>La responsabilité de KIEL INDUSTRIES est limitée au montant de la commande, sauf faute lourde ou dol. KIEL n’est pas responsable des dommages indirects (perte d’exploitation, etc.).</p>

<h2>12. Force majeure</h2>
<p>Événements indépendants de la volonté des parties (catastrophe, grève, rupture d’approvisionnement majeure) suspendent les obligations sans indemnité.</p>

<h2>13. Données personnelles</h2>
<p>Traitement des données conformément à la <a href="/politique-de-confidentialite">politique de confidentialité</a>.</p>

<h2>14. Litiges</h2>
<p>Les parties privilégient une résolution amiable. À défaut, les tribunaux compétents du Bénin sont seuls compétents, sous réserve des règles impératives de protection du consommateur.</p>

<h2>15. Médiation</h2>
<p>Le client consommateur peut recourir, le cas échéant, à un médiateur de la consommation agréé, dont les coordonnées seront communiquées sur demande.</p>
HTML,
        ];
    }

    /** @return array<string, mixed> */
    private function conditionsUtilisation(): array
    {
        return [
            'slug' => 'conditions-utilisation',
            'title' => 'Conditions d\'utilisation',
            'lead' => 'Règles d\'accès et d\'usage du site vitrine et des services en ligne KIEL INDUSTRIES.',
            'section' => 'legal',
            'hero_image' => 'assets/img/banners/fond-vect.jpg',
            'meta_title' => 'Conditions d\'utilisation — Site KIEL INDUSTRIES',
            'meta_description' => 'Accès au site, compte utilisateur, propriété intellectuelle, responsabilité et droit applicable pour kiel-industries.',
            'meta_keywords' => 'conditions utilisation, site web, KIEL INDUSTRIES, Bénin',
            'body' => <<<'HTML'
<h2>1. Objet</h2>
<p>Les présentes conditions d'utilisation régissent l'accès et l'utilisation du site internet édité par <strong>KIEL INDUSTRIES</strong> (Parakou, Borgou, Bénin), incluant les pages vitrine, la boutique en ligne, l'espace compte client et les formulaires de contact.</p>

<h2>2. Acceptation</h2>
<p>En naviguant sur le site, vous acceptez ces conditions. Si vous n'êtes pas d'accord, veuillez ne pas utiliser le site. Les achats sont en outre soumis aux <a href="/conditions-generales">conditions générales de vente (CGV)</a>.</p>

<h2>3. Accès au site</h2>
<p>KIEL INDUSTRIES s'efforce d'assurer la disponibilité du site. Des interruptions (maintenance, mise à jour, force majeure) peuvent survenir sans préavis. L'accès peut être suspendu en cas d'usage abusif ou contraire à la loi.</p>

<h2>4. Compte utilisateur</h2>
<p>La création d'un compte peut être requise pour commander ou laisser un avis produit. Vous vous engagez à fournir des informations exactes et à préserver la confidentialité de vos identifiants. KIEL INDUSTRIES peut suspendre ou supprimer un compte en cas de fraude, de contenu illicite ou de non-respect des présentes conditions.</p>

<h2>5. Usage autorisé</h2>
<p>Le site est destiné à informer sur la filière baobab KIEL, à consulter le catalogue et à passer commande dans le respect de la réglementation. Sont interdits : extraction automatisée massive de contenus, tentative d'intrusion, diffusion de virus, usurpation d'identité, contenus diffamatoires ou portant atteinte aux droits de tiers.</p>

<h2>6. Propriété intellectuelle</h2>
<p>Textes, images, logo, marque KIEL, mise en page et bases de données sont protégés. Toute reproduction, représentation ou exploitation non autorisée est interdite. Les liens vers le site sont autorisés sans framing ni dénigrement.</p>

<h2>7. Contenus utilisateurs</h2>
<p>Les avis et messages que vous publiez doivent être loyaux, pertinents et conformes à la loi. KIEL INDUSTRIES se réserve le droit de modérer ou supprimer tout contenu inapproprié.</p>

<h2>8. Données personnelles</h2>
<p>Le traitement des données est décrit dans la <a href="/politique-de-confidentialite">politique de confidentialité</a>.</p>

<h2>9. Responsabilité</h2>
<p>Les informations du site sont fournies à titre indicatif. KIEL INDUSTRIES ne garantit pas l'absence totale d'erreurs ou d'omissions. La responsabilité de KIEL INDUSTRIES est limitée aux dommages directs prouvés, dans la mesure permise par le droit applicable.</p>

<h2>10. Liens externes</h2>
<p>Le site peut contenir des liens vers des sites tiers ; KIEL INDUSTRIES n'exerce aucun contrôle sur leur contenu et décline toute responsabilité à leur égard.</p>

<h2>11. Droit applicable</h2>
<p>Les présentes conditions sont régies par le droit béninois. En cas de litige, les parties recherchent une solution amiable avant toute action judiciaire compétente au Bénin.</p>

<h2>12. Contact</h2>
<p>Questions relatives à ces conditions : <a href="mailto:kielbienetre@gmail.com">kielbienetre@gmail.com</a> ou via la page <a href="/contact">Contact</a>.</p>
HTML,
        ];
    }

    /** @return array<string, mixed> */
    private function pageContact(): array
    {
        return [
            'slug' => 'page-contact',
            'title' => 'Contact',
            'lead' => 'Siège à Parakou, équipe boutique et partenariats B2B.',
            'section' => 'content',
            'hero_image' => 'assets/img/ressources/partenariat.png',
            'meta_title' => 'Contact KIEL INDUSTRIES — Parakou',
            'meta_description' => 'Contactez KIEL pour la boutique, les partenariats et les visites de la filière baobab au Borgou.',
            'body' => '<p>Utilisez le formulaire de la page contact ou écrivez à <a href="mailto:kielbienetre@gmail.com">kielbienetre@gmail.com</a>.</p>',
        ];
    }

    /** @return array<string, mixed> */
    private function pagePartenaire(): array
    {
        return [
            'slug' => 'page-partenaire',
            'title' => 'Devenir partenaire',
            'lead' => 'Institutions, distributeurs, coopératives : construisons la filière baobab.',
            'section' => 'content',
            'hero_image' => 'assets/img/ressources/partenariat.png',
            'meta_title' => 'Partenariat KIEL INDUSTRIES',
            'meta_description' => 'Partenariats institutionnels, R&D et filière baobab au Bénin avec KIEL INDUSTRIES.',
            'body' => '<p>Formulaire partenaire sur la page dédiée du site.</p>',
        ];
    }
}
