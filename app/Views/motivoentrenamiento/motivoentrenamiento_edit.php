<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-pencil-square text-warning me-2"></i>Editar Motivo de Entrenamiento</h2>
                <p class="text-muted mb-0">Modificar información del registro en la tabla <code>motivoentrenamiento</code>.</p>
            </div>
            <a href="<?= base_url('motivoentrenamiento/actual/' . $motivo['idmotivoentrenamiento']) ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver a Registro
            </a>
        </div>

        <div class="card card-custom bg-white border-top border-4 border-warning shadow-sm">
            <div class="card-body p-4">
                <form action="<?= base_url('motivoentrenamiento/update/' . $motivo['idmotivoentrenamiento']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label text-muted fw-semibold">ID Motivo</label>
                            <input type="text" class="form-control bg-light" value="<?= $motivo['idmotivoentrenamiento'] ?>" readonly>
                        </div>

                        <!-- Nombre del Motivo -->
                        <div class="col-md-5">
                            <label for="nombre" class="form-label fw-semibold">Nombre del Motivo <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" id="nombre" value="<?= old('nombre', $motivo['nombre']) ?>" class="form-control" maxlength="100" required autofocus>
                        </div>

                        <!-- Dimensión -->
                        <div class="col-md-4">
                            <label for="dimension" class="form-label fw-semibold">Dimensión / Enfoque</label>
                            <select name="dimension" id="dimension" class="form-select">
                                <option value="">-- Seleccionar Enfoque --</option>
                                <option value="Salud" <?= old('dimension', $motivo['dimension'] ?? '') === 'Salud' ? 'selected' : '' ?>>Salud (Biológico / Preventivo)</option>
                                <option value="Estética Física" <?= old('dimension', $motivo['dimension'] ?? '') === 'Estética Física' ? 'selected' : '' ?>>Estética Física (Composición / Modelado)</option>
                            </select>
                        </div>

                        <!-- Descripción / Objetivo -->
                        <div class="col-12">
                            <label for="objetivo" class="form-label fw-semibold">Descripción de la Necesidad / Objetivo</label>
                            <textarea name="objetivo" id="objetivo" class="form-control" rows="4"><?= old('objetivo', $motivo['objetivo']) ?></textarea>
                            <div class="form-text">Detalla cómo el ejercicio responde a esta necesidad biológica o estética.</div>
                        </div>

                        <!-- Foto / Imagen del Repositorio -->
                        <div class="col-md-7">
                            <label for="imagenSelect" class="form-label fw-semibold">
                                <i class="bi bi-image me-1 text-warning"></i>Foto de Persona que Representa la Necesidad
                            </label>
                            <select name="imagen" id="imagenSelect" class="form-select">
                                <option value="">-- Seleccionar imagen disponible --</option>
                                <?php if (!empty($availableImages)): ?>
                                    <?php foreach ($availableImages as $img): ?>
                                        <option value="<?= esc($img) ?>" <?= old('imagen', $motivo['imagen'] ?? '') === $img ? 'selected' : '' ?>>
                                            <?= esc($img) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="form-text">Selecciona una fotografía disponible en <code>repositorio/motivos/</code>.</div>
                        </div>

                        <!-- Vista Previa de la Foto en Tiempo Real -->
                        <div class="col-md-5 text-center">
                            <label class="form-label fw-semibold small text-muted d-block">Previsualización de la Persona</label>
                            <div class="p-2 bg-light rounded-3 border d-inline-block w-100" style="min-height: 180px;">
                                <img id="previewImg" src="" alt="Vista previa" class="img-fluid rounded shadow-sm" style="max-height: 160px; object-fit: cover; display: none;">
                                <div id="noPreviewText" class="text-muted py-4">
                                    <i class="bi bi-person-bounding-box fs-1 d-block mb-1 text-secondary"></i>
                                    <small>Seleccione una imagen para verla aquí</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="<?= base_url('motivoentrenamiento/actual/' . $motivo['idmotivoentrenamiento']) ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Motivo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('imagenSelect');
    const preview = document.getElementById('previewImg');
    const noPreview = document.getElementById('noPreviewText');
    const baseUrl = '<?= base_url('repositorio/motivos') ?>/';
    const fallbackUrl = '<?= base_url('motivoentrenamiento/imagen') ?>/';

    function updatePreview() {
        if (select && select.value) {
            preview.onerror = function() {
                this.onerror = null;
                this.src = fallbackUrl + encodeURIComponent(select.value);
            };
            preview.src = baseUrl + encodeURIComponent(select.value);
            preview.style.display = 'block';
            noPreview.style.display = 'none';
        } else {
            preview.style.display = 'none';
            noPreview.style.display = 'block';
        }
    }

    if (select) {
        select.addEventListener('change', updatePreview);
        updatePreview();
    }
});
</script>

<?= $this->endSection() ?>
