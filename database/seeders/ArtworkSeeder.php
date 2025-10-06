<?php

namespace Database\Seeders;

use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArtworkSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        $artworks = [
            [
                'title' => 'Masque Diola',
                'description_fr' => 'Masque traditionnel de la communauté Diola du sud du Sénégal, utilisé lors des cérémonies rituelles et des fêtes traditionnelles. Ce masque représente l\'esprit protecteur de la communauté et symbolise la connexion entre le monde des vivants et celui des ancêtres.',
                'description_en' => 'Traditional mask from the Diola community of southern Senegal, used during ritual ceremonies and traditional festivals. This mask represents the protective spirit of the community and symbolizes the connection between the world of the living and that of the ancestors.',
                'description_wo' => 'Masq bu njëkk ci jamono Jola yi ci penku Senegaal, boo ko def ci saraañ ak festivaal yi ñu njëkk. Masq bii di melni alruj ju jamono jiitu ak mooy tànke ci jëfandikoo jamono yu dund ak say màam yi.',
                'artist' => 'Artisan Diola Anonyme',
                'creation_year' => 1950,
                'medium' => 'Bois sculpté, fibres naturelles',
                'dimensions' => '35 x 25 x 15 cm',
                'qr_code' => 'MASK_DIOLA_001',
                'category_id' => $categories->where('name', 'Sculpture')->first()->id,
                'is_featured' => true,
                'historical_context' => [
                    'Les masques Diola sont utilisés depuis des siècles dans la région de Casamance',
                    'Ils jouent un rôle central dans les rituels d\'initiation et les cérémonies de passage',
                    'Chaque masque est unique et porte en lui l\'histoire de la famille qui le possède'
                ],
                'cultural_significance' => [
                    'Symbole de protection spirituelle',
                    'Lien avec les traditions ancestrales',
                    'Expression de l\'identité culturelle Diola'
                ]
            ],
            [
                'title' => 'Peinture sous Verre Sénégalaise',
                'description_fr' => 'Art de la peinture sous verre développé au Sénégal, illustrant des scènes de la vie quotidienne, des légendes islamiques et des portraits de personnalités religieuses. Cette technique unique mélange les influences arabes, européennes et africaines.',
                'description_en' => 'Senegalese reverse glass painting art, illustrating scenes from daily life, Islamic legends, and portraits of religious figures. This unique technique blends Arab, European, and African influences.',
                'description_wo' => 'Sañar-sañar ci weer bu ñu defee ci Senegaal, boo wone ni tabax ci ndey-jee ñii suyama, tàntu islam ak nataal alruj yu rab-rab. Fësal bii ag beneen-beneen boo jëmali Arab, Tubaab ak Afrik.',
                'artist' => 'Mor Gueye',
                'creation_year' => 1985,
                'medium' => 'Peinture sous verre',
                'dimensions' => '50 x 40 cm',
                'qr_code' => 'PAINT_GLASS_002',
                'category_id' => $categories->where('name', 'Peinture Traditionnelle')->first()->id,
                'is_featured' => false,
                'historical_context' => [
                    'Technique introduite au Sénégal par les marchands arabes',
                    'Popularisée au début du 20ème siècle',
                    'Devient un art populaire urbain'
                ],
                'cultural_significance' => [
                    'Expression de la créativité populaire sénégalaise',
                    'Mélange des influences culturelles',
                    'Art accessible et démocratique'
                ]
            ],
            [
                'title' => 'Sculpture Contemporaine "Unité"',
                'description_fr' => 'Sculpture moderne représentant l\'unité dans la diversité, créée par un artiste sénégalais contemporain. L\'œuvre explore les thèmes de l\'identité africaine moderne et du dialogue interculturel.',
                'description_en' => 'Modern sculpture representing unity in diversity, created by a contemporary Senegalese artist. The work explores themes of modern African identity and intercultural dialogue.',
                'description_wo' => 'Pexe bu bees boo melni benno ci yeneen-yeneen, sañar-sañar bi Senegaalees bu bees defoon. Liggéey bii di xoolal jëfandikoo lu wen ci modo Afrika bu bees ak wax-waxtan ci ëppoon kultéer yi.',
                'artist' => 'Ousmane Sow',
                'creation_year' => 2010,
                'medium' => 'Bronze et acier',
                'dimensions' => '180 x 120 x 80 cm',
                'qr_code' => 'SCULPT_UNITY_003',
                'category_id' => $categories->where('name', 'Art Contemporain')->first()->id,
                'is_featured' => true,
                'historical_context' => [
                    'Création dans le contexte de la renaissance artistique africaine',
                    'Influence des mouvements artistiques contemporains',
                    'Dialogue entre tradition et modernité'
                ],
                'cultural_significance' => [
                    'Vision moderne de l\'art africain',
                    'Message d\'unité et de réconciliation',
                    'Pont entre les cultures'
                ]
            ]
        ];

        foreach ($artworks as $artworkData) {
            Artwork::create($artworkData);
        }
    }
}
