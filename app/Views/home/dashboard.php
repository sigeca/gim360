<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-speedometer2 text-primary me-2"></i>Panel de Control GIM360</h2>
        <p class="text-muted mb-0">Sistema integral para la gestión de personas, clientes, contactos y catálogos en la base de datos <code>gim360</code>.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('persona/add') ?>" class="btn btn-primary me-2">
            <i class="bi bi-person-plus-fill me-1"></i> Registrar Persona
        </a>
    </div>
</div>

<!-- Tarjetas de Métricas de las 9 Tablas -->
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
