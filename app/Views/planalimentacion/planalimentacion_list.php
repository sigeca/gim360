<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Encabezado con buscador, filtro de persona y botón de nuevo -->
    <div class="card card-custom bg-white shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1 d-flex align-items-center">
                        <i class="bi bi-journal-medical text-success me-2 fs-3"></i>Planes de Alimentación
                    </h4>
                    <p class="text-muted small mb-0">Gestión de pautas nutricionales, fechas de vigencia y objetivos dietéticos personalizados por persona.</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form action="<?= base_url('planalimentacion/listar') ?>" method="get" class="d-flex flex-wrap align-items-center gap-2">
                        <!-- Filtro por Persona -->
                        <select name="idpersona" class="form-select form-select-sm" style="min-width: 200px;" onchange="this.form.submit()">
                            <option value="">-- Todas las Personas --</option>
                            <?php foreach ($personas as $p): ?>
                                <option value="<?= $p['idpersona'] ?>" <?= (isset($selectedPersona) && (string)$selectedPersona === (string)$p['idpersona']) ? 'selected' : '' ?>>
                                    <?= esc($p['apellidos']) ?>, <?= esc($p['nombres']) ?> (<?= esc($p['cedula']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Buscador de texto -->
                        <div class="input-group input-group-sm">
                            <input type="text" name="q" class="form-control" placeholder="Buscar plan, persona o cédula..." value="<?= esc($search ?? '') ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                            <?php if (!empty($search) || !empty($selectedPersona)): ?>
                                <a href="<?= base_url('planalimentacion/listar') ?>" class="btn btn-outline-secondary" title="Limpiar filtros">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>

                    <a href="<?= base_url('planalimentacion/add' . (!empty($selectedPersona) ? '?idpersona=' . $selectedPersona : '')) ?>" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Nuevo Plan
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
                            <th>Plan de Alimentación</th>
                            <th>Período de Vigencia</th>
                            <th>Estado</th>
                            <th>Objetivo</th>
                            <th class="text-end pe-4" style="width: 170px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($planes)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No se encontraron planes de alimentación registrados con los criterios seleccionados.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($planes as $pl): ?>
                                <?php $fotoUrl = 'https://educaysoft.org/descargar.php?archivo=fotos/' . rawurlencode(trim($pl['cedula'] ?? '')) . '.jpg'; ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $pl['idplanalimentacion'] ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="<?= esc($fotoUrl) ?>" target="_blank" title="Ver foto de <?= esc($pl['nombres']) ?>" class="text-decoration-none flex-shrink-0">
                                                <img src="<?= esc($fotoUrl) ?>"
                                                     alt="Foto <?= esc($pl['nombres']) ?>"
                                                     class="rounded-circle border shadow-sm"
                                                     style="width: 38px; height: 38px; object-fit: cover;"
                                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                <div class="bg-light border text-secondary rounded-circle align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px; display: none;">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            </a>
                                            <div>
                                                <div class="fw-bold text-dark fs-6">
                                                    <a href="<?= base_url('persona/actual/' . $pl['idpersona']) ?>" class="text-decoration-none text-dark">
                                                        <?= esc($pl['apellidos']) ?>, <?= esc($pl['nombres']) ?>
                                                    </a>
                                                </div>
                                                <small class="text-muted"><i class="bi bi-credit-card-2-front me-1"></i>C.I. <?= esc($pl['cedula']) ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark">
                                            <i class="bi bi-bookmark-check-fill text-success me-1"></i><?= esc($pl['nombre']) ?>
                                        </span>
                                    </td>
                                    <td class="small">
                                        <div class="text-dark fw-semibold">
                                            <i class="bi bi-calendar-event me-1 text-primary"></i>Desde: <?= esc($pl['fechainicio']) ?>
                                        </div>
                                        <div class="text-muted">
                                            <i class="bi bi-calendar2-check me-1 text-secondary"></i>Hasta: <?= !empty($pl['fechafin']) ? esc($pl['fechafin']) : '<span class="fst-italic">Indefinido</span>' ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge <?= $pl['estado_info']['badge_class'] ?>">
                                            <i class="bi <?= $pl['estado_info']['icono'] ?> me-1"></i><?= $pl['estado_info']['etiqueta'] ?>
                                        </span>
                                    </td>
                                    <td class="text-secondary small" style="max-width: 280px;">
                                        <?php if (!empty($pl['objetivonutricional_nombre'])): ?>
                                            <div class="mb-1">
                                                <a href="<?= base_url('objetivonutricional/actual/' . $pl['idobjetivonutricional']) ?>" class="badge bg-warning-subtle text-dark border border-warning text-decoration-none">
                                                    <i class="bi bi-bullseye text-warning me-1"></i><?= esc($pl['objetivonutricional_nombre']) ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        <?= !empty($pl['objetivo']) ? esc($pl['objetivo']) : '<span class="text-muted fst-italic">Sin observaciones</span>' ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('planalimentacion/actual/' . $pl['idplanalimentacion']) ?>" class="btn btn-outline-primary" title="Ver Ficha">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('planalimentacion/edit/' . $pl['idplanalimentacion']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Borrar" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalDeletePlan"
                                                    data-id="<?= $pl['idplanalimentacion'] ?>"
                                                    data-nombre="<?= esc($pl['nombre']) ?>"
                                                    data-persona="<?= esc($pl['apellidos'] . ' ' . $pl['nombres']) ?>">
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

<!-- Modal para eliminar plan -->
<div class="modal fade" id="modalDeletePlan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formDeletePlan" method="post" action="">
                <?= csrf_field() ?>
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-2">¿Está seguro de que desea eliminar el plan de alimentación:</p>
                    <h5 class="fw-bold text-danger text-center my-3" id="deleteTargetPlan"></h5>
                    <p class="text-center text-muted mb-0 small" id="deleteTargetPersona"></p>
                    <p class="small text-danger text-center mt-3 mb-0">Esta acción no se puede deshacer.</p>
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
    const modalDelete = document.getElementById('modalDeletePlan');
    if (modalDelete) {
        modalDelete.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nombre = button.getAttribute('data-nombre');
            const persona = button.getAttribute('data-persona');
            document.getElementById('deleteTargetPlan').textContent = nombre;
            document.getElementById('deleteTargetPersona').textContent = 'Asignado a: ' + persona;
            document.getElementById('formDeletePlan').action = '<?= base_url('planalimentacion/delete/') ?>' + id;
        });
    }
});
</script>

<?= $this->endSection() ?>
