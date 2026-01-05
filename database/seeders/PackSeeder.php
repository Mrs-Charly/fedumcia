<?php

namespace Database\Seeders;

use App\Models\Pack;
use Illuminate\Database\Seeder;

class PackSeeder extends Seeder
{
    public function run(): void
    {
        $packs = [
            [
                'name' => 'Pack Start',
                'slug' => 'start',
                'price_eur' => 200,
                'tagline' => "L'essentiel pour être visible",
                'short_description' => "La base indispensable pour une image propre et rassurante.",
                'details' => implode("\n", [
                    "Gestion & Optimisation du Site Web :",
                    "- SEO : optimisation technique pour être trouvé sur Google",
                    "- Mise à jour visuelle : intégration de nouveaux visuels",
                    "- Maintenance technique : navigation fluide et site à jour",
                    "",
                    "Animation des Réseaux Sociaux :",
                    "- 8 publications/mois (Instagram & Facebook)",
                    "- Création de posts + légendes",
                    "",
                    "Maîtrise de votre E-Réputation :",
                    "- Veille Google Business Profile",
                    "- Réponse aux avis sous 48h",
                    "- Modération des commentaires indésirables",
                ]),
                'posts_per_month' => 8,
                'review_response_hours' => 48,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Pack Croissance',
                'slug' => 'croissance',
                'price_eur' => 500,
                'tagline' => 'Le booster de notoriété',
                'short_description' => "Passez au niveau supérieur et devancez vos concurrents.",
                'details' => implode("\n", [
                    "Tout le Pack Start +",
                    "",
                    "Performance Web Avancée :",
                    "- Analyse plus poussée des mots-clés",
                    "- Optimisation des pages pour convertir les visiteurs",
                    "- SEO local renforcé",
                    "",
                    "Présence Sociale Renforcée :",
                    "- 12 publications/mois",
                    "- Formats vidéo (Reels) selon besoin",
                    "- Plus d’interactions avec la communauté",
                    "",
                    "Réactivité Maximale :",
                    "- Réponse aux avis sous 24h",
                    "- Mise en place d’un système pour booster les avis positifs",
                ]),
                'posts_per_month' => 12,
                'review_response_hours' => 24,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Pack Premium',
                'slug' => 'premium',
                'price_eur' => 800,
                'tagline' => "L'armure digitale",
                'short_description' => "Une maîtrise complète de votre image en ligne.",
                'details' => implode("\n", [
                    "Tout le Pack Croissance +",
                    "",
                    "Exposition du Web :",
                    "- Gestion totale du site avec contenu stratégique",
                    "- Surveillance de l’image de marque (web élargi)",
                    "",
                    "Omniprésence Digitale :",
                    "- 24 publications/mois",
                    "- Stratégie de storytelling (moyen/long terme)",
                    "",
                    "Service de Prestige & Gestion de Crise :",
                    "- Réponse aux avis et messages sous 12h",
                    "- Actions de traitement/signalement et limitation d’impact des avis malveillants",
                    "- Ligne directe avec vos conseillers Fedumcia",
                    "",
                    "Important : aucune suppression d’avis n’est garantie.",
                ]),
                'posts_per_month' => 24,
                'review_response_hours' => 12,
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($packs as $data) {
            Pack::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
