<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-link-45deg text-warning me-2"></i>Asignar Plan a Rutina</h2>
                <p class="text-muted mb-0">Formulario para asociar una rutina con un plan de ejercicio en <code>rutinaplan</code>.</p>
            </div>
            <a href="<?= base_url('rutinaplan/elprimero') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver a Registro
            </a>
        </div>

        <div class="card card-custom bg-white border-top border-4 border-warning shadow-sm">
            <div class="card-body p-4">
                <form action="<?= base_url('rutinaplan/save') ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- 1. Rutina de Ejercicio -->
                    <div class="mb-3">
                        <label for="idrutinaejercicio" class="form-label fw-semibold">
                            <i class="bi bi-calendar2-week text-info me-1"></i>Rutina de Ejercicio <span class="text-danger">*</span>
                        </label>
                        <select name="idrutinaejercicio" id="idrutinaejercicio" class="form-select" required autofocus>
                            <option value="">-- Seleccione una Rutina --</option>
                            <?php foreach ($rutinas as $r): ?>
                                <option value="<?= $r['idrutinaejercicio'] ?>" <?= old('idrutinaejercicio', $idrutinaPreselected ?? '') == $r['idrutinaejercicio'] ? 'selected' : '' ?>>
                                    <?= esc($r['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Estructura o split de entrenamiento al que pertenecerá el plan.</div>
                    </div>

                    <!-- 2. Plan de Ejercicio -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="idplanejercicio" class="form-label fw-semibold mb-0">
                                <i class="bi bi-card-checklist text-primary me-1"></i>Plan de Ejercicio <span class="text-danger">*</span>
                            </label>
                            <a href="<?= base_url('planejercicio/add') ?>" target="_blank" class="small text-decoration-none text-primary">
                                <i class="bi bi-plus-circle me-1"></i>Crear nuevo plan
                            </a>
                        </div>
                        <select name="idplanejercicio" id="idplanejercicio" class="form-select" required>
                            <option value="">-- Seleccione un Plan de Ejercicio --</option>
                            <?php foreach ($planes as $p): ?>
                                <option value="<?= $p['idplanejercicio'] ?>" 
                                        data-nombre="<?= esc($p['ejercicio_nombre']) ?>"
                                        data-imagen="<?= esc($p['ejercicio_imagen'] ?? '') ?>"
                                        <?= old('idplanejercicio', $idplanPreselected ?? '') == $p['idplanejercicio'] ? 'selected' : '' ?>>
                                    #<?= $p['idplanejercicio'] ?> - <?= !empty($p['nombre']) ? esc($p['nombre']) . ' (' . esc($p['ejercicio_nombre']) . ')' : esc($p['ejercicio_nombre']) ?> 
                                    [<?= $p['series'] ?? 0 ?>s × <?= $p['repeticiones'] ?? 0 ?>r, <?= $p['diassemanas'] ?? $p['dias'] ?? 0 ?>d, <?= number_format((float)($p['peso'] ?? 0), 2) ?> kg]
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Contiene el ejercicio con sus series, repeticiones, descanso y peso.</div>

                        <!-- Previsualización del Ejercicio Asignado al Plan -->
                        <div id="planEjercicioPreview" class="card border border-warning-subtle bg-light rounded-3 mt-3 p-3 shadow-sm" style="display: none;">
                            <div class="row align-items-center g-3">
                                <div class="col-sm-3 text-center">
                                    <img id="planEjercicioPreviewImg" src="" alt="Ejercicio" class="img-fluid rounded border bg-white" style="max-height: 100px; max-width: 100%; object-fit: contain;">
                                </div>
                                <div class="col-sm-9">
                                    <div class="small text-muted fw-bold mb-1"><i class="bi bi-fire text-danger me-1"></i>Ejercicio de este Plan:</div>
                                    <h6 id="planEjercicioPreviewNombre" class="fw-bold text-dark mb-1"></h6>
                                    <small id="planEjercicioPreviewFile" class="text-muted font-monospace d-block"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('rutinaplan/elprimero') ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Guardar Rutina-Plan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('idplanejercicio');
    const previewBox = document.getElementById('planEjercicioPreview');
    const previewImg = document.getElementById('planEjercicioPreviewImg');
    const previewNombre = document.getElementById('planEjercicioPreviewNombre');
    const previewFile = document.getElementById('planEjercicioPreviewFile');
    const imgBase = '<?= base_url('ejercicio/imagen') ?>/';

    function updatePlanPreview() {
        if (!select || !select.value) {
            if (previewBox) previewBox.style.display = 'none';
            return;
        }

        const opt = select.options[select.selectedIndex];
        const imagen = opt.getAttribute('data-imagen');
        const nombre = opt.getAttribute('data-nombre');

        if (nombre && previewNombre) previewNombre.textContent = nombre;
        if (previewFile) previewFile.textContent = imagen ? imagen : 'Sin archivo asignado';

        if (imagen && previewImg) {
            previewImg.src = imgBase + encodeURIComponent(imagen);
            previewImg.style.display = 'inline-block';
        } else if (previewImg) {
            previewImg.style.display = 'none';
        }

        if (previewBox) previewBox.style.display = 'block';
    }

    if (select) {
        select.addEventListener('change', updatePlanPreview);
        updatePlanPreview();
    }
});
</script>

<?= $this->endSection() ?>
