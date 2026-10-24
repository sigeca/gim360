<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-pencil-square text-warning me-2"></i>Editar Programa de Entrenamiento</h2>
                <p class="text-muted mb-0">Modificar relaciones de motivo, rutina o plan de ejercicio en <code>programaentrenamiento</code>.</p>
            </div>
            <a href="<?= base_url('programaentrenamiento/actual/' . $programa['idprogramaentrenamiento']) ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver a Registro
            </a>
        </div>

        <div class="card card-custom bg-white border-top border-4 border-warning">
            <div class="card-body p-4">
                <form action="<?= base_url('programaentrenamiento/update/' . $programa['idprogramaentrenamiento']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">ID Programa de Entrenamiento</label>
                        <input type="text" class="form-control bg-light" value="<?= $programa['idprogramaentrenamiento'] ?>" readonly>
                    </div>

                    <!-- Nombre del Programa -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">
                            <i class="bi bi-tag-fill text-success me-1"></i>Nombre del Programa <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Hipertrofia Principiante - Sentadilla" maxlength="100" value="<?= old('nombre', $programa['nombre'] ?? '') ?>" required autofocus>
                        <div class="form-text">Nombre descriptivo e identificativo del programa de entrenamiento.</div>
                    </div>

                    <!-- 1. Motivo de Entrenamiento -->
                    <div class="mb-3">
                        <label for="idmotivoentrenamiento" class="form-label fw-semibold">
                            <i class="bi bi-bullseye text-warning me-1"></i>Motivo de Entrenamiento <span class="text-danger">*</span>
                        </label>
                        <select name="idmotivoentrenamiento" id="idmotivoentrenamiento" class="form-select" required>
                            <option value="">-- Seleccione un Motivo --</option>
                            <?php foreach ($motivos as $m): ?>
                                <option value="<?= $m['idmotivoentrenamiento'] ?>" 
                                        data-nombre="<?= esc($m['nombre']) ?>"
                                        data-dimension="<?= esc($m['dimension'] ?? '') ?>"
                                        data-objetivo="<?= esc($m['objetivo'] ?? '') ?>"
                                        data-imagen="<?= esc($m['imagen'] ?? '') ?>"
                                        <?= old('idmotivoentrenamiento', $programa['idmotivoentrenamiento']) == $m['idmotivoentrenamiento'] ? 'selected' : '' ?>>
                                    <?= esc($m['nombre']) ?><?= !empty($m['dimension']) ? ' [' . esc($m['dimension']) . ']' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Objetivo general o necesidad biológica/estética que persigue la persona.</div>

                        <!-- Tarjeta de Representación Física de la Necesidad -->
                        <div id="motivoPreviewCard" class="card border border-warning-subtle bg-light-subtle rounded-3 mt-3 shadow-sm" style="display: none;">
                            <div class="card-body p-3">
                                <div class="row align-items-center g-3">
                                    <div class="col-sm-4 text-center">
                                        <img id="motivoPreviewImg" src="" alt="Representación Física" class="img-fluid rounded-2 shadow-sm w-100" style="max-height: 130px; object-fit: cover;">
                                        <div class="text-muted small mt-1 fst-italic">
                                            <i class="bi bi-person-check me-1"></i>Representación física
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <span id="motivoPreviewDimension" class="badge bg-success"></span>
                                            <strong id="motivoPreviewTitle" class="text-dark"></strong>
                                        </div>
                                        <p id="motivoPreviewDesc" class="text-secondary small mb-0" style="line-height: 1.45;"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Rango de Edad -->
                    <div class="mb-3">
                        <label for="idrangoedad" class="form-label fw-semibold">
                            <i class="bi bi-person-bounding-box text-info me-1"></i>Rango de Edad Recomendado
                        </label>
                        <select name="idrangoedad" id="idrangoedad" class="form-select">
                            <option value="">-- Sin rango específico (General / Todas las edades) --</option>
                            <?php if (!empty($rangos)): ?>
                                <?php foreach ($rangos as $r): ?>
                                    <option value="<?= $r['idrangoedad'] ?>" <?= old('idrangoedad', $programa['idrangoedad'] ?? '') == $r['idrangoedad'] ? 'selected' : '' ?>>
                                        <?= esc($r['nombre']) ?> (<?= (int)$r['edadminima'] ?> a <?= (int)$r['edadmaxima'] ?> años)
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <div class="form-text">Segmento etario al que está orientado este programa de entrenamiento.</div>
                    </div>

                    <!-- 3. Tren Muscular -->
                    <div class="mb-3">
                        <label for="idtrenmuscular" class="form-label fw-semibold">
                            <i class="bi bi-layers-half text-info me-1"></i>Tren Muscular Enfoque
                        </label>
                        <select name="idtrenmuscular" id="idtrenmuscular" class="form-select">
                            <option value="">-- Sin tren específico (General / Full Body) --</option>
                            <?php if (!empty($trenes)): ?>
                                <?php foreach ($trenes as $t): ?>
                                    <option value="<?= $t['idtrenmuscular'] ?>" <?= old('idtrenmuscular', $programa['idtrenmuscular'] ?? '') == $t['idtrenmuscular'] ? 'selected' : '' ?>>
                                        <?= esc($t['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <div class="form-text">Región o división anatómica en la que se enfoca el programa (Tren Superior, Tren Inferior, etc.).</div>
                    </div>

                    <div class="alert alert-light border small text-muted d-flex align-items-center gap-2 mb-4">
                        <i class="bi bi-info-circle-fill text-info fs-5"></i>
                        <div>
                            <strong>Nota:</strong> Un programa de entrenamiento puede tener múltiples rutinas de ejercicio. Las rutinas se gestionan en el módulo <a href="<?= base_url('rutinaprograma') ?>" target="_blank" class="fw-semibold text-info">Rutinas en Programas</a>.
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('programaentrenamiento/actual/' . $programa['idprogramaentrenamiento']) ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Programa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('idmotivoentrenamiento');
    const card = document.getElementById('motivoPreviewCard');
    const img = document.getElementById('motivoPreviewImg');
    const title = document.getElementById('motivoPreviewTitle');
    const dimensionBadge = document.getElementById('motivoPreviewDimension');
    const desc = document.getElementById('motivoPreviewDesc');
    const baseUrl = '<?= base_url('repositorio/motivos') ?>/';
    const fallbackUrl = '<?= base_url('motivoentrenamiento/imagen') ?>/';

    function updateMotivoPreview() {
        const selected = select.options[select.selectedIndex];
        if (!selected || !selected.value) {
            card.style.display = 'none';
            return;
        }

        const imagen = selected.getAttribute('data-imagen');
        const nombre = selected.getAttribute('data-nombre');
        const dimension = selected.getAttribute('data-dimension');
        const objetivo = selected.getAttribute('data-objetivo');

        title.textContent = nombre || '';
        desc.textContent = objetivo || 'Sin descripción registrada.';

        if (dimension) {
            dimensionBadge.textContent = dimension;
            dimensionBadge.className = 'badge ' + (dimension === 'Salud' ? 'bg-success' : 'bg-primary');
            dimensionBadge.style.display = 'inline-block';
        } else {
            dimensionBadge.style.display = 'none';
        }

        if (imagen) {
            img.onerror = function() {
                this.onerror = null;
                this.src = fallbackUrl + encodeURIComponent(imagen);
            };
            img.src = baseUrl + encodeURIComponent(imagen);
            img.style.display = 'block';
        } else {
            img.style.display = 'none';
        }

        card.style.display = 'block';
    }

    select.addEventListener('change', updateMotivoPreview);
    updateMotivoPreview();
});
</script>

<?= $this->endSection() ?>
