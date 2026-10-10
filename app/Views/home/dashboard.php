<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<!-- Banner Institucional y de Mentoría Académica -->
<div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #0a2540 0%, #0284c7 100%); color: white; border-radius: 14px;">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-white text-dark fw-bold px-2 py-1"><i class="bi bi-mortarboard-fill text-primary me-1"></i>UTLVTE</span>
                    <span class="badge bg-info bg-opacity-25 text-white border border-info border-opacity-50">Ingeniería de Software</span>
                    <span class="badge bg-success bg-opacity-25 text-white border border-success border-opacity-50"><i class="bi bi-shield-check me-1"></i>Sprint 1 Operativo</span>
                </div>
                <h3 class="fw-bold mb-1 text-white">GIM360 — Sistema de Gestión Deportiva Integral</h3>
                <p class="mb-2 text-white-50" style="font-size: 0.95rem;">
                    Modernización, control de aforo e inventario patrimonial para el Gimnasio Universitario y la Carrera de Cultura Física.
                </p>
                <div class="d-flex flex-wrap align-items-center gap-3 pt-1 border-top border-white border-opacity-25 small text-white-50">
                    <span><i class="bi bi-person-workspace text-warning me-1"></i><strong>Docente Guía y Mentor:</strong> <span class="text-white fw-semibold">Ing. Stalin Francis</span></span>
                    <span><i class="bi bi-laptop text-info me-1"></i>Tecnologías de la Información</span>
                    <span><i class="bi bi-database-check text-success me-1"></i>100% Producción Local</span>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <div class="btn-group">
                    <a href="<?= base_url('visitasgim/listar') ?>" class="btn btn-light text-dark fw-semibold shadow-sm">
                        <i class="bi bi-qr-code-scan me-1 text-primary"></i> Control Asistencia
                    </a>
                    <a href="<?= base_url('musculo/galeria') ?>" class="btn btn-outline-light">
                        <i class="bi bi-person-arms-up me-1"></i> Atlas Anatómico
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Métricas Clave de Alto Valor -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom h-100 bg-white border-top border-4 border-primary shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold">Ejercicios Físicos</span>
                        <h2 class="fw-bold my-1 text-primary"><?= number_format($counts['ejercicio']) ?></h2>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                            <i class="bi bi-play-circle me-1"></i>Fases Start/Peak
                        </span>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-primary fs-3">
                        <i class="bi bi-fire"></i>
                    </div>
                </div>
                <small class="text-muted d-block mt-2">Catálogo biomecánico pedagógico con video</small>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom h-100 bg-white border-top border-4 border-success shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold">Inventario de Equipos</span>
                        <h2 class="fw-bold my-1 text-success"><?= number_format($counts['equipos']) ?></h2>
                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                            <i class="bi bi-check-circle me-1"></i>100% Operativos
                        </span>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-3 text-success fs-3">
                        <i class="bi bi-gear-wide-connected"></i>
                    </div>
                </div>
                <small class="text-muted d-block mt-2">Maquinaria, pesas y accesorios registrados</small>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom h-100 bg-white border-top border-4 border-danger shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold">Atlas Anatómico</span>
                        <h2 class="fw-bold my-1 text-danger"><?= number_format($counts['musculo']) ?></h2>
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                            <i class="bi bi-person-fill me-1"></i>Grupos Musculares
                        </span>
                    </div>
                    <div class="bg-danger bg-opacity-10 p-3 rounded-3 text-danger fs-3">
                        <i class="bi bi-person-arms-up"></i>
                    </div>
                </div>
                <small class="text-muted d-block mt-2">Músculos ilustrados y vinculados a rutinas</small>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-custom h-100 bg-white border-top border-4 border-info shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold">Prescripción Deportiva</span>
                        <h2 class="fw-bold my-1 text-info"><?= number_format($counts['planejercicio']) ?></h2>
                        <span class="badge bg-info-subtle text-info border border-info-subtle">
                            <i class="bi bi-clipboard2-check me-1"></i>Planes Activos
                        </span>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded-3 text-info fs-3">
                        <i class="bi bi-clipboard-pulse"></i>
                    </div>
                </div>
                <small class="text-muted d-block mt-2">Planes estructurados según objetivo físico</small>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos Analíticos de Alto Valor -->
