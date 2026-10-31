<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'GIM360 - Sistema de Gestión') ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('gim360.png') ?>">
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
$isPerfilNutricionalActive = (strpos($uri, 'perfilnutricional') === 0 || strpos($uri, 'perfil-nutricional') === 0 || strpos($uri, 'controlnutricional') === 0);
$isComponenteNutricionalActive = (strpos($uri, 'componentenutricional') === 0 || strpos($uri, 'componente-nutricional') === 0 || strpos($uri, 'componentesnutricionales') === 0);
$isImagenComponenteActive = (strpos($uri, 'imagencomponentenutricional') === 0 || strpos($uri, 'imagen-componente') === 0 || strpos($uri, 'imagencomponente') === 0);
$isAlimentoComponenteActive = (strpos($uri, 'alimentocomponentenutricional') === 0 || strpos($uri, 'alimento-componente') === 0 || strpos($uri, 'alimentocomponente') === 0);
$isRecetaComponenteActive = (strpos($uri, 'recetacomponentenutricional') === 0 || strpos($uri, 'receta-componente') === 0 || strpos($uri, 'recetacomponente') === 0);
$isGrupoAlimentoActive = (strpos($uri, 'grupoalimento') === 0 || strpos($uri, 'grupo-alimento') === 0 || strpos($uri, 'gruposalimentos') === 0);
$isAlimentoActive = (strpos($uri, 'alimento') === 0 && strpos($uri, 'grupoalimento') === false && strpos($uri, 'grupo-alimento') === false && strpos($uri, 'alimentoreceta') === false && strpos($uri, 'alimento-receta') === false && strpos($uri, 'alimentocomponente') === false && strpos($uri, 'alimento-componente') === false);
$isPlanAlimentacionActive = (strpos($uri, 'planalimentacion') === 0 || strpos($uri, 'plan-alimentacion') === 0 || strpos($uri, 'planesalimentacion') === 0);
$isRecetaActive = (strpos($uri, 'receta') === 0 || strpos($uri, 'recetas') === 0) && strpos($uri, 'alimentoreceta') === false && strpos($uri, 'alimento-receta') === false && strpos($uri, 'recetacomponente') === false && strpos($uri, 'receta-componente') === false;
$isUnidadAlimentoActive = (strpos($uri, 'unidadalimento') === 0 || strpos($uri, 'unidad-alimento') === 0 || strpos($uri, 'unidadesalimento') === 0);
$isAlimentoRecetaActive = (strpos($uri, 'alimentoreceta') === 0 || strpos($uri, 'alimento-receta') === 0);
$isTipoComidaActive = (strpos($uri, 'tipocomida') === 0 || strpos($uri, 'tipo-comida') === 0 || strpos($uri, 'tiposcomida') === 0);
$isComidaActive = (strpos($uri, 'comida') === 0 || strpos($uri, 'comidas') === 0) && strpos($uri, 'tipocomida') === false;
$isVisitaActive  = (strpos($uri, 'visitasgim') === 0);
$isUsuarioActive = (strpos($uri, 'usuario') === 0);
$groupPersonasOpen = $isPersonaActive || $isClienteActive || $isPerfilNutricionalActive || $isComponenteNutricionalActive || $isImagenComponenteActive || $isAlimentoComponenteActive || $isRecetaComponenteActive || $isGrupoAlimentoActive || $isAlimentoActive || $isPlanAlimentacionActive || $isComidaActive || $isRecetaActive || $isUnidadAlimentoActive || $isAlimentoRecetaActive || $isTipoComidaActive || $isVisitaActive || $isUsuarioActive;

$isEquiposActive = (strpos($uri, 'equipo') === 0 && strpos($uri, 'ejercicioequipo') === false && strpos($uri, 'ejercicio-equipo') === false && strpos($uri, 'equipomusculo') === false && strpos($uri, 'equipo-musculo') === false && strpos($uri, 'disponibilidadequipo') === false && strpos($uri, 'disponibilidad-equipo') === false) || (strpos($uri, 'equipos') === 0);
$isEquipoMusculoActive = (strpos($uri, 'equipomusculo') === 0 || strpos($uri, 'equipo-musculo') === 0);
$isDisponibilidadEquipoActive = (strpos($uri, 'disponibilidadequipo') === 0 || strpos($uri, 'disponibilidad-equipo') === 0);
$groupEquiposOpen = $isEquiposActive || $isEquipoMusculoActive || $isDisponibilidadEquipoActive;

