<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Encabezado con buscador y botón de nuevo -->
    <div class="card card-custom bg-white shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1 d-flex align-items-center">
                        <i class="bi bi-heart-pulse-fill text-success me-2 fs-3"></i>Control Nutricional de Personas
                    </h4>
                    <p class="text-muted small mb-0">Seguimiento de peso corporal, estatura, cálculo automático de IMC y composición física.</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form action="<?= base_url('perfilnutricional/listar') ?>" method="get" class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm">
                            <input type="text" name="q" class="form-control" placeholder="Buscar por persona, cédula..." value="<?= esc($search ?? '') ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                            <?php if (!empty($search)): ?>
                                <a href="<?= base_url('perfilnutricional/listar') ?>" class="btn btn-outline-secondary" title="Limpiar búsqueda">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>

                    <a href="<?= base_url('perfilnutricional/add') ?>" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Nueva Medición
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Registros -->
    <div class="card card-custom bg-white shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 70px;">ID</th>
                            <th>Persona</th>
                            <th>Fecha</th>
                            <th class="text-center">Peso</th>
                            <th class="text-center">Estatura</th>
                            <th class="text-center">IMC</th>
                            <th class="text-center">Clasificación</th>
                            <th class="text-end pe-4" style="width: 170px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($perfiles)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No se encontraron registros de control nutricional.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($perfiles as $p): ?>
                                <?php $fotoUrl = 'https://educaysoft.org/descargar.php?archivo=fotos/' . rawurlencode(trim($p['cedula'] ?? '')) . '.jpg'; ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $p['idperfilnutricional'] ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="<?= esc($fotoUrl) ?>"
                                                 alt="<?= esc($p['nombres']) ?>"
                                                 class="rounded-circle border"
                                                 style="width: 38px; height: 38px; object-fit: cover;"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="bg-light border text-secondary rounded-circle align-items-center justify-content-center" style="width: 38px; height: 38px; display: none;">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            <div>
                                                <a href="<?= base_url('perfilnutricional/actual/' . $p['idperfilnutricional']) ?>" class="fw-bold text-dark text-decoration-none">
                                                    <?= esc($p['apellidos'] . ' ' . $p['nombres']) ?>
                                                </a>
                                                <div class="small text-muted font-monospace">C.I. <?= esc($p['cedula']) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="small text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            <?= !empty($p['fechamedicion']) ? date('d/m/Y', strtotime($p['fechamedicion'])) : '-' ?>
                                        </span>
                                    </td>
                                    <td class="text-center fw-bold">
                                        <?= number_format((float)$p['peso_kg'], 2) ?> kg
                                    </td>
                                    <td class="text-center text-muted">
                                        <?= number_format((float)$p['estatura_cm'], 1) ?> cm
                                    </td>
                                    <td class="text-center fw-bold text-success">
                                        <?= $p['imc'] !== null ? number_format($p['imc'], 2) : '-' ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge <?= esc($p['clasificacion']['badge_class']) ?> px-2 py-1">
                                            <?= esc($p['clasificacion']['categoria']) ?>
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('perfilnutricional/actual/' . $p['idperfilnutricional']) ?>" class="btn btn-outline-primary" title="Ver Ficha">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('perfilnutricional/edit/' . $p['idperfilnutricional']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Borrar" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalDeleteList"
                                                    data-id="<?= $p['idperfilnutricional'] ?>"
                                                    data-persona="<?= esc($p['nombres'] . ' ' . $p['apellidos']) ?>"
                                                    data-fecha="<?= !empty($p['fechamedicion']) ? date('d/m/Y', strtotime($p['fechamedicion'])) : '' ?>">
                                                <i class="bi bi-trash"></i>
                                            </button>
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

</div>

<!-- Modal para eliminar desde la lista -->
<div class="modal fade" id="modalDeleteList" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formDeleteList" method="post" action="">
                <?= csrf_field() ?>
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-2">¿Está seguro de que desea eliminar la evaluación nutricional de:</p>
                    <h5 class="fw-bold text-danger text-center my-3" id="deleteTargetPersona"></h5>
                    <p class="small text-muted mb-0">Fecha de evaluación: <span id="deleteTargetFecha"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill me-1"></i>Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalDelete = document.getElementById('modalDeleteList');
    if (modalDelete) {
        modalDelete.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const persona = button.getAttribute('data-persona');
            const fecha = button.getAttribute('data-fecha');
            document.getElementById('deleteTargetPersona').textContent = persona;
            document.getElementById('deleteTargetFecha').textContent = fecha;
            document.getElementById('formDeleteList').action = '<?= base_url('perfilnutricional/delete/') ?>' + id;
        });
    }
});
</script>

<?= $this->endSection() ?>