<div class="row g-4 mb-4">
    <div class="col-lg-5">
        <div class="card card-custom bg-white h-100 shadow-sm">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-pie-chart-fill text-primary me-2"></i>Equipamiento por Categoría
                    </h6>
                    <small class="text-muted">Distribución del inventario patrimonial</small>
                </div>
                <span class="badge bg-primary"><?= $counts['equipos'] ?> Equipos</span>
            </div>
            <div class="card-body d-flex flex-column justify-content-center align-items-center p-3">
                <div style="position: relative; height: 240px; width: 100%;">
                    <canvas id="chartEquipos"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card card-custom bg-white h-100 shadow-sm">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-bar-chart-fill text-danger me-2"></i>Cobertura Biomecánica por Grupo Muscular
                    </h6>
                    <small class="text-muted">Número de ejercicios disponibles por anatomía muscular</small>
                </div>
                <span class="badge bg-danger"><?= $counts['ejercicio'] ?> Ejercicios</span>
            </div>
            <div class="card-body p-3">
                <div style="position: relative; height: 240px; width: 100%;">
                    <canvas id="chartMusculos"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Resumen de Módulos Operativos -->
<h5 class="fw-bold text-secondary mb-3"><i class="bi bi-grid-fill me-1"></i> Resumen de Tablas Gestionadas</h5>
<div class="row g-3 mb-4">
    <!-- 1. persona -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-primary">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">1. Persona</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['persona'] ?></h3>
                    <small class="text-muted">Registros de personas</small>
                </div>
                <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary fs-3">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('persona') ?>" class="text-decoration-none small fw-semibold text-primary">Gestionar personas <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 2. cliente -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-success">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">2. Cliente</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['cliente'] ?></h3>
                    <small class="text-muted">Personas que son clientes</small>
                </div>
                <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success fs-3">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('cliente') ?>" class="text-decoration-none small fw-semibold text-success">Gestionar clientes <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 3. correo -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-info">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">3. Correo</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['correo'] ?></h3>
                    <small class="text-muted">Correos electrónicos asociados</small>
                </div>
                <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info fs-3">
                    <i class="bi bi-envelope-at-fill"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('correo') ?>" class="text-decoration-none small fw-semibold text-info">Gestionar correos <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 4. direccion -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-warning">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">4. Dirección</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['direccion'] ?></h3>
                    <small class="text-muted">Direcciones físicas registradas</small>
                </div>
                <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning fs-3">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('direccion') ?>" class="text-decoration-none small fw-semibold text-warning">Gestionar direcciones <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 5. sexo -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-danger">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">5. Sexo</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['sexo'] ?></h3>
                    <small class="text-muted">Catálogo biológico de sexos</small>
                </div>
                <div class="bg-danger bg-opacity-10 p-3 rounded-circle text-danger fs-3">
                    <i class="bi bi-gender-ambiguous"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('sexo') ?>" class="text-decoration-none small fw-semibold text-danger">Gestionar catálogo <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 6. estadocivil -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-secondary">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">6. Estado Civil</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['estadocivil'] ?></h3>
                    <small class="text-muted">Catálogo de estados civiles</small>
                </div>
                <div class="bg-secondary bg-opacity-10 p-3 rounded-circle text-secondary fs-3">
                    <i class="bi bi-heart-fill"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('estadocivil') ?>" class="text-decoration-none small fw-semibold text-secondary">Gestionar catálogo <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 7. estadocivilpersona -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-dark">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">7. Estado Civil Persona</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['estadocivilpersona'] ?></h3>
                    <small class="text-muted">Relaciones persona - estado civil</small>
                </div>
                <div class="bg-dark bg-opacity-10 p-3 rounded-circle text-dark fs-3">
                    <i class="bi bi-link-45deg"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('estadocivilpersona') ?>" class="text-decoration-none small fw-semibold text-dark">Gestionar asignaciones <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 8. genero -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-primary">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">8. Género</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['genero'] ?></h3>
                    <small class="text-muted">Catálogo de identidades de género</small>
                </div>
                <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary fs-3">
                    <i class="bi bi-person-lines-fill"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('genero') ?>" class="text-decoration-none small fw-semibold text-primary">Gestionar catálogo <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 9. generopersona -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-info">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">9. Género Persona</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['generopersona'] ?></h3>
                    <small class="text-muted">Relaciones persona - género</small>
                </div>
                <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info fs-3">
                    <i class="bi bi-shuffle"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('generopersona') ?>" class="text-decoration-none small fw-semibold text-info">Gestionar asignaciones <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 10. visitasgim -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-success">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">10. Visitas Gimnasio</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['visitasgim'] ?></h3>
                    <small class="text-muted">Registros de asistencia</small>
                </div>
                <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success fs-3">
                    <i class="bi bi-clock-history"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('visitasgim') ?>" class="text-decoration-none small fw-semibold text-success">Gestionar visitas <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 11. equipos -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-primary">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">11. Equipos y Máquinas</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['equipos'] ?></h3>
                    <small class="text-muted">Inventario de maquinaria</small>
                </div>
                <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary fs-3">
                    <i class="bi bi-gear-wide-connected"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('equipos') ?>" class="text-decoration-none small fw-semibold text-primary">Gestionar inventario <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 12. ejercicio -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-danger">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">12. Ejercicios</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['ejercicio'] ?></h3>
                    <small class="text-muted">Catálogo con video tutoriales</small>
                </div>
                <div class="bg-danger bg-opacity-10 p-3 rounded-circle text-danger fs-3">
                    <i class="bi bi-fire"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('ejercicio') ?>" class="text-decoration-none small fw-semibold text-danger">Gestionar ejercicios <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 13. ejerciciocliente -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-primary">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">13. Ejercicios de Clientes</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['ejerciciocliente'] ?></h3>
                    <small class="text-muted">Asignación y duración</small>
                </div>
                <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary fs-3">
                    <i class="bi bi-person-walking"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('ejerciciocliente') ?>" class="text-decoration-none small fw-semibold text-primary">Gestionar asignaciones <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 14. motivoentrenamiento -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-warning">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">14. Motivo Entrenamiento</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['motivoentrenamiento'] ?></h3>
                    <small class="text-muted">Metas y propósitos de entrenamiento</small>
                </div>
                <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning fs-3">
                    <i class="bi bi-bullseye"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('motivoentrenamiento') ?>" class="text-decoration-none small fw-semibold text-warning">Gestionar motivos <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 15. rutinaejecicio -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-info">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">15. Rutina Ejercicio</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['rutinaejecicio'] ?></h3>
                    <small class="text-muted">Planes y rutinas de entrenamiento</small>
                </div>
                <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info fs-3">
                    <i class="bi bi-calendar2-week"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('rutinaejecicio') ?>" class="text-decoration-none small fw-semibold text-info">Gestionar rutinas <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 16. planejercicio -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-primary">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">16. Planes de Ejercicio</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['planejercicio'] ?></h3>
                    <small class="text-muted">Series, repeticiones, descanso y peso</small>
                </div>
                <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary fs-3">
                    <i class="bi bi-card-checklist"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('planejercicio') ?>" class="text-decoration-none small fw-semibold text-primary">Gestionar planes <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 17. programaentrenamiento -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-success">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">17. Programa Entrenamiento</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['programaentrenamiento'] ?></h3>
                    <small class="text-muted">Relación motivo, rutina y planes</small>
                </div>
                <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success fs-3">
                    <i class="bi bi-clipboard2-pulse"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('programaentrenamiento') ?>" class="text-decoration-none small fw-semibold text-success">Gestionar programas <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 18. rutinaplan -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-warning">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">18. Rutina Plan</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['rutinaplan'] ?></h3>
                    <small class="text-muted">Asociación de rutinas y planes de ejercicio</small>
                </div>
                <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning fs-3">
                    <i class="bi bi-diagram-3"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('rutinaplan') ?>" class="text-decoration-none small fw-semibold text-warning">Gestionar rutina-plan <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 19. musculo -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-danger">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">19. Músculos</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['musculo'] ?></h3>
                    <small class="text-muted">Grupos musculares anatómicos con imágenes</small>
                </div>
                <div class="bg-danger bg-opacity-10 p-3 rounded-circle text-danger fs-3">
                    <i class="bi bi-person-arms-up"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('musculo') ?>" class="text-decoration-none small fw-semibold text-danger">Gestionar músculos <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 20. musculoejercicio -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-warning">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">20. Músculos y Ejercicios</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['musculoejercicio'] ?></h3>
                    <small class="text-muted">Músculos afectados por cada ejercicio</small>
                </div>
                <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning fs-3">
                    <i class="bi bi-diagram-3-fill"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('musculoejercicio') ?>" class="text-decoration-none small fw-semibold text-warning">Gestionar relaciones <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 21. ejercicioequipo -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-info">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">21. Ejercicios y Equipos</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['ejercicioequipo'] ?></h3>
                    <small class="text-muted">Equipos y máquinas requeridos en cada ejercicio</small>
                </div>
                <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info fs-3">
                    <i class="bi bi-gear-wide-connected"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('ejercicioequipo') ?>" class="text-decoration-none small fw-semibold text-info">Gestionar relaciones <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 22. programacliente -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-primary">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">22. Programas de Clientes</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['programacliente'] ?></h3>
                    <small class="text-muted">Programas asignados a clientes con fecha y estado</small>
                </div>
                <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary fs-3">
                    <i class="bi bi-person-lines-fill"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('programacliente') ?>" class="text-decoration-none small fw-semibold text-primary">Gestionar programas <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 23. estadoprogramacliente -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-info">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">23. Estados Programa Cliente</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['estadoprogramacliente'] ?></h3>
                    <small class="text-muted">Catálogo de estados (Activo, Pausado, etc.)</small>
                </div>
                <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info fs-3">
                    <i class="bi bi-flag-fill"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('estadoprogramacliente') ?>" class="text-decoration-none small fw-semibold text-info">Gestionar estados <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- 24. rutinaprograma -->
    <div class="col-sm-6 col-xl-4">
        <div class="card card-custom h-100 bg-white border-start border-4 border-info">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-uppercase fw-bold text-muted small">24. Rutinas en Programas</span>
                    <h3 class="fw-bold my-1 text-dark"><?= $counts['rutinaprograma'] ?? 0 ?></h3>
                    <small class="text-muted">Asociación de múltiples rutinas por programa</small>
                </div>
                <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info fs-3">
                    <i class="bi bi-collection-play-fill"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= base_url('rutinaprograma') ?>" class="text-decoration-none small fw-semibold text-info">Gestionar rutinas-programa <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Personas Registradas -->
