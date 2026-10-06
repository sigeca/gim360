<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'GIM360 - Sistema de Gestión') ?></title>
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 275px;
            --gym-primary: #0284c7;
            --gym-dark: #0f172a;
            --gym-sidebar-bg: #0f172a;
            --gym-bg: #f8fafc;
        }
        body {
            background-color: var(--gym-bg);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        
        #wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* Sidebar Vertical */
        #sidebar-wrapper {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            background-color: var(--gym-sidebar-bg);
            color: #cbd5e1;
            display: flex;
            flex-direction: column;
            border-right: 1px solid #1e293b;
            transition: margin-left 0.28s ease-in-out;
            z-index: 1040;
        }

        .sidebar-brand {
            padding: 1.25rem 1.25rem 1rem 1.25rem;
            border-bottom: 1px solid #1e293b;
            background-color: #0b1120;
        }

        .sidebar-content {
            flex: 1 1 auto;
            overflow-y: auto;
            padding: 1rem 0.75rem;
        }

        .sidebar-heading {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 700;
            color: #64748b;
            padding: 0.75rem 0.75rem 0.25rem 0.75rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.65rem 0.85rem;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.93rem;
            margin-bottom: 0.2rem;
            transition: all 0.2s ease-in-out;
        }

        .sidebar-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.06);
        }

        .sidebar-link.active {
            color: #38bdf8;
            background-color: rgba(56, 189, 248, 0.12);
            font-weight: 600;
        }

        .sidebar-dropdown-toggle .arrow-indicator {
            font-size: 0.75rem;
            transition: transform 0.25s ease-in-out;
        }

        .sidebar-dropdown-toggle:not(.collapsed) .arrow-indicator {
            transform: rotate(180deg);
        }

        .sidebar-dropdown-toggle:not(.collapsed) {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.04);
        }

        /* Submenús desplegables verticales */
        .sidebar-submenu {
            padding-left: 0.75rem;
            margin-left: 1.2rem;
            margin-top: 0.25rem;
            margin-bottom: 0.5rem;
            border-left: 2px solid #334155;
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .submenu-link {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.45rem 0.75rem;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.88rem;
            font-weight: 500;
            transition: all 0.15s ease-in-out;
        }

        .submenu-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.06);
            transform: translateX(2px);
        }

        .submenu-link.active {
            color: #38bdf8;
            background-color: rgba(56, 189, 248, 0.15);
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid #1e293b;
            background-color: #0b1120;
            font-size: 0.82rem;
        }

        /* Contenido Principal y Navbar Superior */
        #page-content-wrapper {
            flex: 1 1 auto;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        .top-navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .main-content {
            flex: 1 0 auto;
            padding: 1.75rem 1.5rem;
        }

        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        }

        .nav-toolbar-card {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.06);
            border-left: 4px solid var(--gym-primary);
        }

        /* Footer */
        footer.page-footer {
            flex-shrink: 0;
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            padding: 1rem 1.5rem;
        }

        /* Responsive Mobile Sidebar */
        @media (max-width: 991.98px) {
            #sidebar-wrapper {
                margin-left: calc(-1 * var(--sidebar-width));
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
            }
            #wrapper.toggled #sidebar-wrapper {
                margin-left: 0;
            }
            .sidebar-backdrop {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1030;
            }
            #wrapper.toggled .sidebar-backdrop {
                display: block;
            }
        }
    </style>
</head>
<body>

<?php
// Detección de módulos activos para auto-expandir los desplegables verticales
$uri = uri_string();

$isPersonaActive = (strpos($uri, 'persona') === 0 && strpos($uri, 'generopersona') === false && strpos($uri, 'estadocivilpersona') === false);
$isClienteActive = (strpos($uri, 'cliente') === 0);
$isVisitaActive  = (strpos($uri, 'visitasgim') === 0);
$groupPersonasOpen = $isPersonaActive || $isClienteActive || $isVisitaActive;

$isEquiposActive = (strpos($uri, 'equipos') === 0);
$groupEquiposOpen = $isEquiposActive;

$isEjercicioActive = (strpos($uri, 'ejercicio') === 0 && strpos($uri, 'ejerciciocliente') === false);
$isEjercicioClienteActive = (strpos($uri, 'ejerciciocliente') === 0);
$groupEntrenamientoOpen = $isEjercicioActive || $isEjercicioClienteActive;

$isCorreoActive = (strpos($uri, 'correo') === 0);
$isDireccionActive = (strpos($uri, 'direccion') === 0);
$groupContactoOpen = $isCorreoActive || $isDireccionActive;