$isEjercicioActive = (strpos($uri, 'ejercicio') === 0 && strpos($uri, 'rutinaejercicio') === false && strpos($uri, 'ejercicioequipo') === false && strpos($uri, 'ejercicio-equipo') === false);
$isMotivoActive = (strpos($uri, 'motivoentrenamiento') === 0);
$isRutinaActive = (strpos($uri, 'rutinaejecicio') === 0 || strpos($uri, 'rutinaejercicio') === 0);
$isPlanEjercicioActive = (strpos($uri, 'planejercicio') === 0);
$isRutinaPlanActive = (strpos($uri, 'rutinaplan') === 0 || strpos($uri, 'rutina-plan') === 0);
$isMusculoActive = (strpos($uri, 'musculo') === 0 || strpos($uri, 'musculos') === 0);
$isTrenMuscularActive = (strpos($uri, 'trenmuscular') === 0 || strpos($uri, 'trenmusculo') === 0 || strpos($uri, 'tren-muscular') === 0);
$isMusculoEjercicioActive = (strpos($uri, 'musculoejercicio') === 0 || strpos($uri, 'musculo-ejercicio') === 0);
$isEjercicioEquipoActive = (strpos($uri, 'ejercicioequipo') === 0 || strpos($uri, 'ejercicio-equipo') === 0);
$isProgramaActive = (strpos($uri, 'programaentrenamiento') === 0);
$isRangoEdadActive = (strpos($uri, 'rangoedad') === 0 || strpos($uri, 'rango-edad') === 0);
$isRutinaProgramaActive = (strpos($uri, 'rutinaprograma') === 0 || strpos($uri, 'rutina-programa') === 0);
$isProgramaClienteActive = (strpos($uri, 'programacliente') === 0 || strpos($uri, 'programa-cliente') === 0);
$isPlanPersonalizadoActive = (strpos($uri, 'planpersonalizado') === 0 || strpos($uri, 'plan-personalizado') === 0 || strpos($uri, 'planejerciciopersonalizado') === 0);
$isEjecucionProgramaActive = (strpos($uri, 'ejecucionprograma') === 0 || strpos($uri, 'ejecucion-programa') === 0);
$isEstadoProgramaClienteActive = (strpos($uri, 'estadoprogramacliente') === 0 || strpos($uri, 'estado-programa-cliente') === 0);
$groupPlanificacionOpen = $isEjercicioActive || $isMotivoActive || $isRangoEdadActive || $isRutinaActive || $isPlanEjercicioActive || $isRutinaPlanActive || $isMusculoActive || $isTrenMuscularActive || $isMusculoEjercicioActive || $isEjercicioEquipoActive || $isProgramaActive || $isRutinaProgramaActive || $isEstadoProgramaClienteActive;
$groupEjecucionOpen = $isProgramaClienteActive || $isPlanPersonalizadoActive || $isEjecucionProgramaActive;

$isCorreoActive = (strpos($uri, 'correo') === 0);
$isDireccionActive = (strpos($uri, 'direccion') === 0);
$groupContactoOpen = $isCorreoActive || $isDireccionActive;

