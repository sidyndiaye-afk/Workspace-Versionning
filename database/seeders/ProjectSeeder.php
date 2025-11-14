<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->projects() as $project) {
            $contact = $project['contact'] ?? null;
            $storedContact = null;

            if ($contact) {
                $email = $contact['email'] ?? $this->fallbackEmail($contact['name']);

                User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => $contact['name'],
                        'password' => Hash::make('password'),
                        'is_admin' => true,
                    ]
                );

                $storedContact = array_merge($contact, ['email' => $email]);
            }

            Project::updateOrCreate(
                ['slug' => $project['slug']],
                [
                    'title' => $project['title'],
                    'slug' => $project['slug'],
                    'status' => $project['status'],
                    'start_date' => $project['start_date'] ?? null,
                    'end_date' => $project['end_date'] ?? null,
                    'cover_image' => $project['cover_image'] ?? null,
                    'objectif' => $project['objectif'] ?? null,
                    'intro' => $project['intro'] ?? null,
                    'youtube_id' => $project['youtube_id'] ?? null,
                    'files_note' => $project['files_note'] ?? null,
                    'contact' => $storedContact,
                    'news' => $project['news'] ?? null,
                    'timeline' => $project['timeline'] ?? [],
                ]
            );
        }
    }

    private function fallbackEmail(string $name): string
    {
        $slug = Str::slug($name, '.');

        return $slug.'@levell.local';
    }

    /**
     * Manually transcribed from the Next.js data files.
     */
    private function projects(): array
    {
        return [
            [
                'slug' => 'spot-sama-naweet',
                'title' => 'Spot Sama Naweet',
                'status' => 'TERMINE',
                'start_date' => '2025-09-01',
                'end_date' => '2025-10-12',
                'cover_image' => '/media/onas-spot.jpg',
                'objectif' => <<<TEXT
Spot vidéo de sensibilisation ONAS pour éduquer les usagers aux bons comportements d’assainissement et aux comportements responsables.
TEXT,
                'intro' => <<<TEXT
Le spot publicitaire de l’ONAS a été réalisé dans un contexte hivernal exigeant, avec des équipes fortement mobilisées sur le terrain. Pour avancer efficacement, nous avons adopté une démarche proactive, tout en revisitant le scénario proposé par l’ONAS afin d’en renforcer la cohérence et l’impact visuel.
TEXT,
                'contact' => [
                    'name' => 'Paul Bernard Ndiaye',
                    'role' => 'Video Producer',
                    'phone' => '781560794',
                    'email' => 'paul.ndiaye@levellagency.com',
                    'avatarUrl' => '/media/photo_paul_square.jpg',
                ],
                'timeline' => [
                    [
                        'title' => 'Scénario',
                        'description' => "Écriture du concept et du message clé ONAS.",
                        'date' => 'début sept 2025',
                        'status' => 'completed',
                        'iconKey' => 'plan',
                        'done' => true,
                        'pdf' => '/media/Sama Naweet/Copie de Spot ONAS_Définitif Client.pdf',
                        'assets' => [
                            [
                                'type' => 'pdf',
                                'label' => 'Scénario final (PDF)',
                                'href' => '/media/Sama Naweet/Copie de Spot ONAS_Définitif Client.pdf',
                                'status' => 'prêt',
                            ],
                        ],
                        'narrativeBefore' => <<<TEXT
Nous avons d’abord travaillé sur le scénario, en définissant un fil conducteur clair et cohérent, capable de valoriser les missions et les réalisations de l’ONAS tout en restant accessible au grand public. Cette étape a permis d’établir le ton, le rythme et les messages clés de la vidéo.
TEXT,
                    ],
                    [
                        'title' => 'Tournage',
                        'description' => "Captation terrain avec les équipes ONAS et scènes d’usage réel.",
                        'date' => 'mi sept 2025',
                        'status' => 'completed',
                        'iconKey' => 'shoot',
                        'done' => true,
                        'narrativeBefore' => <<<TEXT
Nous sommes ensuite passés à la phase de tournage, réalisée sur plusieurs sites représentatifs des activités de l’ONAS. L’objectif était de capturer des images authentiques, dynamiques et illustratives du travail mené sur le terrain, en veillant à la qualité des prises de vue et à la cohérence visuelle avec l’identité de l’institution.
TEXT,
                        'imagesDisplay' => 'modal',
                        'imagesButtonLabel' => 'Voir les backstages',
                        'images' => [
                            '/media/Sama Naweet/Backstages/DSC05939.JPG',
                            '/media/Sama Naweet/Backstages/DSC05946.JPG',
                            '/media/Sama Naweet/Backstages/DSC05949.JPG',
                            '/media/Sama Naweet/Backstages/DSC05950.JPG',
                            '/media/Sama Naweet/Backstages/DSC05954.JPG',
                            '/media/Sama Naweet/Backstages/DSC05955.JPG',
                            '/media/Sama Naweet/Backstages/DSC05959.JPG',
                            '/media/Sama Naweet/Backstages/DSC05967.JPG',
                            '/media/Sama Naweet/Backstages/DSC05983.JPG',
                            '/media/Sama Naweet/Backstages/DSC06023.JPG',
                            '/media/Sama Naweet/Backstages/DSC06048.JPG',
                        ],
                    ],
                    [
                        'title' => 'Montage',
                        'description' => "Montage image/son, voix off, sous-titrage.",
                        'date' => 'fin sept 2025',
                        'status' => 'completed',
                        'iconKey' => 'montage',
                        'done' => true,
                        'narrativeBefore' => <<<TEXT
À partir de ce matériau, nous avons entamé la phase de montage, en combinant les séquences tournées avec des éléments graphiques, des animations et une bande sonore adaptée. Cette étape a permis de renforcer la narration et d’assurer une mise en valeur harmonieuse des contenus.
TEXT,
                    ],
                    [
                        'title' => 'Version finale',
                        'description' => "Intégration de l’identité ONAS et habillage graphique.",
                        'date' => 'début oct 2025',
                        'status' => 'completed',
                        'iconKey' => 'video',
                        'done' => true,
                        'youtubeId' => 'OoWkhQLAmp4',
                        'narrativeBefore' => <<<TEXT
Enfin, une version finale a été produite, intégrant les ajustements issus des retours de l’équipe de l’ONAS. Cette version reflète fidèlement la vision du projet : une vidéo institutionnelle moderne, engageante et alignée avec la nouvelle image de l’Office.
TEXT,
                    ],
                    [
                        'title' => 'Fichiers dispos',
                        'description' => "Export en plusieurs formats prêts diffusion.",
                        'date' => '12 oct 2025',
                        'status' => 'completed',
                        'iconKey' => 'delivery',
                        'done' => true,
                        'narrativeBefore' => <<<TEXT
Après validation, nous avons décliné le spot dans tous les formats attendus pour faciliter sa diffusion immédiate sur les canaux ONAS et les médias partenaires.
TEXT,
                    ],
                ],
            ],
            [
                'slug' => 'plan-digital-gamou',
                'title' => 'Plan digital Gamou',
                'status' => 'TERMINE',
                'start_date' => '2025-09-01',
                'end_date' => '2025-11-30',
                'cover_image' => '/media/Gamou/Onas-Meteo Template.webp',
                'objectif' => <<<TEXT
Conception du dispositif digital Gamou : objectifs, messages clés et feuille de route de production pour encadrer les livrables ONAS.
TEXT,
                'intro' => <<<TEXT
Le plan digital Gamou est né d’un diagnostic terrain mené avec les équipes ONAS pendant l’hivernage. Nous avons identifié les attentes des pèlerins, les problématiques d’assainissement et les moments de vérité à couvrir.

Cette page retrace les jalons du dispositif, des objectifs jusqu’à la mise en production des contenus. Chaque étape renvoie vers les livrables associés et les productions créatives ou vidéo qui en découlent.
TEXT,
                'contact' => [
                    'name' => 'Elhadji NDIAYE',
                    'role' => 'CEO Levell',
                    'phone' => '+221 776789212',
                    'email' => 'elhadji.ndiaye@levellagency.com',
                    'avatarUrl' => '/media/photo_elj.jpg',
                    'avatarObjectPosition' => 'top',
                ],
                'timeline' => [
                    [
                        'title' => 'Diagnostic & objectifs',
                        'description' => "Atelier ONAS x Levell pour cadrer les enjeux, cartographier les audiences clés et formaliser les objectifs de communication.",
                        'date' => 'sept 2025',
                        'status' => 'completed',
                        'iconKey' => 'analysis',
                        'anchorId' => 'kickoff-plan-digital-gamou',
                        'narrativeBefore' => <<<TEXT
Nous avons commencé par écouter les équipes ONAS (siège, délégation, terrain) afin de comprendre les attentes des pèlerins et des riverains. Ce diagnostic dégage les priorités de communication : information service, prévention et valorisation des actions terrain.
TEXT,
                    ],
                    [
                        'title' => 'Plan digital Gamou 2025',
                        'description' => "Objectifs, axes éditoriaux et rétroplanning de production consolidés dans un document unique partagé avec l’ONAS.",
                        'date' => 'oct 2025',
                        'status' => 'completed',
                        'iconKey' => 'plan',
                        'anchorId' => 'plan-digital-gamou-2025',
                        'narrativeBefore' => <<<TEXT
Le livrable synthétise les messages clés par audience, les temps forts à couvrir et la tonalité à adopter. Il sert de boussole pour les équipes créatives et vidéo.
TEXT,
                        'assets' => [
                            [
                                'type' => 'pdf',
                                'label' => 'Plan digital Gamou 2025',
                                'href' => '/media/Gamou/ONAS - Plan Digital Gamou 2025.pdf',
                                'status' => 'prêt',
                            ],
                            [
                                'type' => 'link',
                                'label' => 'Voir les créas issues du plan',
                                'href' => '/onas/projets/creas-gamou',
                                'status' => 'en ligne',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Cadre de production',
                        'description' => "Construction du rétroplanning de conception (formats, contenus, validations) et mise en place des rituels de suivi avec les équipes ONAS.",
                        'date' => 'oct 2025',
                        'status' => 'completed',
                        'iconKey' => 'roadmap',
                        'anchorId' => 'calendrier-activation-gamou',
                        'narrativeBefore' => <<<TEXT
Chaque temps fort (annonce, sensibilisation, bilan) est décliné en formats à produire, responsables et jalons de validation. Nous priorisons les supports utiles aux équipes terrain et aux créatifs chargés de la production.
TEXT,
                        'assets' => [
                            [
                                'type' => 'link',
                                'label' => 'Découvrir la campagne vidéo',
                                'href' => '/onas/projets/gamou',
                                'status' => 'en ligne',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Passage de relais créa & vidéo',
                        'description' => "Brief croisé des équipes créatives et vidéo pour produire les contenus Gamou (social, print, captation).",
                        'date' => 'nov 2025',
                        'status' => 'completed',
                        'iconKey' => 'creative',
                        'anchorId' => 'brief-crea-video-gamou',
                        'narrativeBefore' => <<<TEXT
Une fois le plan validé, nous travaillons main dans la main avec les équipes créatives et vidéo pour assurer la cohérence des livrables finaux.
TEXT,
                        'assets' => [
                            [
                                'type' => 'link',
                                'label' => 'Accéder aux créations Gamou',
                                'href' => '/onas/projets/creas-gamou',
                                'status' => 'à consulter',
                            ],
                            [
                                'type' => 'link',
                                'label' => 'Voir la vidéo Gamou',
                                'href' => '/onas/projets/gamou',
                                'status' => 'à visionner',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'creas-gamou',
                'title' => 'Créas Gamou',
                'status' => 'TERMINE',
                'start_date' => '2025-10-15',
                'end_date' => '2025-11-30',
                'cover_image' => '/media/Gamou/Onas-Gamou.webp',
                'objectif' => <<<TEXT
Centraliser les créations print & social issues du plan digital Gamou : moodboard, déclinaisons et fichiers sources prêts à diffuser.
TEXT,
                'intro' => <<<TEXT
Le plan digital a rapidement laissé place à une phase de création intense. Les visuels ci-dessous matérialisent la narration imaginée pour l’ONAS autour du Gamou.

Chaque étape réunit les assets validés ainsi que des liens directs vers le plan stratégique et la captation vidéo pour garder une vision 360° du dispositif.
TEXT,
                'contact' => [
                    'name' => 'Ousmane Manel FALL',
                    'role' => 'Directeur Artistique',
                    'phone' => '773478428',
                    'email' => 'ousmane.fall@levellagency.com',
                    'avatarUrl' => '/media/photo_ousmane.jpg',
                    'avatarObjectPosition' => 'top',
                ],
                'timeline' => [
                    [
                        'title' => 'Moodboard & intentions graphiques',
                        'description' => "Sélection d’univers visuels, tonalité iconographique et axes narratifs pour illustrer l’engagement ONAS pendant le Gamou.",
                        'date' => 'oct 2025',
                        'status' => 'completed',
                        'iconKey' => 'creative',
                        'anchorId' => 'moodboard-gamou',
                        'images' => [
                            '/media/Gamou/ONAS - Conseil Couvercle.webp',
                            '/media/Gamou/Onas-Latence.webp',
                            '/media/Gamou/Onas-Meteo Template.webp',
                        ],
                        'imagesDisplay' => 'modal',
                        'imagesButtonLabel' => 'Voir le moodboard',
                        'narrativeBefore' => <<<TEXT
Nous avons travaillé un univers modernisé qui reste institutionnel tout en donnant de la place aux gestes utiles et à l’action de l’ONAS sur le terrain.
TEXT,
                        'assets' => [
                            [
                                'type' => 'link',
                                'label' => 'Consulter le plan digital',
                                'href' => '/onas/projets/plan-digital-gamou',
                                'status' => 'en ligne',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Kit social media',
                        'description' => "Déclinaisons pour les formats story, feed, reels et publications informative destinées aux différents temps du Gamou.",
                        'date' => 'oct 2025',
                        'status' => 'completed',
                        'iconKey' => 'social',
                        'anchorId' => 'kit-social-gamou',
                        'images' => [
                            '/media/Gamou/Onas-Poubelle.webp',
                            '/media/Gamou/Onas-fosse septique.webp',
                            '/media/Gamou/Onas-Meteo.webp',
                            '/media/Gamou/Onas-Sensibilisation Mobile.webp',
                            '/media/Gamou/Onas-plaque vole.webp',
                        ],
                        'imagesDisplay' => 'modal',
                        'imagesButtonLabel' => 'Afficher le kit social media',
                        'narrativeBefore' => <<<TEXT
Chaque visuel décline un message de prévention ou d’information pratique : numéros d’urgence, consignes d’assainissement, météo, valorisation des équipes terrain.
TEXT,
                    ],
                    [
                        'title' => 'Fichiers sources & exports',
                        'description' => "Mise à disposition des PSD et exports haute définition pour faciliter les adaptations locales.",
                        'date' => 'oct 2025',
                        'status' => 'completed',
                        'iconKey' => 'goodies',
                        'anchorId' => 'fichiers-sources-gamou',
                        'narrativeBefore' => <<<TEXT
Les fichiers sources permettent aux équipes régionales ONAS de personnaliser les messages tout en restant alignées sur la charte.
TEXT,
                        'assets' => [
                            [
                                'type' => 'source',
                                'label' => 'Pack PSD Gamou',
                                'href' => '/media/Gamou/Sources/ONAS - NumerosUrgence.psd',
                                'status' => 'téléchargeable',
                            ],
                            [
                                'type' => 'source',
                                'label' => 'Sensibilisation mobile',
                                'href' => '/media/Gamou/Sources/Onas-Sensibilisation Mobile.psd',
                                'status' => 'téléchargeable',
                            ],
                            [
                                'type' => 'source',
                                'label' => 'Météo',
                                'href' => '/media/Gamou/Sources/Onas-Meteo.psd',
                                'status' => 'téléchargeable',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Coordination vidéo officielle',
                        'description' => "Passage de relais à l’équipe vidéo pour capter le Gamou et aligner le montage sur la direction artistique définie.",
                        'date' => 'nov 2025',
                        'status' => 'completed',
                        'iconKey' => 'video',
                        'anchorId' => 'coordination-video-gamou',
                        'narrativeBefore' => <<<TEXT
Les créations servent de guide à la captation : cadrages, messages forts, identité graphique. La vidéo s’inscrit dans cette même ligne narrative pour valoriser l’action de l’ONAS sur place.
TEXT,
                        'assets' => [
                            [
                                'type' => 'link',
                                'label' => 'Voir la campagne vidéo',
                                'href' => '/onas/projets/gamou',
                                'status' => 'à visionner',
                            ],
                            [
                                'type' => 'link',
                                'label' => 'Retour au plan digital',
                                'href' => '/onas/projets/plan-digital-gamou',
                                'status' => 'en ligne',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'site-web',
                'title' => 'Site web',
                'status' => 'EN_COURS',
                'start_date' => '2025-10-15',
                'end_date' => '2025-12-15',
                'cover_image' => '/media/desktop.png',
                'objectif' => <<<TEXT
Mise en ligne d’un site ONAS réarchitecturé, aligné sur la nouvelle charte et optimisé pour guider les usagers vers les services prioritaires.
TEXT,
                'intro' => <<<TEXT
Le projet du nouveau site web de l’ONAS a été lancé dans un contexte où les équipes de l’ONAS étaient fortement mobilisées par la période d’hivernage. Nous avons donc choisi d’adopter une approche proactive : avancer en interne sur toutes les étapes possibles, pour ne pas perdre de temps.
TEXT,
                'news' => [
                    [
                        'title' => 'Version bêta en ligne',
                        'date' => '10 nov 2025',
                        'description' => 'Parcours complet visible sur la version test avant bascule vers la charte finale.',
                        'image' => '/media/Version beta (contenu existant)_mobile.png',
                        'anchorId' => 'version-beta-contenu-existant',
                    ],
                    [
                        'title' => 'Charte graphique validée avec le comité ONAS',
                        'date' => '08 nov 2025',
                        'description' => 'Feuille de route UI/UX finalisée pour intégration avant fin du mois.',
                        'image' => '/media/onas-branding.jpg',
                        'anchorId' => 'integration-charte-graphique-validee',
                    ],
                    [
                        'title' => 'Sprint développement V1 lancé',
                        'date' => '05 nov 2025',
                        'description' => 'Equipe Levell mobilisée sur l’intégration du contenu prioritaire.',
                        'image' => '/media/onas-web.png',
                        'anchorId' => 'developpement-v1',
                    ],
                    [
                        'title' => 'Tests accessibilité programmés',
                        'date' => '02 nov 2025',
                        'description' => 'Audit préliminaire prévu pour garantir la conformité RGAA.',
                        'image' => '/media/hero-sky.jpg',
                        'anchorId' => 'tests-mise-en-ligne',
                    ],
                ],
                'contact' => [
                    'name' => 'SIDY BOUYA NDIAYE',
                    'role' => 'IT Manager',
                    'phone' => '762253530',
                    'email' => 'sidy.ndiaye@levellagency.com',
                    'avatarUrl' => '/media/nouvelle_photo_sidy.jpeg',
                    'avatarObjectPosition' => 'top',
                ],
                'timeline' => [
                    [
                        'title' => 'Audit de l’ancien site web',
                        'description' => 'Analyse UX, analytics et accessibilité.',
                        'date' => 'oct 2025',
                        'status' => 'completed',
                        'iconKey' => 'audit',
                        'done' => true,
                        'backgroundImage' => '/media/audit.jpg',
                        'backgroundOverlay' => 'linear-gradient(90deg, rgba(9,18,9,0.98) 0%, rgba(9,18,9,0.94) 52%, rgba(9,18,9,0.85) 72%, rgba(9,18,9,0.65) 86%, rgba(9,18,9,0.32) 98%)',
                        'anchorId' => 'audit-ancien-site-web',
                        'assets' => [
                            [
                                'type' => 'pdf',
                                'label' => 'Rapport d’audit',
                                'href' => '/media/Audit_Site_ONAS.pdf',
                                'status' => 'prêt',
                            ],
                            [
                                'type' => 'link',
                                'label' => 'Backlog actions',
                                'status' => 'à intégrer',
                            ],
                        ],
                        'narrativeBefore' => <<<TEXT
Nous avons commencé par un audit approfondi de l’ancien site web. Cet audit nous a rapidement montré qu’une refonte complète était nécessaire, tant sur le plan technique que sur la structure du contenu.
TEXT,
                    ],
                    [
                        'title' => 'Restructuration du contenu',
                        'description' => 'Menu et architecture réorganisés.',
                        'date' => 'oct 2025',
                        'status' => 'completed',
                        'iconKey' => 'structure',
                        'done' => true,
                        'backgroundImage' => '/media/Restructuration du contenu.png',
                        'backgroundOverlay' => 'linear-gradient(90deg, rgba(9,18,9,0.98) 0%, rgba(9,18,9,0.94) 52%, rgba(9,18,9,0.85) 72%, rgba(9,18,9,0.65) 86%, rgba(9,18,9,0.32) 98%)',
                        'anchorId' => 'restructuration-du-contenu',
                        'pdf' => '/media/Site ONAS Restructuration du contenu.pdf',
                        'assets' => [
                            [
                                'type' => 'doc',
                                'label' => 'Plan d’arborescence',
                                'href' => '/media/Site ONAS Restructuration du contenu.pdf',
                                'status' => 'prêt',
                            ],
                        ],
                        'narrativeBefore' => <<<TEXT
Nous avons ensuite restructuré le contenu : repensé les menus, simplifié l’arborescence et organisé l’information pour la rendre plus fluide et cohérente.
TEXT,
                    ],
                    [
                        'title' => 'Adaptation du design temporaire',
                        'description' => 'Wireframes + maquettes identité transitoire.',
                        'date' => 'oct 2025',
                        'status' => 'completed',
                        'iconKey' => 'design',
                        'done' => true,
                        'backgroundImage' => '/media/Adaptation du design temporaire.png',
                        'backgroundOverlay' => 'linear-gradient(90deg, rgba(9,18,9,0.98) 0%, rgba(9,18,9,0.94) 52%, rgba(9,18,9,0.85) 72%, rgba(9,18,9,0.65) 86%, rgba(9,18,9,0.32) 98%)',
                        'anchorId' => 'adaptation-du-design-temporaire',
                        'assets' => [
                            [
                                'type' => 'figma',
                                'label' => 'Wireframes Figma',
                                'href' => 'https://www.figma.com/design/zHLj28ClfOC1mlDDmgOBbt/kam?node-id=0-1&t=70SxkwjWpnUrGeA9-1',
                                'status' => 'prêt',
                            ],
                        ],
                        'narrativeBefore' => <<<TEXT
Sur cette base, nous avons conçu un nouveau design inspiré de la charte graphique en cours d’élaboration. Même si cette charte n’était pas encore validée, nous avons produit un wireframe et une maquette temporaire pour matérialiser la future expérience utilisateur.
TEXT,
                    ],
                    [
                        'title' => 'Version beta (contenu existant)',
                        'description' => 'Déploiement d’une version bêta WordPress pour tester l’architecture.',
                        'date' => 'oct 2025',
                        'status' => 'completed',
                        'iconKey' => 'beta',
                        'done' => true,
                        'backgroundImage' => '/media/Version beta (contenu existant).png',
                        'backgroundImageMobile' => '/media/Version beta (contenu existant)_mobile.png',
                        'backgroundOverlay' => 'linear-gradient(90deg, rgba(9,18,9,0.98) 0%, rgba(9,18,9,0.94) 52%, rgba(9,18,9,0.85) 72%, rgba(9,18,9,0.65) 86%, rgba(9,18,9,0.32) 98%)',
                        'anchorId' => 'version-beta-contenu-existant',
                        'assets' => [
                            [
                                'type' => 'link',
                                'label' => 'Version bêta WordPress',
                                'href' => 'https://www.levellagency.com/onas/',
                                'status' => 'prêt',
                            ],
                        ],
                        'narrativeBefore' => <<<TEXT
Dans la continuité, nous avons développé une version bêta du site, en nous appuyant sur le contenu existant de l’ancien site, afin d’avoir une base technique déjà opérationnelle.
TEXT,
                    ],
                    [
                        'title' => 'Architecture finale ONAS',
                        'description' => 'Co-design de la navigation définitive.',
                        'date' => '12 nov 2025',
                        'status' => 'future',
                        'iconKey' => 'architecture',
                        'anchorId' => 'architecture-finale-onas',
                        'assets' => [
                            ['type' => 'doc', 'label' => 'Atelier ONAS x Levell', 'status' => 'en cours'],
                        ],
                        'narrativeBefore' => <<<TEXT
Aujourd’hui, nous arrivons à une étape clé : celle de la définition de l’architecture finale avec l’équipe de l’ONAS.
TEXT,
                    ],
                    [
                        'title' => 'Intégration charte graphique validée',
                        'description' => 'Déclinaison maquette graphique officielle.',
                        'date' => 'fin nov 2025',
                        'status' => 'on-hold',
                        'iconKey' => 'charter',
                        'anchorId' => 'integration-charte-graphique-validee',
                        'assets' => [
                            ['type' => 'figma', 'label' => 'Maquette finale', 'status' => 'à intégrer'],
                        ],
                    ],
                    [
                        'title' => 'Développement V1',
                        'description' => 'Intégration graphique complète + nouvelles sections.',
                        'date' => 'déc 2025',
                        'status' => 'future',
                        'iconKey' => 'dev',
                        'anchorId' => 'developpement-v1',
                        'assets' => [
                            ['type' => 'source', 'label' => 'Repo V1', 'status' => 'à intégrer'],
                        ],
                    ],
                    [
                        'title' => 'Optimisation & SEO',
                        'description' => 'Performances, structure SEO et redirections.',
                        'date' => 'déc 2025',
                        'status' => 'future',
                        'iconKey' => 'seo',
                        'backgroundImage' => '/media/Optimisation & SEO.jpg',
                        'backgroundOverlay' => 'linear-gradient(90deg, rgba(9,18,9,0.98) 0%, rgba(9,18,9,0.94) 52%, rgba(9,18,9,0.85) 72%, rgba(9,18,9,0.65) 86%, rgba(9,18,9,0.32) 98%)',
                        'anchorId' => 'optimisation-seo',
                        'assets' => [
                            ['type' => 'pdf', 'label' => 'Checklist SEO', 'status' => 'à intégrer'],
                        ],
                    ],
                    [
                        'title' => 'Tests & mise en ligne',
                        'description' => 'Recette finale, monitoring et communication.',
                        'date' => '15 déc 2025',
                        'status' => 'future',
                        'iconKey' => 'launch',
                        'backgroundImage' => '/media/Tests & mise en ligne.jpg',
                        'backgroundOverlay' => 'linear-gradient(90deg, rgba(9,18,9,0.98) 0%, rgba(9,18,9,0.94) 52%, rgba(9,18,9,0.85) 72%, rgba(9,18,9,0.65) 86%, rgba(9,18,9,0.32) 98%)',
                        'anchorId' => 'tests-mise-en-ligne',
                        'assets' => [
                            ['type' => 'link', 'label' => 'Plan de go-live', 'status' => 'à intégrer'],
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'strategie',
                'title' => 'Stratégie 2025',
                'status' => 'EN_COURS',
                'start_date' => '2025-10-10',
                'end_date' => '2025-11-30',
                'cover_image' => '/media/onas-strategy.jpg',
                'objectif' => <<<TEXT
Définition du positionnement ONAS et élaboration du plan d’action 2025 pour les communautés, basé sur la réalité terrain.
TEXT,
                'contact' => [
                    'name' => 'Elhadji NDIAYE',
                    'role' => 'CEO Levell',
                    'phone' => '+221 776789212',
                    'email' => 'elhadji.ndiaye@levellagency.com',
                    'avatarUrl' => '/media/photo_elj.jpg',
                    'avatarObjectPosition' => 'top',
                ],
                'timeline' => [
                    [
                        'title' => 'Analyse',
                        'description' => 'Lecture du contexte, enjeux critiques terrain, attentes usagers.',
                        'date' => 'oct 2025',
                        'status' => 'completed',
                        'iconKey' => 'analysis',
                        'done' => true,
                    ],
                    [
                        'title' => 'Positionnement',
                        'description' => 'Posture publique de l’ONAS et messages clés institutionnels.',
                        'date' => 'nov 2025',
                        'status' => 'in-progress',
                        'iconKey' => 'positioning',
                    ],
                    [
                        'title' => 'Plan d’action',
                        'description' => 'Feuille de route opérationnelle 2025 : axes, responsabilités, calendrier.',
                        'date' => 'déc 2025',
                        'status' => 'future',
                        'iconKey' => 'roadmap',
                    ],
                ],
            ],
            [
                'slug' => 'formation',
                'title' => 'Formation',
                'status' => 'EN_COURS',
                'start_date' => '2025-10-20',
                'end_date' => '2025-12-12',
                'cover_image' => '/media/onas-training.jpg',
                'objectif' => <<<TEXT
Programme d'acculturation des équipes ONAS : posture publique, communication de crise, outils digitaux et pédagogie terrain.
TEXT,
                'contact' => [
                    'name' => 'Elhadji NDIAYE',
                    'role' => 'CEO Levell',
                    'phone' => '+221 776789212',
                    'email' => 'elhadji.ndiaye@levellagency.com',
                    'avatarUrl' => '/media/photo_elj.jpg',
                    'avatarObjectPosition' => 'top',
                ],
                'timeline' => [
                    [
                        'title' => 'Formation Réseaux sociaux',
                        'description' => "Bonnes pratiques d'expression publique institutionnelle.",
                        'date' => 'oct 2025',
                        'status' => 'completed',
                        'iconKey' => 'social',
                        'done' => true,
                    ],
                    [
                        'title' => 'Formation Communauté',
                        'description' => "Relation directe avec les communautés, pédagogie sur les bons gestes.",
                        'date' => 'oct 2025',
                        'status' => 'completed',
                        'iconKey' => 'community',
                        'done' => true,
                    ],
                    [
                        'title' => 'Changement de comportement',
                        'description' => "Comment faire évoluer les pratiques des usagers.",
                        'date' => 'en cours',
                        'status' => 'in-progress',
                        'iconKey' => 'behaviour',
                    ],
                    [
                        'title' => 'Gestion de crise',
                        'description' => "Posture et discours en situation sensible (inondations, débordements).",
                        'date' => 'à venir',
                        'status' => 'future',
                        'iconKey' => 'crisis',
                    ],
                    [
                        'title' => 'Outils digitaux',
                        'description' => "Prise en main des outils de suivi et reporting terrain.",
                        'date' => 'à venir',
                        'status' => 'future',
                        'iconKey' => 'digital',
                    ],
                ],
            ],
            [
                'slug' => 'creas-tabaski',
                'title' => 'Créas Tabaski',
                'status' => 'TERMINE',
                'start_date' => '2025-08-01',
                'end_date' => '2025-09-30',
                'cover_image' => '/media/Crea Tabaski/Créa Tabaski Officiel Mockup 2.png',
                'objectif' => <<<TEXT
Concevoir la campagne de sensibilisation Tabaski : positionnement créatif, maquettes officielles, déclinaisons print et fichiers sources prêts à l’emploi.
TEXT,
                'intro' => <<<TEXT
Le brief Tabaski s’appuie sur l’héritage du plan digital Gamou tout en adressant les enjeux spécifiques de la fête (nettoiement des caniveaux, gestes responsables).

Chaque étape ci-dessous met à disposition les éléments validés ainsi qu’un accès direct aux ressources pour adaptation locale.
TEXT,
                'contact' => [
                    'name' => 'Ousmane Manel FALL',
                    'role' => 'Directeur Artistique',
                    'phone' => '773478428',
                    'email' => 'ousmane.fall@levellagency.com',
                    'avatarUrl' => '/media/photo_ousmane.jpg',
                    'avatarObjectPosition' => 'top',
                ],
                'timeline' => [
                    [
                        'title' => 'Brief & messages clés',
                        'description' => 'Synthèse des enjeux Tabaski, audiences prioritaires et axes de communication ONAS.',
                        'date' => 'août 2025',
                        'status' => 'completed',
                        'iconKey' => 'analysis',
                        'anchorId' => 'brief-tabaski',
                        'assets' => [
                            [
                                'type' => 'doc',
                                'label' => 'Brief créa Tabaski (.xmind)',
                                'href' => '/media/Crea Tabaski/Brief Créa ONAS.xmind',
                                'status' => 'téléchargeable',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Maquette officielle',
                        'description' => 'Visuels clés validés pour diffusion : identité Tabaski et déclinaisons social media.',
                        'date' => 'sept 2025',
                        'status' => 'completed',
                        'iconKey' => 'creative',
                        'anchorId' => 'maquettes-social-tabaski',
                        'images' => [
                            '/media/Crea Tabaski/Créa Tabaski Officiel Mockup.png',
                            '/media/Crea Tabaski/Créa Tabaski - Modif M. Lam.png',
                            '/media/Crea Tabaski/Créa Tabaski.png',
                        ],
                        'imagesDisplay' => 'modal',
                        'imagesButtonLabel' => 'Afficher les maquettes Tabaski',
                        'assets' => [
                            [
                                'type' => 'pdf',
                                'label' => 'Créa Tabaski officielle (PDF)',
                                'href' => '/media/Crea Tabaski/Créa Tabaski Officiel.pdf',
                                'status' => 'prêt',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Déclinaisons print & terrain',
                        'description' => 'Variantes bus et affichage terrain pour maximiser la visibilité pendant la fête.',
                        'date' => 'sept 2025',
                        'status' => 'completed',
                        'iconKey' => 'goodies',
                        'anchorId' => 'declinaisons-print-tabaski',
                        'images' => [
                            '/media/Crea Tabaski/Créa Tabaski Officiel Mockup 2.png',
                            '/media/Crea Tabaski/Créa Tabaski Bus.png',
                        ],
                        'imagesDisplay' => 'modal',
                        'imagesButtonLabel' => 'Voir les déclinaisons print',
                        'assets' => [
                            [
                                'type' => 'pdf',
                                'label' => 'Créa Tabaski Bus (PDF)',
                                'href' => '/media/Crea Tabaski/Créa Tabaski Bus.pdf',
                                'status' => 'prêt',
                            ],
                        ],
                    ],
                    [
                        'title' => 'Pack fichiers sources',
                        'description' => 'PSD et ressources photo pour décliner la campagne Tabaski sur mesure.',
                        'date' => 'sept 2025',
                        'status' => 'completed',
                        'iconKey' => 'delivery',
                        'anchorId' => 'pack-sources-tabaski',
                        'assets' => [
                            [
                                'type' => 'source',
                                'label' => 'Créa Tabaski officielle (PSD)',
                                'href' => '/media/Crea Tabaski/Créa Tabaski Officiel.psd',
                                'status' => 'téléchargeable',
                            ],
                            [
                                'type' => 'source',
                                'label' => 'Variantes bus & affichage',
                                'href' => '/media/Crea Tabaski/Créa Tabaski Bus.psd',
                                'status' => 'téléchargeable',
                            ],
                            [
                                'type' => 'source',
                                'label' => 'Variantes créa (pack)',
                                'href' => '/media/Crea Tabaski/Créa Tabaski - Modif M. Lam.psd',
                                'status' => 'téléchargeable',
                            ],
                            [
                                'type' => 'source',
                                'label' => 'Photos & ressources',
                                'href' => '/media/Crea Tabaski/Ressources/elj0801_urban_street_gutter_in_Dakar_during_Tabaski_discarded_6e33d3c4-57d5-4d15-b919-8cd698af7981_0.png',
                                'status' => 'à exploiter',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'charte-graphique',
                'title' => 'Charte graphique',
                'status' => 'EN_COURS',
                'start_date' => '2025-10-08',
                'end_date' => '2025-11-05',
                'cover_image' => '/media/onas-branding.jpg',
                'objectif' => <<<TEXT
Modernisation de l'identité ONAS : cohérence visuelle, reconnaissance institutionnelle, supports homogènes print & digital.
TEXT,
                'contact' => [
                    'name' => 'Ousmane Manel FALL',
                    'role' => 'Directeur Artistique',
                    'phone' => '773478428',
                    'email' => 'ousmane.fall@levellagency.com',
                    'avatarUrl' => '/media/photo_ousmane.jpg',
                    'avatarObjectPosition' => 'top',
                ],
                'timeline' => [
                    [
                        'title' => 'Variantes logos',
                        'description' => "Exploration autour du logotype ONAS : lisibilité, usage digital, déclinaisons.",
                        'date' => 'oct 2025',
                        'status' => 'completed',
                        'iconKey' => 'logos',
                        'done' => true,
                    ],
                    [
                        'title' => 'Univers Graphique',
                        'description' => 'Palette couleurs, typographies, iconographie, grammaire visuelle.',
                        'date' => 'oct 2025',
                        'status' => 'completed',
                        'iconKey' => 'universe',
                        'done' => true,
                    ],
                    [
                        'title' => 'Papeterie',
                        'description' => 'En-têtes officiels, cartes, documents internes normalisés.',
                        'date' => 'en cours',
                        'status' => 'in-progress',
                        'iconKey' => 'papeterie',
                    ],
                    [
                        'title' => 'Branding',
                        'description' => 'Définition du langage visuel public ONAS (ton, posture, image).',
                        'date' => 'à venir',
                        'status' => 'future',
                        'iconKey' => 'branding',
                    ],
                    [
                        'title' => 'Goodies',
                        'description' => 'Objets et supports physiques cohérents avec la nouvelle identité.',
                        'date' => 'à venir',
                        'status' => 'future',
                        'iconKey' => 'goodies',
                    ],
                ],
            ],
            [
                'slug' => 'crea-hivernage',
                'title' => 'Créa Hivernage',
                'status' => 'TERMINE',
                'start_date' => '2025-06-01',
                'end_date' => '2025-08-31',
                'cover_image' => '/media/Créa Hivernage/Créa Hivernage 2.png',
                'objectif' => <<<TEXT
Proposer une campagne de sensibilisation dédiée à l’hivernage : messages de prévention, visuels pédagogiques et fichiers sources pour déclinaison locale.
TEXT,
                'intro' => <<<TEXT
À partir du plan digital Gamou, nous avons extrait les messages pertinents pour la saison des pluies afin d’en faire une campagne autonome et réactive.

Les visuels ci-dessous sont prêts à être diffusés ou adaptés par les équipes ONAS.
TEXT,
                'contact' => [
                    'name' => 'Ousmane Manel FALL',
                    'role' => 'Directeur Artistique',
                    'phone' => '773478428',
                    'email' => 'ousmane.fall@levellagency.com',
                    'avatarUrl' => '/media/photo_ousmane.jpg',
                    'avatarObjectPosition' => 'top',
                ],
                'timeline' => [
                    [
                        'title' => 'Cadrage éditorial',
                        'description' => 'Définition des enjeux, audiences et messages prioritaires pour l’hivernage.',
                        'date' => 'juin 2025',
                        'status' => 'completed',
                        'iconKey' => 'analysis',
                        'anchorId' => 'cadrage-editorial-hivernage',
                        'narrativeBefore' => <<<TEXT
Nous avons isolé les situations critiques de la saison des pluies (gestion des déchets, entretien des caniveaux, appels d’urgence) pour préparer une prise de parole utile et pédagogique.
TEXT,
                    ],
                    [
                        'title' => 'Kit social media',
                        'description' => 'Créations pour anticiper, informer et réagir pendant les épisodes de pluie.',
                        'date' => 'juil 2025',
                        'status' => 'completed',
                        'iconKey' => 'social',
                        'anchorId' => 'kit-social-hivernage',
                        'images' => [
                            '/media/Créa Hivernage/Créa Hivernage.png',
                            '/media/Créa Hivernage/Créa Hivernage 2.png',
                            '/media/Créa Hivernage/Créa Hivernage 3.png',
                        ],
                        'imagesDisplay' => 'modal',
                        'imagesButtonLabel' => 'Afficher le kit social Hivernage',
                    ],
                    [
                        'title' => 'Fichiers sources',
                        'description' => 'PSD maître pour décliner la campagne Hivernage (formats social & print).',
                        'date' => 'août 2025',
                        'status' => 'completed',
                        'iconKey' => 'goodies',
                        'anchorId' => 'supports-terrain-hivernage',
                        'assets' => [
                            [
                                'type' => 'source',
                                'label' => 'Créa Hivernage (PSD)',
                                'href' => '/media/Créa Hivernage/Créa Hivernage.psd',
                                'status' => 'téléchargeable',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'gamou',
                'title' => 'Video Gamou',
                'status' => 'TERMINE',
                'start_date' => '2025-09-05',
                'end_date' => '2025-10-18',
                'cover_image' => '/media/onas-gamou.jpg',
                'objectif' => <<<TEXT
Couverture 360° du Gamou : production de contenus (photo, vidéo), social media, diffusion publique pour renforcer la visibilité de l’ONAS auprès des pèlerins.
TEXT,
                'intro' => <<<TEXT
Le projet de réalisation de deux capsules vidéo sur le Grand Gamou à Tivaouane et Kaolack s’est déroulé dans un contexte exigeant, marqué par une forte affluence et une mobilisation importante des équipes sur le terrain. Nous avons choisi d’adopter une approche proactive, en avançant simultanément sur toutes les étapes de production afin de garantir un rendu final de qualité et dans les délais impartis.
TEXT,
                'contact' => [
                    'name' => 'Paul Bernard Ndiaye',
                    'role' => 'Video Producer',
                    'phone' => '781560794',
                    'email' => 'paul.ndiaye@levellagency.com',
                    'avatarUrl' => '/media/photo_paul_square.jpg',
                ],
                'timeline' => [
                    [
                        'title' => 'Tournage (Kaolack - Tivaouane)',
                        'description' => 'Captation des événements du Gamou à Kaolack et Tivaone.',
                        'date' => 'fin sept 2025',
                        'status' => 'completed',
                        'iconKey' => 'shoot',
                        'done' => true,
                        'narrativeBefore' => <<<TEXT
La phase de tournage a ensuite été réalisée sur place, à Tivaouane et Kaolack, où les équipes de l’ONAS étaient déployées comme des camions de vidange et des mini-stations de pompage pour gérer l’importante affluence. L’objectif était de capturer des images authentiques et représentatives de l’ampleur du dispositif, tout en respectant la fluidité des opérations et la sécurité sur le terrain.
TEXT,
                    ],
                    [
                        'title' => 'Montage',
                        'description' => 'Assemblage image/son et animations explicatives.',
                        'date' => 'début oct 2025',
                        'status' => 'completed',
                        'iconKey' => 'montage',
                        'done' => true,
                        'narrativeBefore' => <<<TEXT
Lors du montage, les séquences ont été assemblées avec des éléments graphiques et des animations légères pour renforcer la compréhension et l’impact visuel du dispositif.
TEXT,
                    ],
                    [
                        'title' => 'Video Finale',
                        'description' => 'Montage et post-production des capsules finales (Tivaouane & Kaolack).',
                        'date' => 'début oct 2025',
                        'status' => 'completed',
                        'iconKey' => 'video',
                        'done' => true,
                        'videos' => [
                            [
                                'src' => '/media/Sama Naweet/TIV VERS 2 720P 3.mp4',
                                'orientation' => 'portrait',
                            ],
                            [
                                'src' => '/media/Sama Naweet/Video CAMIONS HD.mp4',
                                'orientation' => 'portrait',
                            ],
                        ],
                        'narrativeBefore' => <<<TEXT
Enfin, les deux versions finales ont été produites en intégrant les retours des équipes de l’ONAS, reflétant fidèlement le rôle stratégique et opérationnel de l’Office lors de cet événement majeur, tout en offrant des capsules claires, engageantes et représentatives de l’ampleur du Grand Gamou.
TEXT,
                    ],
                ],
            ],
        ];
    }
}
