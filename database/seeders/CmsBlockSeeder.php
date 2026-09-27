<?php

namespace Database\Seeders;

use App\Models\CmsBlock;
use Illuminate\Database\Seeder;

class CmsBlockSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->definitions() as $key => $def) {
            CmsBlock::query()->updateOrCreate(
                ['key' => $key],
                [
                    'group' => explode('.', $key)[0],
                    'label' => $def['label'],
                    'type' => $def['type'],
                    'content' => $def['type'] === 'json'
                        ? json_encode($def['value'], JSON_UNESCAPED_UNICODE)
                        : (string) $def['value'],
                ]
            );
        }
    }

    /** @return array<string, array{label: string, type: string, value: mixed}> */
    private function definitions(): array
    {
        $fields = config('cms-groups', []);
        $map = [];
        foreach ($fields as $group => $meta) {
            foreach ($meta['fields'] as $key => $field) {
                $map[$key] = [
                    'label' => $field['label'],
                    'type' => $field['type'],
                    'value' => $this->defaultFor($key, $field['type']),
                ];
            }
        }

        return $map;
    }

    private function defaultFor(string $key, string $type): mixed
    {
        $defaults = $this->defaultValues();

        return $defaults[$key] ?? ($type === 'json' ? [] : '');
    }

    /** @return array<string, mixed> */
    private function defaultValues(): array
    {
        return [
            'home.hero.eyebrow' => 'KIEL Industries · Siège Parakou, Bénin · IFU 0201710192397',
            'home.hero.title' => 'Restaurer les paysages, valoriser le baobab&nbsp;: commandez la marque KIEL, de Parakou à votre table.',
            'home.hero.lead' => 'Marque KIEL : poudres de feuilles et de pulpe, café, whisky et biscuits de baobab, huile, baume, pommade, artisanat. Économie circulaire, brevet d’invention, restauration des terres et emplois verts au Borgou. <strong class="text-white font-semibold opacity-95">Boutique en ligne · commandes · livraison.</strong>',
            'home.hero.video_poster' => 'assets/img/ressources/home-1.png',
            'home.hero.cta_primary' => 'Commander en ligne',
            'home.hero.cta_secondary' => 'Découvrir la boutique',
            'home.partners.title' => 'Ils nous soutiennent',
            'home.manifeste.title' => 'KIEL Industries',
            'home.manifeste.p1' => '<strong class="text-secondary font-semibold">KIEL Industries</strong> est une entreprise béninoise qui restaure les paysages par le baobab et en assure la <strong class="text-secondary font-semibold">valorisation intégrale</strong> selon un modèle d’économie circulaire, via la marque <strong class="text-secondary font-semibold">KIEL</strong>.',
            'home.manifeste.p2' => 'Nous transformons chaque composante du baobab en produits alimentaires, cosmétiques et artisanaux à forte valeur ajoutée, tout en restaurant les terres dégradées, en améliorant la nutrition et en créant des opportunités économiques durables pour les femmes rurales. L’une de nos innovations est protégée par un <strong class="text-primary font-medium">brevet d’invention</strong>, symbole de notre engagement zéro déchet et de l’innovation africaine.',
            'home.manifeste.p3' => '<strong class="text-primary font-medium">Mission&nbsp;:</strong> développer une chaîne de valeur durable autour du baobab qui restaure les terres dégradées, lutte contre la malnutrition, crée des emplois verts, autonomise les femmes rurales et transforme localement les ressources naturelles en produits innovants à haute valeur ajoutée.',
            'home.manifeste.img1' => 'assets/img/ressources/home-1.png',
            'home.manifeste.img2' => 'assets/img/ressources/home-2.png',
            'home.manifeste.img3' => 'assets/img/ressources/home-3.png',
            'home.catalogue.title' => 'La gamme KIEL INDUSTRIES, alimentation, soins & artisanat',
            'home.catalogue.lead' => 'Produits de la boutique KIEL : fiches détaillées, panier en ligne et confirmation par e-mail (paiement en ligne prochainement).',
            'home.discover.title' => 'Baobab, terres restaurées & bien-être, notre histoire à Parakou.',
            'home.discover.lead' => 'De la savane du Borgou aux ateliers de Parakou : une filière intégrée au service du vivant.',
            'home.stats.title' => 'KIEL INDUSTRIES EN CHIFFRES',
            'home.stats.items' => [
                ['num' => '500+', 'label' => 'Productrices mobilisées au Borgou'],
                ['num' => '100 %', 'label' => 'Valorisation zéro déchet du fruit'],
                ['num' => '4', 'label' => 'Domaines d’intervention KIEL'],
                ['num' => '1', 'label' => 'Brevet d’invention · innovation locale'],
            ],
            'home.faq.title' => 'Questions fréquentes',
            'home.faq.lead' => 'Baobab, commandes, livraison et engagements KIEL Industries.',
            'home.faq.items' => [
                ['q' => 'Comment passer commande sur la boutique ?', 'a' => 'Choisissez vos produits, ajustez la quantité puis ajoutez au panier. Finalisez depuis l’icône panier en haut de page.'],
                ['q' => 'Le paiement en ligne est-il disponible ?', 'a' => 'Vous pouvez enregistrer votre commande et recevoir un e-mail de confirmation. Le paiement Mobile Money et par carte sera activé prochainement ; notre équipe vous contacte si besoin.'],
                ['q' => 'Livrez-vous au Bénin et à l’international ?', 'a' => 'Oui. Livraison au Bénin et expédition selon destination et stock.'],
                ['q' => 'D’où viennent vos matières premières ?', 'a' => 'Récolte raisonnée au Borgou et Alibori, transformation à Parakou sous contrôle qualité KIEL.'],
            ],
            'home.gallery.title' => 'Galerie de KIEL INDUSTRIES',
            'home.gallery.lead' => 'Survolez pour un aperçu, cliquez pour ouvrir la fiche photo.',
            'home.gallery.items' => [
                ['file' => '1.png', 'tag' => 'Terroir', 'title' => 'Savane et baobabs du Borgou', 'short' => 'Paysages de récolte et restauration écologique.', 'desc' => 'Peuplements de baobab au Borgou, au cœur de la mission de restauration des terres de KIEL INDUSTRIES.', 'caption' => 'Savane & baobabs'],
                ['file' => '2.png', 'tag' => 'Impact social', 'title' => 'Femmes productrices', 'short' => 'Coopératives partenaires au Borgou.', 'desc' => 'Les femmes rurales sont au centre de la chaîne KIEL INDUSTRIES.', 'caption' => 'Femmes productrices'],
                ['file' => '3.png', 'tag' => 'Cosmétique', 'title' => 'Huile pure de baobab', 'short' => 'Première pression, traçabilité Parakou.', 'desc' => 'Huile de baobab issue de la filière locale, pressée et conditionnée à Parakou.', 'caption' => 'Huile pure de baobab'],
                ['file' => '4.png', 'tag' => 'Nutrition', 'title' => 'Poudre de feuilles', 'short' => 'Super-aliment, récolte Borgou.', 'desc' => 'Feuilles de baobab séchées et moulues, riches en nutriments.', 'caption' => 'Poudre de feuilles'],
            ],
            'about.hero.title' => 'À propos de KIEL INDUSTRIES',
            'about.hero.lead' => 'KIEL INDUSTRIES & KIEL BIEN-ÊTRE — Parakou, Bénin · IFU 0201710192397 · valorisation du baobab en économie circulaire.',
            'about.intro.title' => 'Restaurer les paysages, valoriser le baobab',
            'about.intro.body' => 'KIEL INDUSTRIES est une entreprise béninoise spécialisée dans la restauration des paysages à travers le baobab et sa valorisation intégrale selon un modèle d’économie circulaire. Le site présente KIEL BIEN-ÊTRE, notre histoire, notre équipe, nos activités (production, conseil nutritionnel, gestion de projets, mentorat), notre approche circulaire, nos innovations brevetées et nos engagements sociaux et environnementaux.',
            'about.intro.img_top' => 'assets/img/sections/about/about-1.jpg',
            'about.intro.img_bottom' => 'assets/img/sections/about/about-3.jpg',
            'about.highlights' => [
                ['icon' => 'lightbulb', 'title' => 'Innovation', 'text' => 'Brevet d’invention et R&D au service du baobab africain.'],
                ['icon' => 'verified', 'title' => 'Qualité', 'text' => 'Traçabilité de la récolte au produit fini à Parakou.'],
                ['icon' => 'recycling', 'title' => 'Économie circulaire', 'text' => 'Zéro déchet, valorisation locale et respect de l’environnement.'],
                ['icon' => 'groups', 'title' => 'Femmes rurales & emplois', 'text' => 'Autonomisation économique et création d’emplois verts au Borgou.'],
            ],
            'about.mission.title' => 'Pourquoi KIEL INDUSTRIES existe',
            'about.mission.lead' => 'Une chaîne de valeur durable autour du baobab : restauration écologique, prospérité locale et résilience des communautés rurales.',
            'about.mission.cards' => [
                ['icon' => 'flag', 'title' => 'Mission', 'text' => 'Développer une chaîne de valeur durable autour du baobab qui restaure les terres dégradées, lutte contre la malnutrition, crée des emplois verts, autonomise les femmes rurales et transforme localement les ressources naturelles en produits innovants à haute valeur ajoutée.'],
                ['icon' => 'visibility', 'title' => 'Vision', 'text' => 'Construire une Afrique où le baobab devient moteur de restauration écologique, de prospérité économique, de sécurité alimentaire et de résilience climatique pour les communautés rurales.'],
                ['icon' => 'star', 'title' => 'Particularités', 'text' => 'KIEL INDUSTRIES est l’une des rares entreprises africaines à intégrer restauration des terres, économie circulaire zéro déchet, lutte contre la malnutrition, autonomisation des femmes rurales, innovation brevetée et création d’emplois verts dans un même modèle.'],
            ],
            'about.timeline.title' => 'Nous suivons une chaîne exigeante, de la récolte à votre table',
            'about.timeline.lead' => 'Quatre étapes clés avec les dates marquantes de KIEL INDUSTRIES au Borgou.',
            'about.timeline.steps' => [
                ['year' => '2018', 'title' => 'Ateliers Parakou', 'text' => 'Transformation locale, emplois verts et contrôle qualité sur chaque lot.', 'image' => 'assets/img/ressources/directrice.jpeg'],
                ['year' => '2016', 'title' => 'Récolte & terroirs', 'text' => 'Coopératives au Borgou, récolte raisonnée et circuits courts.', 'image' => 'assets/img/sections/decouvre/decouvre-1.jpg'],
                ['year' => '2021', 'title' => 'Chaîne circulaire', 'text' => 'Pulpe, feuilles, graines et coques valorisées sans gaspillage.', 'image' => 'assets/img/sections/decouvre/decouvre-2.jpg'],
                ['year' => '2025', 'title' => 'Qualité & livraison', 'text' => 'Traçabilité, boutique en ligne et partenaires OAPI & PAVRIB.', 'image' => 'assets/img/sections/about/about-1.jpg'],
            ],
            'about.team.title' => 'Des talents au cœur de la filière',
            'about.team.lead' => 'Direction et équipes de terrain à Parakou, au service de la filière baobab.',
            'about.team.members' => [
                ['first_name' => 'Célia', 'last_name' => 'Chabi', 'role' => 'Présidente directrice générale', 'photo' => 'assets/img/ressources/directrice.jpeg'],
            ],
            'about.faq.title' => 'Questions sur KIEL INDUSTRIES',
            'about.faq.lead' => 'Filière baobab, impact social, boutique et partenariats : les réponses essentielles.',
            'about.faq.items' => [
                ['q' => 'Quelle est la spécificité de KIEL au Borgou ?', 'a' => 'KIEL INDUSTRIES intègre la récolte, la transformation à Parakou et la commercialisation autour du baobab, avec un fort ancrage social auprès des femmes rurales.'],
                ['q' => 'Vos innovations sont-elles protégées ?', 'a' => 'Oui. Une partie de nos procédés est protégée par un brevet OAPI.'],
                ['q' => 'Comment visiter vos ateliers ?', 'a' => 'Visites sur rendez-vous à Parakou via le formulaire de contact.'],
                ['q' => 'Puis-je devenir distributeur ou partenaire B2B ?', 'a' => 'Oui. Déposez votre demande sur la page Partenaire.'],
            ],
            'about.director.title' => 'Une filière baobab guidée par la preuve et le terrain',
            'about.director.quote' => '«&nbsp;Nous ne prélevons pas la nature : nous célébrons une alliance entre le savoir ancestral du Borgou et l’ingénierie verte. Chaque lot est une promesse de transparence pour nos clientes, nos partenaires et les femmes qui portent la filière.&nbsp;»',
            'about.director.name' => 'Célia Chabi',
            'about.director.role' => 'Présidente directrice générale · KIEL INDUSTRIES',
            'about.director.image' => 'assets/img/ressources/directrice.jpeg',
            'about.zero.title' => '100&nbsp;% de la gousse valorisée, zéro brûlis, zéro perte.',
            'about.zero.lead' => 'Notre cycle de traitement mécano-chimique breveté transforme l’arbre sans prédation. Le fruit est scindé en quatre flux d’excellence, chacun valorisé sur des filières nutrition, cosmétique, artisanat ou agronomie.',
            'about.zero.flows' => [
                ['pct' => '45 %', 'text' => 'Pulpe énergétique — vitamines C, calcium et fibres.'],
                ['pct' => '32 %', 'text' => 'Graines pressées — huile vierge cosmétique.'],
                ['pct' => '11 %', 'text' => 'Coques dures — éco-artisanat circulaire.'],
                ['pct' => '12 %', 'text' => 'Filaments & tourteaux — compost régénératif.'],
            ],
            'about.zero.tandem_title' => 'Du Borgou aux ateliers de Parakou',
            'about.zero.tandem_text' => 'Les productrices partenaires du Borgou et l’équipe KIEL INDUSTRIES à Parakou assurent récolte raisonnée, contrôle qualité et transformation locale pour des produits traçables.',
            'about.zero.tandem_img1' => 'assets/img/sections/about/about-2.jpg',
            'about.zero.tandem_img2' => 'assets/img/sections/about/about-3.jpg',
            'contact.hero.title' => 'Contactez KIEL INDUSTRIES',
            'contact.hero.lead' => 'Boutique, partenariats B2B, conseil nutritionnel ou visite à Parakou : nous vous répondons rapidement.',
            'contact.coords.title' => 'Nos coordonnées',
            'contact.coords.lead' => 'Siège et ateliers au Borgou. Boutique en ligne livrée au Bénin et à l’international.',
            'contact.phone' => '+229 0165728584',
            'contact.email' => 'kielbienetre@gmail.com',
            'contact.address' => 'Parakou, Borgou, Bénin',
            'contact.form.title' => 'Envoyer un message',
            'contact.form.lead' => 'Le formulaire ouvre votre client mail avec le message prérempli.',
            'contact.visual_image' => 'assets/img/sections/about/about-1.jpg',
            'contact.map.title' => 'Nous trouver à Parakou',
            'contact.map.lead' => 'Siège et ateliers au Borgou. Prenez rendez-vous pour une visite de la filière baobab KIEL.',
            'partner.hero.title' => 'Faites grandir la filière baobab avec KIEL',
            'partner.hero.lead' => 'Distributeurs, industriels, ONG, institutions : co-construisons des projets à impact — du vrac B2B aux programmes nutritionnels.',
            'partner.types' => [
                ['icon' => 'storefront', 'title' => 'Distribution & retail', 'text' => 'Boutiques, e-commerce, GMS — gamme KIEL et exclusivités régionales.'],
                ['icon' => 'factory', 'title' => 'Industrie & vrac B2B', 'text' => 'Fûts 200 L, tonnes de matières premières — cotations sur demande.'],
                ['icon' => 'volunteer_activism', 'title' => 'Projets & institutions', 'text' => 'Nutrition, restauration des terres, programmes femmes rurales.'],
            ],
            'partner.form.title' => 'Proposer un partenariat',
            'partner.form.lead' => 'Décrivez votre organisation et votre projet — l’équipe KIEL INDUSTRIES vous recontacte sous 48 h ouvrées.',
            'partner.image' => 'assets/img/ressources/partenariat.png',
            'partner.quote' => '« Chaque partenariat renforce les productrices du Borgou et la restauration des terres. »',
        ];
    }
}
