<?php

/**
 * Procedural helper functions and overrides.
 *
 * @see https://codeigniter.com/user_guide/extending/common.html
 */

if (! function_exists('base_url')) {
    /**
     * Retorna la URL del sitio asegurando la inclusión de index.php para navegación y rutas
     * cuando el servidor web no tiene reescritura habilitada (mod_rewrite / AllowOverride None).
     * Mantiene las URLs limpias para recursos estáticos reales (imágenes, CSS, JS, etc.).
     *
     * @param array|string $relativePath
     */
    function base_url($relativePath = '', ?string $scheme = null): string
    {
        $path = is_array($relativePath) ? implode('/', $relativePath) : (string) $relativePath;

        // Excepción: rutas de controladores que sirven archivos dinámicos (ej. imágenes vía controlador)
        if (str_starts_with($path, 'ejercicio/imagen/')) {
            return site_url($relativePath, $scheme);
        }

        // Si es un archivo de recursos estáticos reales con extensión, usar URL base directa sin index.php
        $extension = strtolower(pathinfo(parse_url($path, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION));
        $assetExtensions = [
            'css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'ico',
            'webp', 'woff', 'woff2', 'ttf', 'eot', 'mp4', 'webm', 'pdf'
        ];

        if ($extension !== '' && in_array($extension, $assetExtensions, true)) {
            $currentURI = service('request')->getUri();
            assert($currentURI instanceof \CodeIgniter\HTTP\SiteURI);
            return $currentURI->baseUrl($relativePath, $scheme);
        }

        // Para módulos, rutas y páginas, utilizar site_url para anteponer index.php según la configuración
        return site_url($relativePath, $scheme);
    }
}
