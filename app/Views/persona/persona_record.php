<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (empty($persona)): ?>
            <?= view('layout/empty_record', ['module' => 'persona']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'persona',
                'currentId' => $persona['idpersona']
            ]) ?>

            <!-- Encabezado de la Ficha Principal -->
            <div class="card card-custom bg-white border-top border-4 border-primary mb-4">
                <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary text-white rounded-circle p-2 fs-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0 text-dark"><?= esc($persona['apellidos'] . ' ' . $persona['nombres']) ?></h4>
                            <span class="text-muted small">Registro Principal de Persona #<?= $persona['idpersona'] ?></span>
                        </div>
                    </div>
                    
                    <div class="mt-2 mt-md-0 d-flex align-items-center gap-2">
                        <?php if (!empty($persona['idcliente'])): ?>
                            <span class="badge bg-success fs-6"><i class="bi bi-check-circle me-1"></i>Cliente Gym (ID: #<?= $persona['idcliente'] ?>)</span>
                        <?php else: ?>
                            <span class="badge bg-secondary fs-6">No es Cliente</span>
                        <?php endif; ?>

                        <form method="post" action="<?= base_url('persona/toggleCliente/' . $persona['idpersona']) ?>" class="d-inline">
                            <?= csrf_field() ?>
                            <?php if (!empty($persona['idcliente'])): ?>
                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Quitar como cliente?')">
                                    <i class="bi bi-person-dash me-1"></i> Quitar Cliente
                                </button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-person-plus me-1"></i> Hacer Cliente
                                </button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label class="text-muted small fw-bold text-uppercase">Cédula</label>
                            <p class="fs-5 fw-bold font-monospace text-dark mb-0"><?= esc($persona['cedula']) ?></p>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small fw-bold text-uppercase">Apellidos</label>
                            <p class="fs-5 fw-semibold text-dark mb-0"><?= esc($persona['apellidos']) ?></p>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small fw-bold text-uppercase">Nombres</label>
                            <p class="fs-5 fw-semibold text-dark mb-0"><?= esc($persona['nombres']) ?></p>
                        </div>
                        <div class="col-md-2">
                            <label class="text-muted small fw-bold text-uppercase">Fecha de Nacimiento</label>
                            <p class="fs-6 text-dark mb-0">
                                <?= !empty($persona['fechanacimiento']) ? '<i class="bi bi-calendar3 me-1 text-primary"></i>' . date('d/m/Y', strtotime($persona['fechanacimiento'])) : '<span class="text-muted">-</span>' ?>
                            </p>
                        </div>
                        <div class="col-md-2">
                            <label class="text-muted small fw-bold text-uppercase">Sexo</label>
                            <p class="mb-0">
                                <?= !empty($persona['sexo_nombre']) ? '<span class="badge bg-info text-dark">' . esc($persona['sexo_nombre']) . '</span>' : '<span class="text-muted">No asignado</span>' ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tablas Relacionadas Asociadas a esta Persona -->
            <div class="row g-4">
                
                <!-- 1. Correos Electrónicos -->
                <div class="col-md-6">
                    <div class="card card-custom bg-white h-100">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0 text-dark">
                                <i class="bi bi-envelope-at text-info me-2"></i>Correos Registrados (<code>correo</code>)
                            </h6>
                            <a href="<?= base_url('correo/add?idpersona=' . $persona['idpersona']) ?>" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-plus-lg"></i> Añadir
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0 small">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3">Correo</th>
                                            <th>Fecha Obtención</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($correos)): ?>
                                            <tr><td colspan="2" class="text-center py-3 text-muted">Sin correos.</td></tr>
                                        <?php else: ?>
                                            <?php foreach ($correos as $c): ?>
                                                <tr>
                                                    <td class="ps-3 font-monospace">
                                                        <a href="<?= base_url('correo/actual/' . $c['idcorreo']) ?>" class="text-decoration-none">
                                                            <?= esc($c['correo']) ?>
                                                        </a>
                                                    </td>
                                                    <td><?= !empty($c['fechaoptencion']) ? date('d/m/Y', strtotime($c['fechaoptencion'])) : '-' ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Direcciones -->
                <div class="col-md-6">
                    <div class="card card-custom bg-white h-100">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0 text-dark">
                                <i class="bi bi-pin-map text-warning me-2"></i>Direcciones Registradas (<code>direccion</code>)
                            </h6>
                            <a href="<?= base_url('direccion/add?idpersona=' . $persona['idpersona']) ?>" class="btn btn-sm btn-outline-warning text-dark">
                                <i class="bi bi-plus-lg"></i> Añadir
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0 small">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3">Dirección Domiciliaria</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($direcciones)): ?>
                                            <tr><td class="text-center py-3 text-muted">Sin direcciones.</td></tr>
                                        <?php else: ?>
                                            <?php foreach ($direcciones as $d): ?>
                                                <tr>
                                                    <td class="ps-3">
                                                        <a href="<?= base_url('direccion/actual/' . $d['iddireccion']) ?>" class="text-decoration-none text-dark">
                                                            <i class="bi bi-geo-alt me-1 text-warning"></i><?= esc($d['direccion']) ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Estados Civiles Asignados -->
                <div class="col-md-6">
                    <div class="card card-custom bg-white h-100">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0 text-dark">
                                <i class="bi bi-heart text-danger me-2"></i>Estado Civil (<code>estadocivilpersona</code>)
                            </h6>
                            <a href="<?= base_url('estadocivilpersona/add?idpersona=' . $persona['idpersona']) ?>" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-plus-lg"></i> Asignar
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0 small">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3">ID Relación</th>
                                            <th>Estado Civil</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($estadosCiviles)): ?>
                                            <tr><td colspan="2" class="text-center py-3 text-muted">Sin asignaciones.</td></tr>
                                        <?php else: ?>
                                            <?php foreach ($estadosCiviles as $ec): ?>
                                                <tr>
                                                    <td class="ps-3 text-muted fw-bold">#<?= $ec['idestadocivilpersona'] ?></td>
                                                    <td>
                                                        <a href="<?= base_url('estadocivilpersona/actual/' . $ec['idestadocivilpersona']) ?>" class="badge bg-secondary text-decoration-none">
                                                            <?= esc($ec['estadocivil_nombre']) ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Identidad de Género Asignada -->
                <div class="col-md-6">
                    <div class="card card-custom bg-white h-100">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0 text-dark">
                                <i class="bi bi-person-lines-fill text-primary me-2"></i>Identidad de Género (<code>generopersona</code>)
                            </h6>
                            <a href="<?= base_url('generopersona/add?idpersona=' . $persona['idpersona']) ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-plus-lg"></i> Asignar
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0 small">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3">ID Relación</th>
                                            <th>Género Asignado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($generos)): ?>
                                            <tr><td colspan="2" class="text-center py-3 text-muted">Sin asignaciones.</td></tr>
                                        <?php else: ?>
                                            <?php foreach ($generos as $g): ?>
                                                <tr>
                                                    <td class="ps-3 text-muted fw-bold">#<?= $g['idgeneropersona'] ?></td>
                                                    <td>
                                                        <a href="<?= base_url('generopersona/actual/' . $g['idgeneropersona']) ?>" class="badge bg-primary text-decoration-none">
                                                            <?= esc($g['genero_nombre']) ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
