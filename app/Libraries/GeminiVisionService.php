<?php

namespace App\Libraries;

/**
 * GeminiVisionService
 * Servicio para análisis de imágenes de platillos de comida y extracción
 * de componentes nutricionales utilizando la API de Google Gemini Vision.
 */
class GeminiVisionService
{
    protected string $apiKey;
    protected string $model;

    public function __construct(?string $apiKey = null, string $model = 'gemini-3.8-flash')
    {
        // Se prioriza la variable de entorno configurada en .env
        $envKey = getenv('GEMINI_API_KEY');
        if (!$envKey && function_exists('env')) {
            $envKey = env('GEMINI_API_KEY');
        }
        if (!$envKey) {
            // Clave configurada por defecto
            $envKey = base64_decode('QVEuQWI4Uk42TGJQdkNUWDBQTVUxcDVyWWgwT1lfTC1mTTJXSUd0WE5ETXhvemJ5czJsbVE=');
        }
        $this->apiKey = $apiKey ?: ($envKey ?: '');
        $this->model = $model;
    }

    /**
     * Obtiene la clave configurada actualmente (parcialmente enmascarada para logs o completa)
     */
    public function getApiKey(bool $masked = false): string
    {
        if ($masked) {
            $len = strlen($this->apiKey);
            if ($len <= 8) return '****';
            return substr($this->apiKey, 0, 4) . '...' . substr($this->apiKey, -4);
        }
        return $this->apiKey;
    }

    /**
     * Analiza una imagen de un plato de comida
     *
     * @param string $imageBytes Contenido binario o ruta del archivo
     * @param string $mimeType Tipo mime (image/jpeg, image/png, etc.)
     * @param array $availableComponents Lista opcional de nombres de componentes en la BD
     * @return array
     * @throws \Exception
     */
    public function analizarPlatoComida(string $imageDataOrPath, string $mimeType = 'image/jpeg', array $availableComponents = []): array
    {
        // Si es una ruta de archivo local existente
        if (is_file($imageDataOrPath)) {
            $mimeDetected = mime_content_type($imageDataOrPath);
            if ($mimeDetected) {
                $mimeType = $mimeDetected;
            }
            $base64Data = base64_encode(file_get_contents($imageDataOrPath));
        } else {
            // Asumir que ya viene en base64 o es binario
            if (base64_decode($imageDataOrPath, true) !== false && !preg_match('/^[a-zA-Z0-9\/+]+={0,2}$/', $imageDataOrPath)) {
                $base64Data = base64_encode($imageDataOrPath);
            } elseif (base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageDataOrPath), true) !== false) {
                // Puede tener prefijo data:image/...
                if (preg_match('#^data:(image/\w+);base64,(.+)$#i', $imageDataOrPath, $matches)) {
                    $mimeType = $matches[1];
                    $base64Data = $matches[2];
                } else {
                    $base64Data = $imageDataOrPath;
                }
            } else {
                $base64Data = base64_encode($imageDataOrPath);
            }
        }

        // Construir la lista de componentes disponibles para que la IA los mapee exactamente
        $componentesTxt = '';
        if (!empty($availableComponents)) {
            $componentesTxt = "Componentes nutricionales registrados en el sistema gim360:\n- " 
                . implode("\n- ", $availableComponents) . "\n\n";
        }

        $prompt = "Eres un nutricionista clínico y chef experto. Analiza detenidamente la fotografía de este plato de comida o preparación culinaria.\n\n"
            . $componentesTxt
            . "Tu objetivo es identificar el plato, sus porciones, tiempo de preparación, instrucciones de elaboración y los componentes nutricionales que aporta.\n\n"
            . "DEBES responder EXCLUSIVAMENTE con un objeto JSON válido (sin explicaciones adicionales ni texto antes o después), con la siguiente estructura exacta:\n"
            . "{\n"
            . "  \"nombre\": \"Nombre claro y descriptivo del plato\",\n"
            . "  \"porciones\": 1,\n"
            . "  \"tiempopreparacion\": 25,\n"
            . "  \"instrucciones\": \"Paso 1: Preparación...\\nPaso 2: Cocción...\\nPaso 3: Emplatado y servido...\",\n"
            . "  \"ingredientes\": [\"Pechuga de pollo\", \"Arroz integral\", \"Espinacas fresca\", \"Aceite de oliva\"],\n"
            . "  \"componentes\": [\"Proteínas\", \"Carbohidratos Totales\", \"Fibra Dietética\", \"Calorías / Valor Energético\"]\n"
            . "}\n\n"
            . "NOTAS:\n"
            . "- En 'componentes', selecciona ÚNICAMENTE aquellos componentes nutricionales de la lista provista que estén efectivamente presentes de manera relevante en este plato.\n"
            . "- El campo 'porciones' debe ser un número entero (ej: 1, 2, 4).\n"
            . "- El campo 'tiempopreparacion' debe ser un número entero en minutos (ej: 20, 35).\n"
            . "- El JSON debe ser parseable con json_decode.";

        $modelsToTry = [$this->model, 'gemini-2.5-flash', 'gemini-1.5-flash'];
        $lastError = null;

        foreach ($modelsToTry as $modelName) {
            try {
                $result = $this->callGeminiApi($modelName, $prompt, $base64Data, $mimeType);
                if (!empty($result)) {
                    return $result;
                }
            } catch (\Exception $e) {
                $lastError = $e->getMessage();
                if (function_exists('log_message')) {
                    log_message('warning', "GeminiVisionService modelo {$modelName} falló: " . $e->getMessage());
                }
            }
        }

        throw new \Exception("Error al comunicarse con la API de Gemini: " . ($lastError ?: 'Respuesta vacía'));
    }

    /**
     * Realiza la llamada HTTP a la API de Gemini
     */
    protected function callGeminiApi(string $model, string $prompt, string $base64Data, string $mimeType): array
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . urlencode($this->apiKey);

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $prompt
                        ],
                        [
                            'inline_data' => [
                                'mime_type' => $mimeType,
                                'data'      => $base64Data
                            ]
                        ]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature'       => 0.2,
                'responseMimeType'  => 'application/json'
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        $rawResponse = curl_exec($ch);
        $httpCode    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError   = curl_error($ch);
        curl_close($ch);

        if (!empty($curlError)) {
            throw new \Exception("Error de conexión cURL: {$curlError}");
        }

        if ($httpCode !== 200) {
            $errDecoded = json_decode($rawResponse, true);
            $msg = $errDecoded['error']['message'] ?? "HTTP Code {$httpCode}: {$rawResponse}";
            throw new \Exception("Google Gemini API error ({$httpCode}): {$msg}");
        }

        $response = json_decode($rawResponse, true);
        if (!$response || !isset($response['candidates'][0]['content']['parts'][0]['text'])) {
            throw new \Exception("Formato de respuesta inesperado de Gemini API: " . substr($rawResponse, 0, 300));
        }

        $text = trim($response['candidates'][0]['content']['parts'][0]['text']);
        // Limpiar bloques ```json y ``` si vinieran
        if (str_starts_with($text, '```json')) {
            $text = substr($text, 7);
        } elseif (str_starts_with($text, '```')) {
            $text = substr($text, 3);
        }
        if (str_ends_with($text, '```')) {
            $text = substr($text, 0, -3);
        }
        $text = trim($text);

        $parsed = json_decode($text, true);
        if (!is_array($parsed)) {
            throw new \Exception("No se pudo interpretar el JSON retornado por la IA: " . substr($text, 0, 300));
        }

        return $parsed;
    }
}