<div class="card card-custom bg-white">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-people me-2 text-primary"></i>Personas Registradas Recientemente</h5>
        <a href="<?= base_url('persona') ?>" class="btn btn-outline-primary btn-sm">Ver todas las personas</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">ID</th>
                        <th>Cédula</th>
                        <th>Nombres y Apellidos</th>
                        <th>Fecha Nacimiento</th>
                        <th>Sexo</th>
                        <th>Tipo</th>
                        <th class="text-end pe-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentPersonas)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No se han registrado personas aún.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($recentPersonas as $p): ?>
                            <tr>
                                <td class="ps-3 fw-bold text-muted"><?= $p['idpersona'] ?></td>
                                <td><span class="badge bg-light text-dark border"><?= esc($p['cedula']) ?></span></td>
                                <td class="fw-semibold text-dark"><?= esc($p['nombres']) ?></td>
                                <td><?= !empty($p['fechanacimiento']) ? date('d/m/Y', strtotime($p['fechanacimiento'])) : '<span class="text-muted">-</span>' ?></td>
                                <td><?= !empty($p['sexo_nombre']) ? '<span class="badge bg-info text-dark">' . esc($p['sexo_nombre']) . '</span>' : '<span class="text-muted">No asignado</span>' ?></td>
                                <td>
                                    <?php if (!empty($p['idcliente'])): ?>
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Cliente</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Persona</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('persona/actual/' . $p['idpersona']) ?>" class="btn btn-outline-info" title="Ver Ficha">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('persona/edit/' . $p['idpersona']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tabla de Visitas Recientes -->
<div class="card card-custom bg-white mt-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-clock-history me-2 text-success"></i>Últimas Visitas al Gimnasio</h5>
        <div class="d-flex gap-2">
            <a href="<?= base_url('visitasgim/add') ?>" class="btn btn-outline-success btn-sm">+ Registrar Visita</a>
            <a href="<?= base_url('visitasgim/listar') ?>" class="btn btn-outline-primary btn-sm">Ver todas</a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">ID</th>
                        <th>Cliente</th>
                        <th>Cédula</th>
                        <th>Fecha</th>
                        <th>Hora Ingreso</th>
                        <th>Hora Salida</th>
                        <th class="text-end pe-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentVisitas)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No se han registrado visitas aún.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach (array_slice($recentVisitas, 0, 5) as $v): ?>
                            <tr>
                                <td class="ps-3 fw-bold text-muted"><?= $v['idvisitasgim'] ?></td>
                                <td class="fw-semibold text-dark"><?= esc($v['cliente_nombres']) ?></td>
                                <td><span class="badge bg-light text-dark border font-monospace"><?= esc($v['cedula']) ?></span></td>
                                <td><?= date('d/m/Y', strtotime($v['fecha'])) ?></td>
                                <td><span class="badge bg-primary font-monospace"><?= date('H:i', strtotime($v['horaingreso'])) ?></span></td>
                                <td>
                                    <?php if (!empty($v['horasalida'])): ?>
                                        <span class="badge bg-secondary font-monospace"><?= date('H:i', strtotime($v['horasalida'])) ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>En curso</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('visitasgim/actual/' . $v['idvisitasgim']) ?>" class="btn btn-outline-info" title="Ver Ficha">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('visitasgim/edit/' . $v['idvisitasgim']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tabla de Equipos Recientes -->