$isSexoActive = (strpos($uri, 'sexo') === 0);
$isEstadoCivilActive = (strpos($uri, 'estadocivil') === 0 && strpos($uri, 'estadocivilpersona') === false);
$isGeneroActive = (strpos($uri, 'genero') === 0 && strpos($uri, 'generopersona') === false);
$isDiaSemanaActive = (strpos($uri, 'diasemana') === 0 || strpos($uri, 'dia-semana') === 0 || strpos($uri, 'dias-semana') === 0);
$isImagenActive    = (strpos($uri, 'imagen') === 0 || strpos($uri, 'imagenes') === 0);
$groupCatalogosOpen = $isSexoActive || $isEstadoCivilActive || $isGeneroActive || $isDiaSemanaActive || $isImagenActive;

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
                <img src="<?= base_url('gim360.png') ?>" alt="Logo GIM360" class="rounded-3 border border-info border-opacity-50 shadow-sm" style="width: 44px; height: 44px; object-fit: cover;">
                <div class="lh-sm">
                    <span class="fs-4 fw-bold">GIM<span class="text-info">360</span></span>
                    <span class="d-block text-secondary small" style="font-size: 0.70rem;">SOFTWARE PARA GIMNASIOS</span>
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
                        <a href="<?= base_url('perfilnutricional') ?>" class="submenu-link <?= $isPerfilNutricionalActive ? 'active' : '' ?>">
                            <i class="bi bi-heart-pulse-fill text-danger"></i>
                            <span>Control Nutricional</span>
                        </a>
                        <a href="<?= base_url('componentenutricional') ?>" class="submenu-link <?= $isComponenteNutricionalActive ? 'active' : '' ?>">
                            <i class="bi bi-pie-chart-fill text-info"></i>
                            <span>Componentes Nutricionales</span>
                        </a>
                        <a href="<?= base_url('imagencomponentenutricional') ?>" class="submenu-link <?= $isImagenComponenteActive ? 'active' : '' ?>">
                            <i class="bi bi-images text-info"></i>
                            <span>Imágenes de Componentes</span>
                        </a>
                        <a href="<?= base_url('grupoalimento') ?>" class="submenu-link <?= $isGrupoAlimentoActive ? 'active' : '' ?>">
                            <i class="bi bi-egg-fried text-success"></i>
                            <span>Grupos de Alimentos</span>
                        </a>
                        <a href="<?= base_url('alimento') ?>" class="submenu-link <?= $isAlimentoActive ? 'active' : '' ?>">
                            <i class="bi bi-apple text-success"></i>
                            <span>Alimentos</span>
                        </a>
                        <a href="<?= base_url('alimentocomponentenutricional') ?>" class="submenu-link <?= $isAlimentoComponenteActive ? 'active' : '' ?>">
                            <i class="bi bi-link-45deg text-success"></i>
                            <span>Nutrientes de Alimentos</span>
                        </a>
                        <a href="<?= base_url('planalimentacion') ?>" class="submenu-link <?= $isPlanAlimentacionActive ? 'active' : '' ?>">
                            <i class="bi bi-journal-medical text-success"></i>
                            <span>Planes de Alimentación</span>
                        </a>
                        <a href="<?= base_url('comida') ?>" class="submenu-link <?= $isComidaActive ? 'active' : '' ?>">
                            <i class="bi bi-calendar2-heart text-success"></i>
                            <span>Comidas en Planes</span>
                        </a>
                        <a href="<?= base_url('receta') ?>" class="submenu-link <?= $isRecetaActive ? 'active' : '' ?>">
                            <i class="bi bi-book-half text-warning"></i>
                            <span>Recetas Saludables</span>
                        </a>
                        <a href="<?= base_url('recetacomponentenutricional') ?>" class="submenu-link <?= $isRecetaComponenteActive ? 'active' : '' ?>">
                            <i class="bi bi-pie-chart text-warning"></i>
                            <span>Nutrientes de Recetas</span>
                        </a>
                        <a href="<?= base_url('alimentoreceta') ?>" class="submenu-link <?= $isAlimentoRecetaActive ? 'active' : '' ?>">
                            <i class="bi bi-diagram-3-fill text-warning"></i>
                            <span>Ingredientes Recetas</span>
                        </a>
                        <a href="<?= base_url('unidadalimento') ?>" class="submenu-link <?= $isUnidadAlimentoActive ? 'active' : '' ?>">
                            <i class="bi bi-rulers text-info"></i>
                            <span>Unidades de Medida</span>
                        </a>
                        <a href="<?= base_url('tipocomida') ?>" class="submenu-link <?= $isTipoComidaActive ? 'active' : '' ?>">
                            <i class="bi bi-clock-history text-warning"></i>
                            <span>Tipos de Comida</span>
                        </a>
                        <a href="<?= base_url('visitasgim') ?>" class="submenu-link <?= $isVisitaActive ? 'active' : '' ?>">
                            <i class="bi bi-clock-history text-warning"></i>
                            <span>Visitas Gimnasio</span>
                        </a>
                        <a href="<?= base_url('usuario') ?>" class="submenu-link <?= $isUsuarioActive ? 'active' : '' ?>">
                            <i class="bi bi-person-lock text-primary"></i>
                            <span>Usuarios del Sistema</span>
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
                        <a href="<?= base_url('equipo') ?>" class="submenu-link <?= ($isEquiposActive && !$isEquipoMusculoActive && !$isDisponibilidadEquipoActive) ? 'active' : '' ?>">
                            <i class="bi bi-card-checklist text-success"></i>
                            <span>Gestión de Equipos</span>
                        </a>
                        <a href="<?= base_url('equipomusculo') ?>" class="submenu-link <?= $isEquipoMusculoActive ? 'active' : '' ?>">
                            <i class="bi bi-diagram-3 text-success"></i>
                            <span>Equipo - Músculos</span>
                        </a>
                        <a href="<?= base_url('disponibilidadequipo') ?>" class="submenu-link <?= $isDisponibilidadEquipoActive ? 'active' : '' ?>">
                            <i class="bi bi-clock-history text-success"></i>
                            <span>Disponibilidad Equipos</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- CATEGORÍA: PLANIFICACIÓN -->
            <div class="sidebar-item">
                <a class="sidebar-link sidebar-dropdown-toggle <?= $groupPlanificacionOpen ? '' : 'collapsed' ?>" 
                   data-bs-toggle="collapse" 
                   href="#menuPlanificacionCollapse" 
                   role="button" 
                   aria-expanded="<?= $groupPlanificacionOpen ? 'true' : 'false' ?>"
                   aria-controls="menuPlanificacionCollapse">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-calendar2-check text-danger fs-5"></i>
                        <span>Planificación</span>
                    </div>
                    <i class="bi bi-chevron-down arrow-indicator"></i>
                </a>
                <div class="collapse <?= $groupPlanificacionOpen ? 'show' : '' ?>" id="menuPlanificacionCollapse">
                    <div class="sidebar-submenu">
                        <a href="<?= base_url('ejercicio') ?>" class="submenu-link <?= $isEjercicioActive ? 'active' : '' ?>">
                            <i class="bi bi-card-list text-danger"></i>
                            <span>Catálogo Ejercicios</span>
                        </a>
                        <a href="<?= base_url('musculo') ?>" class="submenu-link <?= $isMusculoActive ? 'active' : '' ?>">
                            <i class="bi bi-person-arms-up text-danger"></i>
                            <span>Catálogo Músculos</span>
                        </a>
                        <a href="<?= base_url('trenmuscular') ?>" class="submenu-link <?= $isTrenMuscularActive ? 'active' : '' ?>">
                            <i class="bi bi-layers-half text-info"></i>
                            <span>Trenes Musculares</span>
                        </a>
                        <a href="<?= base_url('musculoejercicio') ?>" class="submenu-link <?= $isMusculoEjercicioActive ? 'active' : '' ?>">
                            <i class="bi bi-diagram-3-fill text-warning"></i>
                            <span>Músculos y Ejercicios</span>
                        </a>
                        <a href="<?= base_url('ejercicioequipo') ?>" class="submenu-link <?= $isEjercicioEquipoActive ? 'active' : '' ?>">
                            <i class="bi bi-gear-wide-connected text-info"></i>
                            <span>Ejercicios y Equipos</span>
                        </a>
                        <a href="<?= base_url('motivoentrenamiento') ?>" class="submenu-link <?= $isMotivoActive ? 'active' : '' ?>">
                            <i class="bi bi-bullseye text-warning"></i>
                            <span>Motivos de Entrenamiento</span>
                        </a>
                        <a href="<?= base_url('rangoedad') ?>" class="submenu-link <?= $isRangoEdadActive ? 'active' : '' ?>">
                            <i class="bi bi-person-bounding-box text-info"></i>
                            <span>Rangos de Edad</span>
                        </a>
                        <a href="<?= base_url('rutinaejecicio') ?>" class="submenu-link <?= $isRutinaActive ? 'active' : '' ?>">
                            <i class="bi bi-calendar2-week text-info"></i>
                            <span>Rutinas Modelo</span>
                        </a>
                        <a href="<?= base_url('planejercicio') ?>" class="submenu-link <?= $isPlanEjercicioActive ? 'active' : '' ?>">
                            <i class="bi bi-card-checklist text-primary"></i>
                            <span>Planes Ejercicio Modelo</span>
                        </a>
                        <a href="<?= base_url('rutinaplan') ?>" class="submenu-link <?= $isRutinaPlanActive ? 'active' : '' ?>">
                            <i class="bi bi-diagram-3 text-warning"></i>
                            <span>Rutinas y Planes Modelo</span>
                        </a>
                        <a href="<?= base_url('programaentrenamiento') ?>" class="submenu-link <?= $isProgramaActive ? 'active' : '' ?>">
                            <i class="bi bi-clipboard2-pulse text-success"></i>
                            <span>Programas Modelo</span>
                        </a>
                        <a href="<?= base_url('rutinaprograma') ?>" class="submenu-link <?= $isRutinaProgramaActive ? 'active' : '' ?>">
                            <i class="bi bi-collection-play text-info"></i>
                            <span>Rutinas en Programas</span>
                        </a>
                        <a href="<?= base_url('estadoprogramacliente') ?>" class="submenu-link <?= $isEstadoProgramaClienteActive ? 'active' : '' ?>">
                            <i class="bi bi-flag text-info"></i>
                            <span>Estados de Programa</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- CATEGORÍA: EJECUCIÓN -->
            <div class="sidebar-item">
                <a class="sidebar-link sidebar-dropdown-toggle <?= $groupEjecucionOpen ? '' : 'collapsed' ?>" 
                   data-bs-toggle="collapse" 
                   href="#menuEjecucionCollapse" 
                   role="button" 
                   aria-expanded="<?= $groupEjecucionOpen ? 'true' : 'false' ?>"
                   aria-controls="menuEjecucionCollapse">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-play-circle-fill text-warning fs-5"></i>
                        <span>Ejecución</span>
                    </div>
                    <i class="bi bi-chevron-down arrow-indicator"></i>
                </a>
                <div class="collapse <?= $groupEjecucionOpen ? 'show' : '' ?>" id="menuEjecucionCollapse">
                    <div class="sidebar-submenu">
                        <a href="<?= base_url('programacliente') ?>" class="submenu-link <?= $isProgramaClienteActive ? 'active' : '' ?>">
                            <i class="bi bi-person-lines-fill text-primary"></i>
                            <span>Programas Personalizados (Cliente)</span>
                        </a>
                        <a href="<?= base_url('planpersonalizado') ?>" class="submenu-link <?= $isPlanPersonalizadoActive ? 'active' : '' ?>">
                            <i class="bi bi-person-check-fill text-info"></i>
                            <span>Planes Personalizados (Ejercicios)</span>
                        </a>
                        <a href="<?= base_url('ejecucionprograma') ?>" class="submenu-link <?= $isEjecucionProgramaActive ? 'active' : '' ?>">
                            <i class="bi bi-play-btn-fill text-warning"></i>
                            <span>Ejecución de Programa</span>
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
                        <a href="<?= base_url('diasemana') ?>" class="submenu-link <?= $isDiaSemanaActive ? 'active' : '' ?>">
                            <i class="bi bi-calendar-week text-primary"></i>
                            <span>Días de la Semana</span>
                        </a>
                        <a href="<?= base_url('imagen') ?>" class="submenu-link <?= $isImagenActive ? 'active' : '' ?>">
                            <i class="bi bi-images text-info"></i>
                            <span>Imágenes / Multimedia</span>
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
                <?php if (session()->get('isLoggedIn')): ?>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2 shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle text-primary fs-5"></i>
                            <span class="d-none d-md-inline fw-semibold font-monospace">@<?= esc(session()->get('nombreusuario')) ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li class="px-3 py-1">
                                <span class="d-block fw-bold text-dark small"><?= esc(session()->get('persona_nombre_completo') ?: session()->get('nombreusuario')) ?></span>
                                <span class="text-muted small">C.I: <?= esc(session()->get('persona_cedula') ?: 'N/A') ?></span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <?php if (session()->get('idpersona')): ?>
                                <li>
                                    <a class="dropdown-item small" href="<?= base_url('persona/actual/' . session()->get('idpersona')) ?>">
                                        <i class="bi bi-person-vcard text-info me-2"></i>Mi Ficha Personal
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (session()->get('idusuario')): ?>
                                <li>
                                    <a class="dropdown-item small" href="<?= base_url('usuario/actual/' . session()->get('idusuario')) ?>">
                                        <i class="bi bi-person-lock text-primary me-2"></i>Mi Cuenta de Usuario
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item small text-danger" href="<?= base_url('logout') ?>">
                                    <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?= base_url('login') ?>" class="btn btn-outline-primary btn-sm fw-semibold">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                    </a>
                    <a href="<?= base_url('registro') ?>" class="btn btn-primary btn-sm fw-semibold text-white">
                        <i class="bi bi-person-plus me-1"></i> Registrarse
                    </a>
                <?php endif; ?>

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
