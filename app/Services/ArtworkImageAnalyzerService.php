<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Storage;

class ArtworkImageAnalyzerService
{
    /**
     * Analyser une image et générer des descriptions automatiquement
     *
     * @param string $imagePath Le chemin de l'image
     * @return array
     */
    public function analyzeArtwork(string $imagePath): array
    {
        try {
            // Vérifier si l'API key est configurée
            if (!config('openai.api_key')) {
                return $this->getFallbackDescriptions();
            }

            // Convertir l'image en base64
            $imageContent = $this->getImageBase64($imagePath);

            if (!$imageContent) {
                return $this->getFallbackDescriptions();
            }

            // Appeler l'API OpenAI Vision
            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'text',
                                'text' => $this->getPrompt()
                            ],
                            [
                                'type' => 'image_url',
                                'image_url' => [
                                    'url' => $imageContent,
                                ],
                            ],
                        ],
                    ],
                ],
                'max_tokens' => 1000,
            ]);

            // Extraire la réponse
            $content = $response->choices[0]->message->content;

            \Log::info('Réponse OpenAI brute:', ['content' => $content]);

            $parsed = $this->parseResponse($content);

            \Log::info('Réponse parsée:', ['parsed' => $parsed]);

            return $parsed;
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'analyse de l\'image: ' . $e->getMessage());

            // Message d'erreur spécifique pour les limites de taux
            if (str_contains($e->getMessage(), 'rate limit')) {
                throw new \Exception('Limite de taux API dépassée. Veuillez réessayer dans quelques minutes.');
            }

            return $this->getFallbackDescriptions();
        }
    }

    /**
     * Convertir l'image en base64
     *
     * @param string $imagePath
     * @return string|null
     */
    protected function getImageBase64(string $imagePath): ?string
    {
        try {
            // Si c'est un fichier temporaire ou un chemin complet
            if (file_exists($imagePath)) {
                $imageData = file_get_contents($imagePath);
                $base64 = base64_encode($imageData);
                $mimeType = mime_content_type($imagePath);
                return "data:{$mimeType};base64,{$base64}";
            }

            // Si c'est un fichier dans le storage
            if (Storage::exists($imagePath)) {
                $imageData = Storage::get($imagePath);
                $base64 = base64_encode($imageData);
                $mimeType = Storage::mimeType($imagePath);
                return "data:{$mimeType};base64,{$base64}";
            }

            return null;
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la conversion de l\'image en base64: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Générer le prompt pour l'analyse
     *
     * @return string
     */
    protected function getPrompt(): string
    {
        return "Vous êtes un expert en histoire de l'art et en culture africaine. Analysez cette œuvre d'art et fournissez les informations suivantes au format JSON:

{
    \"title_fr\": \"Titre suggéré en français\",
    \"title_en\": \"Suggested title in English\",
    \"title_wo\": \"Titre suggéré en wolof (si applicable)\",
    \"description_fr\": \"Description détaillée de l'œuvre en français (minimum 100 mots). Incluez le style artistique, la technique, les couleurs dominantes, le contexte culturel et la signification symbolique.\",
    \"description_en\": \"Detailed description of the artwork in English (minimum 100 words). Include artistic style, technique, dominant colors, cultural context and symbolic meaning.\",
    \"description_wo\": \"Description en wolof si applicable, sinon laisser vide\",
    \"artist\": \"Artiste suggéré ou style artistique\",
    \"year\": \"Période ou année estimée\",
    \"cultural_context\": \"Contexte culturel et historique\"
}

Soyez précis, informatif et respectueux du patrimoine culturel africain. Si vous ne pouvez pas déterminer certaines informations, indiquez-le clairement.";
    }

    /**
     * Parser la réponse de l'API
     *
     * @param string $content
     * @return array
     */
    protected function parseResponse(string $content): array
    {
        try {
            // Nettoyer le contenu - enlever les backticks markdown si présents
            $content = preg_replace('/```json\s*/', '', $content);
            $content = preg_replace('/```\s*$/', '', $content);
            $content = trim($content);

            // Extraire le JSON de la réponse
            $jsonStart = strpos($content, '{');
            $jsonEnd = strrpos($content, '}');

            if ($jsonStart !== false && $jsonEnd !== false) {
                $jsonContent = substr($content, $jsonStart, $jsonEnd - $jsonStart + 1);

                \Log::info('JSON extrait:', ['json' => $jsonContent]);

                $data = json_decode($jsonContent, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
                    \Log::info('JSON décodé avec succès:', ['data' => $data]);

                    return [
                        'title_fr' => $data['title_fr'] ?? '',
                        'title_en' => $data['title_en'] ?? '',
                        'title_wo' => $data['title_wo'] ?? '',
                        'description_fr' => $data['description_fr'] ?? '',
                        'description_en' => $data['description_en'] ?? '',
                        'description_wo' => $data['description_wo'] ?? '',
                        'artist' => $data['artist'] ?? '',
                        'year' => $data['year'] ?? '',
                        'cultural_context' => $data['cultural_context'] ?? '',
                    ];
                } else {
                    \Log::error('Erreur de décodage JSON:', ['error' => json_last_error_msg()]);
                }
            }

            return $this->getFallbackDescriptions();
        } catch (\Exception $e) {
            \Log::error('Erreur lors du parsing de la réponse: ' . $e->getMessage());
            return $this->getFallbackDescriptions();
        }
    }

    /**
     * Retourner des descriptions par défaut
     *
     * @return array
     */
    protected function getFallbackDescriptions(): array
    {
        return [
            'title_fr' => '',
            'title_en' => '',
            'title_wo' => '',
            'description_fr' => '',
            'description_en' => '',
            'description_wo' => '',
            'artist' => '',
            'year' => '',
            'cultural_context' => '',
        ];
    }
}
