<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Repositorio extends BaseController
{
    /**
     * Sirve archivos multimedia directamente desde el directorio repositorio/
     * Permite soportar tanto servidores locales como entornos en la nube (cPanel, Nginx, Docker)
     * donde el DocumentRoot apunta a /public o donde los symlinks no están permitidos.
     *
     * @param string ...$params Segmentos de la ruta solicitada (ej. 'imagen', 'archivo.jpg')
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function index(...$params)
    {
        if (empty($params)) {
            throw PageNotFoundException::forPageNotFound("Recurso no especificado en el repositorio.");
        }

        // Unir parámetros y sanitizar para evitar Directory Traversal
        $subPath = implode('/', $params);
        $subPath = str_replace(['../', '..\\'], '', $subPath);
        $subPath = ltrim($subPath, '/\\');

        $baseDir = defined('ROOTPATH') ? rtrim(ROOTPATH, '/\\') : dirname(__DIR__, 2);

        $candidates = [
            $baseDir . '/repositorio/' . $subPath,
            $baseDir . '/' . $subPath,
            FCPATH . 'repositorio/' . $subPath,
            FCPATH . $subPath,
        ];

        $targetPath = null;
        foreach ($candidates as $cand) {
            if (file_exists($cand) && is_file($cand)) {
                $targetPath = $cand;
                break;
            }
        }

        if (!$targetPath) {
            throw PageNotFoundException::forPageNotFound("Archivo no encontrado en repositorio: " . $subPath);
        }

        $extension = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        $mimeTypes = [
            'webp' => 'image/webp',
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif'  => 'image/gif',
            'svg'  => 'image/svg+xml',
            'bmp'  => 'image/bmp',
            'ico'  => 'image/x-icon',
            'pdf'  => 'application/pdf',
            'mp4'  => 'video/mp4',
            'webm' => 'video/webm',
            'ogg'  => 'video/ogg',
        ];

        $contentType = $mimeTypes[$extension] ?? (mime_content_type($targetPath) ?: 'application/octet-stream');

        return $this->response
            ->setHeader('Content-Type', $contentType)
            ->setHeader('Content-Length', (string)filesize($targetPath))
            ->setHeader('Cache-Control', 'public, max-age=86400')
            ->setBody(file_get_contents($targetPath));
    }
}