$isSexoActive = (strpos($uri, 'sexo') === 0);
$isEstadoCivilActive = (strpos($uri, 'estadocivil') === 0 && strpos($uri, 'estadocivilpersona') === false);
$isGeneroActive = (strpos($uri, 'genero') === 0 && strpos($uri, 'generopersona') === false);
$groupCatalogosOpen = $isSexoActive || $isEstadoCivilActive || $isGeneroActive;

$isECPActive = (strpos($uri, 'estadocivilpersona') === 0);
$isGPActive = (strpos($uri, 'generopersona') === 0);
$groupRelacionesOpen = $isECPActive || $isGPActive;

$isDashboardActive = ($uri === '' || $uri === 'home');
?>

<div id="wrapper">
    <!-- Backdrop oscuro para móviles -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Menú Vertical Desplegable (Sidebar) -->
    <aside id="sidebar-wrapper">
        
        <!-- Identidad / Logo -->
        <div class="sidebar-brand d-flex align-items-center justify-content-between">
            <a href="<?= base_url() ?>" class="d-flex align-items-center gap-2 text-white text-decoration-none">
                <i class="bi bi-activity text-warning fs-3"></i>
                <div class="lh-sm">
                    <span class="fs-4 fw-bold">GIM<span class="text-warning">360</span></span>
                    <span class="d-block text-secondary small" style="font-size: 0.72rem;">SISTEMA DE GESTIÓN</span>
                </div>
            </a>
            <button class="btn btn-sm btn-outline-secondary text-light d-lg-none" id="closeSidebarBtn">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <!-- Contenido y Enlaces con Desplegables Verticales -->
        <div class="sidebar-content">
            
            <!-- Dashboard Directo -->
            <a href="<?= base_url() ?>" class="sidebar-link <?= $isDashboardActive ? 'active' : '' ?>">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-speedometer2 text-info fs-5"></i>
                    <span>Panel de Control</span>
                </div>
            </a>

            <!-- CATEGORÍA 1: PERSONAS & CLIENTES -->
            <div class="sidebar-heading mt-2">Módulos de Gestión</div>

            <div class="sidebar-item">
                <a class="sidebar-link sidebar-dropdown-toggle <?= $groupPersonasOpen ? '' : 'collapsed' ?>" 
                   data-bs-toggle="collapse" 
                   href="#menuPersonasCollapse" 
                   role="button" 
                   aria-expanded="<?= $groupPersonasOpen ? 'true' : 'false' ?>"
                   aria-controls="menuPersonasCollapse">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-people-fill text-primary fs-5"></i>
                        <span>Personas & Clientes</span>
                    </div>
                    <i class="bi bi-chevron-down arrow-indicator"></i>
                </a>
                <div class="collapse <?= $groupPersonasOpen ? 'show' : '' ?>" id="menuPersonasCollapse">
                    <div class="sidebar-submenu">
                        <a href="<?= base_url('persona') ?>" class="submenu-link <?= $isPersonaActive ? 'active' : '' ?>">
                            <i class="bi bi-person-vcard text-info"></i>
                            <span>Personas</span>
                        </a>
                        <a href="<?= base_url('cliente') ?>" class="submenu-link <?= $isClienteActive ? 'active' : '' ?>">
                            <i class="bi bi-person-badge text-success"></i>
                            <span>Clientes</span>
                        </a>
                        <a href="<?= base_url('visitasgim') ?>" class="submenu-link <?= $isVisitaActive ? 'active' : '' ?>">
                            <i class="bi bi-clock-history text-warning"></i>
                            <span>Visitas Gimnasio</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- CATEGORÍA 2: EQUIPOS & MÁQUINAS -->
            <div class="sidebar-item">
                <a class="sidebar-link sidebar-dropdown-toggle <?= $groupEquiposOpen ? '' : 'collapsed' ?>" 
                   data-bs-toggle="collapse" 
                   href="#menuEquiposCollapse" 
                   role="button" 
                   aria-expanded="<?= $groupEquiposOpen ? 'true' : 'false' ?>"
                   aria-controls="menuEquiposCollapse">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-gear-wide-connected text-success fs-5"></i>
                        <span>Equipamiento</span>
                    </div>
                    <i class="bi bi-chevron-down arrow-indicator"></i>
                </a>
                <div class="collapse <?= $groupEquiposOpen ? 'show' : '' ?>" id="menuEquiposCollapse">
                    <div class="sidebar-submenu">
                        <a href="<?= base_url('equipos') ?>" class="submenu-link <?= $isEquiposActive ? 'active' : '' ?>">
                            <i class="bi bi-card-checklist text-success"></i>
                            <span>Gestión de Equipos</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- CATEGORÍA: ENTRENAMIENTO & EJERCICIOS -->
            <div class="sidebar-item">
                <a class="sidebar-link sidebar-dropdown-toggle <?= $groupEntrenamientoOpen ? '' : 'collapsed' ?>" 
                   data-bs-toggle="collapse" 
                   href="#menuEntrenamientoCollapse" 
                   role="button" 
                   aria-expanded="<?= $groupEntrenamientoOpen ? 'true' : 'false' ?>"
                   aria-controls="menuEntrenamientoCollapse">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-fire text-danger fs-5"></i>
                        <span>Entrenamiento</span>
                    </div>
                    <i class="bi bi-chevron-down arrow-indicator"></i>
                </a>
                <div class="collapse <?= $groupEntrenamientoOpen ? 'show' : '' ?>" id="menuEntrenamientoCollapse">
                    <div class="sidebar-submenu">
                        <a href="<?= base_url('ejercicio') ?>" class="submenu-link <?= $isEjercicioActive ? 'active' : '' ?>">
                            <i class="bi bi-card-list text-danger"></i>
                            <span>Catálogo Ejercicios</span>
                        </a>
                        <a href="<?= base_url('ejerciciocliente') ?>" class="submenu-link <?= $isEjercicioClienteActive ? 'active' : '' ?>">
                            <i class="bi bi-person-walking text-primary"></i>
                            <span>Ejercicios de Clientes</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- CATEGORÍA 2: CONTACTO & UBICACIÓN -->
            <div class="sidebar-item">
                <a class="sidebar-link sidebar-dropdown-toggle <?= $groupContactoOpen ? '' : 'collapsed' ?>" 
                   data-bs-toggle="collapse" 
                   href="#menuContactoCollapse" 
                   role="button" 
                   aria-expanded="<?= $groupContactoOpen ? 'true' : 'false' ?>"
                   aria-controls="menuContactoCollapse">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-geo-alt-fill text-warning fs-5"></i>
                        <span>Contacto</span>
                    </div>
                    <i class="bi bi-chevron-down arrow-indicator"></i>
                </a>
                <div class="collapse <?= $groupContactoOpen ? 'show' : '' ?>" id="menuContactoCollapse">
                    <div class="sidebar-submenu">
                        <a href="<?= base_url('correo') ?>" class="submenu-link <?= $isCorreoActive ? 'active' : '' ?>">
                            <i class="bi bi-envelope-at text-info"></i>
                            <span>Correos Electrónicos</span>
                        </a>
                        <a href="<?= base_url('direccion') ?>" class="submenu-link <?= $isDireccionActive ? 'active' : '' ?>">
                            <i class="bi bi-pin-map text-warning"></i>
                            <span>Direcciones</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- CATEGORÍA 3: CATÁLOGOS BASE -->
            <div class="sidebar-heading mt-3">Configuración & Catálogos</div>

            <div class="sidebar-item">
                <a class="sidebar-link sidebar-dropdown-toggle <?= $groupCatalogosOpen ? '' : 'collapsed' ?>" 
                   data-bs-toggle="collapse" 
                   href="#menuCatalogosCollapse" 
                   role="button" 
                   aria-expanded="<?= $groupCatalogosOpen ? 'true' : 'false' ?>"
                   aria-controls="menuCatalogosCollapse">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-tags-fill text-danger fs-5"></i>
                        <span>Catálogos Base</span>
                    </div>
                    <i class="bi bi-chevron-down arrow-indicator"></i>
                </a>
                <div class="collapse <?= $groupCatalogosOpen ? 'show' : '' ?>" id="menuCatalogosCollapse">
                    <div class="sidebar-submenu">
                        <a href="<?= base_url('sexo') ?>" class="submenu-link <?= $isSexoActive ? 'active' : '' ?>">
                            <i class="bi bi-gender-ambiguous text-danger"></i>
                            <span>Sexo</span>
                        </a>
                        <a href="<?= base_url('estadocivil') ?>" class="submenu-link <?= $isEstadoCivilActive ? 'active' : '' ?>">
                            <i class="bi bi-heart text-danger"></i>
                            <span>Estado Civil</span>
                        </a>
                        <a href="<?= base_url('genero') ?>" class="submenu-link <?= $isGeneroActive ? 'active' : '' ?>">
                            <i class="bi bi-person-lines-fill text-primary"></i>
                            <span>Género</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- CATEGORÍA 4: RELACIONES PERSONA -->
            <div class="sidebar-item">
                <a class="sidebar-link sidebar-dropdown-toggle <?= $groupRelacionesOpen ? '' : 'collapsed' ?>" 
                   data-bs-toggle="collapse" 
                   href="#menuRelacionesCollapse" 
                   role="button" 
                   aria-expanded="<?= $groupRelacionesOpen ? 'true' : 'false' ?>"
                   aria-controls="menuRelacionesCollapse">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-diagram-3-fill text-info fs-5"></i>
                        <span>Relaciones Persona</span>
                    </div>
                    <i class="bi bi-chevron-down arrow-indicator"></i>
                </a>
                <div class="collapse <?= $groupRelacionesOpen ? 'show' : '' ?>" id="menuRelacionesCollapse">
                    <div class="sidebar-submenu">
                        <a href="<?= base_url('estadocivilpersona') ?>" class="submenu-link <?= $isECPActive ? 'active' : '' ?>">
                            <i class="bi bi-arrow-left-right text-warning"></i>
                            <span>Estado Civil - Persona</span>
                        </a>
                        <a href="<?= base_url('generopersona') ?>" class="submenu-link <?= $isGPActive ? 'active' : '' ?>">
                            <i class="bi bi-shuffle text-info"></i>
                            <span>Género - Persona</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Pie del Menú Vertical -->
        <div class="sidebar-footer text-muted d-flex align-items-center justify-content-between">
            <div>
                <span class="d-block text-white fw-semibold small">MySQL Local</span>
                <span class="badge bg-dark border border-secondary text-secondary font-monospace" style="font-size: 0.7rem;">
                    <i class="bi bi-database me-1 text-success"></i>gim360
                </span>
            </div>
            <span class="badge bg-primary text-white" style="font-size: 0.7rem;">CI v4.7</span>
        </div>

    </aside>

    <!-- Contenedor Principal (Navbar Superior + Contenido + Footer) -->
    <div id="page-content-wrapper">
        
        <!-- Barra Superior (Top Navbar) -->
        <header class="top-navbar d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light border btn-sm" id="sidebarToggle" type="button" title="Alternar Menú">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div class="d-none d-sm-block">
                    <h6 class="mb-0 fw-bold text-dark"><?= esc($title ?? 'GIM360 - Sistema de Gestión') ?></h6>
                    <small class="text-muted" style="font-size: 0.75rem;">Base de datos <code>gim360</code></small>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="<?= base_url('persona/add') ?>" class="btn btn-warning btn-sm fw-bold px-3">
                    <i class="bi bi-person-plus-fill me-1"></i> + Nueva Persona
                </a>
            </div>
        </header>

        <!-- Contenido Central de las Vistas -->
        <main class="main-content">
            <div class="container-fluid px-0">
                
                <!-- Alertas Flash -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2 fs-5 align-middle"></i>
                        <strong>¡Éxito!</strong> <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5 align-middle"></i>
                        <strong>Error:</strong> <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5 align-middle"></i>
                        <strong>Por favor corrige los siguientes errores:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach (session()->getFlashdata('errors') as $err): ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                <?php endif; ?>

                <!-- Renderizado de Vistas -->
                <?= $this->renderSection('content') ?>
            </div>
        </main>

        <!-- Pie de Página -->
        <footer class="page-footer">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <span>© <?= date('Y') ?> <strong>GIM360</strong> — Sistema de Información y Gestión Integral. CodeIgniter 4 & MySQL.</span>
                </div>
                <div class="d-flex gap-3 font-monospace small">
                    <span><i class="bi bi-database me-1"></i> BD: gim360</span>
                    <span><i class="bi bi-cpu me-1"></i> PHP <?= PHP_VERSION ?></span>
                </div>
            </div>
        </footer>

    </div>
</div>

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script para toggle del menú vertical en pantallas pequeñas / escritorio -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const wrapper = document.getElementById('wrapper');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        function toggleSidebar() {
            wrapper.classList.toggle('toggled');
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', toggleSidebar);
        }
        if (closeSidebarBtn) {
            closeSidebarBtn.addEventListener('click', toggleSidebar);
        }
        if (sidebarBackdrop) {
            sidebarBackdrop.addEventListener('click', toggleSidebar);
        }
    });
</script>

<?= $this->renderSection('scripts') ?>
</body>
</html>