<div class="card card-custom bg-white mt-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-gear-wide-connected me-2 text-primary"></i>Equipos y Maquinaria Registrada</h5>
        <div class="d-flex gap-2">
            <a href="<?= base_url('equipos/add') ?>" class="btn btn-outline-primary btn-sm">+ Registrar Equipo</a>
            <a href="<?= base_url('equipos/listar') ?>" class="btn btn-outline-secondary btn-sm">Ver inventario</a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Código</th>
                        <th>Nombre del Equipo</th>
                        <th>Modelo</th>
                        <th>Valor Adquisición</th>
                        <th>Estado</th>
                        <th class="text-end pe-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentEquipos)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No se han registrado equipos aún.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach (array_slice($recentEquipos, 0, 5) as $eq): ?>
                            <tr>
                                <td class="ps-3"><span class="badge bg-primary font-monospace"><?= esc($eq['codigo']) ?></span></td>
                                <td class="fw-semibold text-dark"><?= esc($eq['nombre']) ?></td>
                                <td><?= !empty($eq['modelo']) ? esc($eq['modelo']) : '-' ?></td>
                                <td class="font-monospace fw-bold text-success"><?= !empty($eq['valor_adquisicion']) ? '$' . number_format($eq['valor_adquisicion'], 2) : '-' ?></td>
                                <td>
                                    <?php if (!empty($eq['activo'])): ?>
                                        <span class="badge bg-success-subtle text-success border border-success">Activo</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('equipos/actual/' . $eq['id_equipo']) ?>" class="btn btn-outline-info" title="Ver Ficha">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('equipos/edit/' . $eq['id_equipo']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tabla de Ejercicios Recientes -->
