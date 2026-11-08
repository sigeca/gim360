<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <?php if (empty($medicacion)): ?>
            <?= view('layout/empty_record', ['module' => 'medicacion']) ?>
        <?php else: ?>
            <?= view('layout/nav_toolbar', ['module' => 'medicacion', 'currentId' => $medicacion['idmedicacion']]) ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Ficha Principal de la Medicación -->
            <div class="card card-custom bg-white border-top border-4 border-primary shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-prescription2 text-primary me-2 fs-4"></i>Medicación: <?= esc($medicacion['nombre']) ?>
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <a href="<?= base_url('mimedicacion/add?idmedicacion=' . $medicacion['idmedicacion']) ?>" class="btn btn-sm btn-info text-dark fw-bold">
                            <i class="bi bi-person-check-fill me-1"></i>Personalizar en Mi Medicación
                        </a>
                        <span class="badge bg-primary text-white fs-6">ID #<?= $medicacion['idmedicacion'] ?></span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-4 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-clipboard2-pulse fs-1"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1"><?= esc($medicacion['nombre']) ?></h6>
                                <div class="text-danger small fw-semibold"><i class="bi bi-heart-pulse me-1"></i><?= esc($medicacion['afeccion_nombre']) ?></div>
                                <span class="badge bg-primary-subtle text-primary border mt-2">
                                    <i class="bi bi-capsule me-1"></i><?= count($medicacion['medicamentos'] ?? []) ?> Medicamentos
                                </span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered align-middle">
                                <tr>
                                    <th class="table-light w-35 text-muted">Afección a Aliviar</th>
                                    <td>
                                        <a href="<?= base_url('afeccion/actual/' . $medicacion['idafeccion']) ?>" class="fw-bold text-danger text-decoration-none">
                                            <i class="bi bi-arrow-right-circle me-1"></i><?= esc($medicacion['afeccion_nombre']) ?>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Duración Estimada</th>
                                    <td><span class="badge bg-light text-dark border"><?= esc($medicacion['duracion'] ?: 'Según criterio médico') ?></span></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Descripción del Protocolo</th>
                                    <td class="text-secondary"><?= !empty($medicacion['descripcion']) ? nl2br(esc($medicacion['descripcion'])) : '<span class="text-muted fst-italic">Sin descripción</span>' ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Recomendaciones y Cuidados</th>
                                    <td class="text-secondary"><?= !empty($medicacion['recomendaciones']) ? nl2br(esc($medicacion['recomendaciones'])) : '<span class="text-muted fst-italic">Sin recomendaciones adicionales</span>' ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medicamentos Contemplados en la Medicación -->
            <div class="card card-custom bg-white shadow-sm border-start border-4 border-success mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-capsule text-success me-2"></i>Medicamentos que contempla esta Medicación (<code>medicacionmedicamento</code>)
                        <span class="badge bg-success ms-1"><?= count($medicacion['medicamentos'] ?? []) ?></span>
                    </h6>
                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="collapse" data-bs-target="#boxSumarMedicamento">
                        <i class="bi bi-plus-circle me-1"></i>+ Agregar Medicamento
                    </button>
                </div>

                <!-- Desplegable para agregar medicamento a la medicación -->
                <div class="collapse p-3 bg-light border-bottom" id="boxSumarMedicamento">
                    <form action="<?= base_url('medicacion/agregarMedicamento/' . $medicacion['idmedicacion']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row g-2 align-items-end">
                            <div class="col-md-5">
                                <label class="form-label small fw-bold">Elegir medicamento existente:</label>
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
                            <div class="col-md-9">
                                <label class="form-label small fw-bold">Instrucciones terapéuticas:</label>
                                <input type="text" name="instrucciones" class="form-control form-control-sm" placeholder="Ej: Tomar con abundante agua por 5 días">
                            </div>
                            <div class="col-md-3 text-end">
                                <button type="submit" class="btn btn-sm btn-success w-100"><i class="bi bi-check-lg me-1"></i>Vincular</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body p-0">
                    <?php if (empty($medicacion['medicamentos'])): ?>
                        <div class="p-3 text-center text-muted small">No hay medicamentos vinculados a este protocolo de medicación.</div>
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
                                    <?php foreach ($medicacion['medicamentos'] as $m): ?>
                                        <tr>
                                            <td class="ps-3 fw-bold text-muted">#<?= $m['idmedicacionmedicamento'] ?></td>
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
                                                    <a href="<?= base_url('medicacionmedicamento/actual/' . $m['idmedicacionmedicamento']) ?>" class="btn btn-outline-primary" title="Ver detalle"><i class="bi bi-eye"></i></a>
                                                    <a href="<?= base_url('medicacionmedicamento/delete/' . $m['idmedicacionmedicamento']) ?>" class="btn btn-outline-danger" title="Desvincular" onclick="return confirm('¿Quitar este medicamento de la medicación?');"><i class="bi bi-trash"></i></a>
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
