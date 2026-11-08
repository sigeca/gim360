<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <?php if (empty($mimedicacion)): ?>
            <?= view('layout/empty_record', ['module' => 'mimedicacion']) ?>
        <?php else: ?>
            <?= view('layout/nav_toolbar', ['module' => 'mimedicacion', 'currentId' => $mimedicacion['idmimedicacion']]) ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Ficha Principal de Mi Medicación -->
            <div class="card card-custom bg-white border-top border-4 border-info shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-person-heart text-info me-2 fs-4"></i>Mi Medicación: <?= esc($mimedicacion['nombre']) ?>
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <?php if (!empty($mimedicacion['idmedicacion'])): ?>
                            <a href="<?= base_url('medicacion/actual/' . $mimedicacion['idmedicacion']) ?>" class="badge bg-light text-primary border text-decoration-none">
                                <i class="bi bi-prescription2 me-1"></i>Base: <?= esc($mimedicacion['base_medicacion_nombre'] ?: ('#' . $mimedicacion['idmedicacion'])) ?>
                            </a>
                        <?php endif; ?>
                        <span class="badge bg-<?= ($mimedicacion['estado'] === 'Activa') ? 'success' : 'secondary' ?> fs-6"><?= esc($mimedicacion['estado'] ?: 'Activa') ?></span>
                        <span class="badge bg-info text-dark fs-6">ID #<?= $mimedicacion['idmimedicacion'] ?></span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-4 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-info bg-opacity-10 text-info d-inline-flex align-items-center justify-content-center mb-3" style="width: 85px; height: 85px;">
                                    <i class="bi bi-person-fill-check fs-1"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">
                                    <a href="<?= base_url('persona/actual/' . $mimedicacion['idpersona']) ?>" class="text-dark text-decoration-none">
                                        <?= esc($mimedicacion['persona_apellidos'] . ' ' . $mimedicacion['persona_nombres']) ?>
                                    </a>
                                </h6>
                                <p class="text-muted small mb-2"><i class="bi bi-card-text me-1"></i>C.I. <?= esc($mimedicacion['persona_cedula'] ?: '-') ?></p>

                                <div class="d-flex flex-wrap justify-content-center gap-1 mt-2">
                                    <span class="badge bg-danger-subtle text-danger border">
                                        <i class="bi bi-heart-pulse me-1"></i><?= esc($mimedicacion['afeccion_nombre'] ?: 'General') ?>
                                    </span>
                                    <span class="badge bg-success-subtle text-success border">
                                        <i class="bi bi-capsule me-1"></i><?= count($mimedicacion['medicamentos'] ?? []) ?> Medicamentos
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <table class="table table-bordered align-middle mb-0">
                                <tr>
                                    <th class="table-light w-35 text-muted">Persona Propietaria</th>
                                    <td class="fs-6 fw-bold text-dark">
                                        <a href="<?= base_url('persona/actual/' . $mimedicacion['idpersona']) ?>" class="text-decoration-none">
                                            <?= esc($mimedicacion['persona_apellidos'] . ' ' . $mimedicacion['persona_nombres']) ?>
                                        </a>
                                        <span class="badge bg-secondary ms-1">C.I. <?= esc($mimedicacion['persona_cedula']) ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Afección / Motivo</th>
                                    <td>
                                        <?php if (!empty($mimedicacion['idafeccion'])): ?>
                                            <a href="<?= base_url('afeccion/actual/' . $mimedicacion['idafeccion']) ?>" class="badge bg-danger-subtle text-danger border text-decoration-none fs-6">
                                                <i class="bi bi-heart-pulse me-1"></i><?= esc($mimedicacion['afeccion_nombre']) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted fst-italic">No especificada</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Médico / Especialista</th>
                                    <td class="text-secondary"><?= esc($mimedicacion['medicotratante'] ?: 'No registrado') ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Período de Tratamiento</th>
                                    <td>
                                        <i class="bi bi-calendar-event me-1 text-primary"></i>Inicio: <?= esc($mimedicacion['fechainicio'] ?: '-') ?>
                                        <?= !empty($mimedicacion['fechafin']) ? ' | Fin: ' . esc($mimedicacion['fechafin']) : '' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Descripción Personal</th>
                                    <td class="text-secondary"><?= !empty($mimedicacion['descripcion']) ? nl2br(esc($mimedicacion['descripcion'])) : '<span class="text-muted fst-italic">Sin descripción</span>' ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medicamentos en Mi Medicación -->
            <div class="card card-custom bg-white shadow-sm border-start border-4 border-success mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-capsule text-success me-2"></i>Medicamentos en Mi Tratamiento Personal (<code>mimedicacionmedicamento</code>)
                        <span class="badge bg-success ms-1"><?= count($mimedicacion['medicamentos'] ?? []) ?></span>
                    </h6>
                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="collapse" data-bs-target="#boxSumarMedicamentoPersonal">
                        <i class="bi bi-plus-circle me-1"></i>+ Sumar Medicamento
                    </button>
                </div>

                <!-- Formulario desplegable para sumar medicamento -->
                <div class="collapse p-3 bg-light border-bottom" id="boxSumarMedicamentoPersonal">
                    <form action="<?= base_url('mimedicacion/agregarMedicamento/' . $mimedicacion['idmimedicacion']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row g-2 align-items-end">
                            <div class="col-md-5">
                                <label class="form-label small fw-bold">Elegir del catálogo existente:</label>
                                <select name="idmedicamento" class="form-select form-select-sm">
                                    <option value="">-- Seleccionar Medicamento --</option>
                                    <?php foreach ($catalogoMedicamentos as $cmed): ?>
                                        <option value="<?= $cmed['idmedicamento'] ?>"><?= esc($cmed['nombre']) ?> [<?= esc($cmed['concentracion'] ?: 'N/A') ?>]</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Dosis prescrita:</label>
                                <input type="text" name="dosis" class="form-control form-control-sm" placeholder="Ej: 1 tableta (400 mg)">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Frecuencia:</label>
                                <input type="text" name="frecuencia" class="form-control form-control-sm" placeholder="Ej: Cada 8 horas tras comer">
                            </div>
                            <div class="col-md-9 mt-2">
                                <label class="form-label small fw-bold">Instrucciones terapéuticas:</label>
                                <input type="text" name="instrucciones" class="form-control form-control-sm" placeholder="Ej: Tomar con comida por 7 días">
                            </div>
                            <div class="col-md-3 mt-2 text-end">
                                <button type="submit" class="btn btn-sm btn-success w-100"><i class="bi bi-check-lg me-1"></i>Sumar a Mi Lista</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body p-0">
                    <?php if (empty($mimedicacion['medicamentos'])): ?>
                        <div class="p-3 text-center text-muted small">No hay medicamentos asignados a tu lista personal de medicación.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light small">
                                    <tr>
                                        <th class="ps-3">ID Rel.</th>
                                        <th>Medicamento</th>
                                        <th>Principio Activo</th>
                                        <th>Dosis</th>
                                        <th>Frecuencia</th>
                                        <th>Instrucciones</th>
                                        <th class="text-end pe-3">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($mimedicacion['medicamentos'] as $m): ?>
                                        <tr>
                                            <td class="ps-3 fw-bold text-muted">#<?= $m['idmimedicacionmedicamento'] ?></td>
                                            <td>
                                                <a href="<?= base_url('medicamento/actual/' . $m['idmedicamento']) ?>" class="fw-bold text-dark text-decoration-none">
                                                    <?= esc($m['medicamento_nombre']) ?>
                                                </a>
                                                <div class="small text-muted"><?= esc($m['presentacion'] ?: '') ?></div>
                                            </td>
                                            <td><span class="text-primary small"><?= esc($m['principioactivo'] ?: '-') ?></span></td>
                                            <td><span class="badge bg-light text-dark border"><?= esc($m['dosis'] ?: '-') ?></span></td>
                                            <td><span class="text-secondary small"><?= esc($m['frecuencia'] ?: '-') ?></span></td>
                                            <td class="small text-secondary"><?= esc($m['instrucciones'] ?: '-') ?></td>
                                            <td class="text-end pe-3">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?= base_url('mimedicacionmedicamento/actual/' . $m['idmimedicacionmedicamento']) ?>" class="btn btn-outline-primary" title="Ver relación"><i class="bi bi-eye"></i></a>
                                                    <a href="<?= base_url('mimedicacionmedicamento/delete/' . $m['idmimedicacionmedicamento']) ?>" class="btn btn-outline-danger" title="Quitar" onclick="return confirm('¿Quitar este medicamento de tu medicación?');"><i class="bi bi-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