<div class="card card-custom bg-white mt-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-fire me-2 text-danger"></i>Catálogo de Ejercicios Destacados</h5>
        <div class="d-flex gap-2">
            <a href="<?= base_url('ejercicio/add') ?>" class="btn btn-outline-danger btn-sm">+ Registrar Ejercicio</a>
            <a href="<?= base_url('ejercicio/listar') ?>" class="btn btn-outline-secondary btn-sm">Ver catálogo</a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">ID</th>
                        <th>Nombre del Ejercicio</th>
                        <th>Descripción</th>
                        <th>Video Tutorial</th>
                        <th class="text-end pe-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentEjercicios)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No se han registrado ejercicios aún.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach (array_slice($recentEjercicios, 0, 5) as $ej): ?>
                            <tr>
                                <td class="ps-3 fw-bold text-muted"><?= $ej['idejercicio'] ?></td>
                                <td class="fw-semibold text-dark"><?= esc($ej['nombre']) ?></td>
                                <td>
                                    <small class="text-secondary text-truncate d-inline-block" style="max-width: 400px;">
                                        <?= esc($ej['descripcion'] ?? '-') ?>
                                    </small>
                                </td>
                                <td>
                                    <?php if (!empty($ej['urlvideo'])): ?>
                                        <a href="<?= esc($ej['urlvideo']) ?>" target="_blank" class="btn btn-outline-danger btn-sm py-0 px-2">
                                            <i class="bi bi-youtube me-1"></i> Ver Video
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('ejercicio/actual/' . $ej['idejercicio']) ?>" class="btn btn-outline-info" title="Ver Ficha">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('ejercicio/edit/' . $ej['idejercicio']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tabla de Ejercicios por Cliente Recientes -->
<div class="card card-custom bg-white mt-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-person-walking me-2 text-primary"></i>Últimos Ejercicios Realizados por Clientes</h5>
        <div class="d-flex gap-2">
            <a href="<?= base_url('ejerciciocliente/add') ?>" class="btn btn-outline-primary btn-sm">+ Asignar Ejercicio</a>
            <a href="<?= base_url('ejerciciocliente/listar') ?>" class="btn btn-outline-secondary btn-sm">Ver todos</a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">ID</th>
                        <th>Cliente</th>
                        <th>Cédula</th>
                        <th>Ejercicio</th>
                        <th>Fecha</th>
                        <th>Duración</th>
                        <th class="text-end pe-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentEC)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No se han registrado ejercicios de clientes aún.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach (array_slice($recentEC, 0, 5) as $rec): ?>
                            <tr>
                                <td class="ps-3 fw-bold text-muted"><?= $rec['idejerciciocliente'] ?></td>
                                <td class="fw-semibold text-dark"><?= esc($rec['cliente_nombres']) ?></td>
                                <td><span class="badge bg-light text-dark border font-monospace"><?= esc($rec['cedula']) ?></span></td>
                                <td>
                                    <span class="fw-semibold text-dark"><i class="bi bi-fire text-danger me-1"></i><?= esc($rec['ejercicio_nombre']) ?></span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($rec['fecha'])) ?></td>
                                <td>
                                    <span class="badge bg-success font-monospace"><?= $rec['duracionminutos'] ?> min</span>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('ejerciciocliente/actual/' . $rec['idejerciciocliente']) ?>" class="btn btn-outline-info" title="Ver Ficha">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('ejerciciocliente/edit/' . $rec['idejerciciocliente']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Gráfico de Equipos por Tipo
    const ctxEquipos = document.getElementById('chartEquipos');
    if (ctxEquipos) {
        new Chart(ctxEquipos, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode(array_keys($equipmentByType ?? [])) ?>,
                datasets: [{
                    data: <?= json_encode(array_values($equipmentByType ?? [])) ?>,
                    backgroundColor: [
                        '#0284c7',
                        '#10b981',
                        '#f59e0b',
                        '#6366f1',
                        '#8b5cf6'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 12,
                            font: { size: 11, weight: '600' },
                            padding: 10
                        }
                    }
                },
                cutout: '60%'
            }
        });
    }

    // Gráfico de Músculos
    const ctxMusculos = document.getElementById('chartMusculos');
    if (ctxMusculos) {
        new Chart(ctxMusculos, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_keys($topMuscles ?? [])) ?>,
                datasets: [{
                    label: 'Ejercicios Disponibles',
                    data: <?= json_encode(array_values($topMuscles ?? [])) ?>,
                    backgroundColor: [
                        'rgba(239, 68, 68, 0.85)',
                        'rgba(249, 115, 22, 0.85)',
                        'rgba(14, 165, 233, 0.85)',
                        'rgba(16, 185, 129, 0.85)',
                        'rgba(99, 102, 241, 0.85)',
                        'rgba(168, 85, 247, 0.85)'
                    ],
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                indexAxis: 'y',
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        ticks: { font: { size: 10 } }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { font: { size: 11, weight: '600' } }
                    }
                }
            }
        });
    }
});
</script>
<?= $this->endSection() ?>
