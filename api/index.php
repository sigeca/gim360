<?php

define('FCPATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);

if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

$pathInfo = $_SERVER['PATH_INFO'] ?? '';
if (empty($pathInfo) && isset($_SERVER['REQUEST_URI'])) {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $apiPrefix = '/gim360/api';
    if (strpos($uri, $apiPrefix) === 0) {
        $pathInfo = substr($uri, strlen($apiPrefix));
        if (strpos($pathInfo, '/index.php') === 0) {
            $pathInfo = substr($pathInfo, strlen('/index.php'));
        }
    }
}

if (empty($pathInfo) || $pathInfo === '/') {
    $pathInfo = '/persona';
}

$_SERVER['REQUEST_URI'] = '/gim360/index.php/api' . $pathInfo;
if (!empty($_SERVER['QUERY_STRING'])) {
    $_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
}
$_SERVER['PHP_SELF'] = '/gim360/index.php';

require FCPATH . 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';

exit(CodeIgniter\Boot::bootWeb($paths));
