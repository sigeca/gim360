<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-person-arms-up text-danger me-2"></i>Nuevo Músculo
                </h2>
                <p class="text-muted mb-0">Registrar un nuevo grupo muscular o vincular una imagen del repositorio.</p>
            </div>
            <a href="<?= base_url('musculo/elprimero') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver a Registro
            </a>
        </div>

        <div class="card card-custom bg-white border-top border-4 border-danger shadow-sm">
            <div class="card-body p-4">
                <form action="<?= base_url('musculo/save') ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- Nombre del Músculo -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">
                            Nombre del Músculo <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nombre" id="nombre" class="form-control" 
                               value="<?= esc(old('nombre')) ?>" 
                               placeholder="Ej. Deltoides Lateral, Bíceps Braquial..." required autofocus>
                        <div class="form-text">Nombre descriptivo en español del músculo o grupo muscular.</div>
                    </div>

                    <!-- Archivo de Imagen del Repositorio -->
                    <div class="mb-3">
                        <label for="imagenSelect" class="form-label fw-semibold">
                            <i class="bi bi-image me-1"></i>Imagen en <code>repositorio/images/muscles</code>
                        </label>
                        <select name="imagen" id="imagenSelect" class="form-select">
                            <option value="">-- Seleccionar imagen disponible --</option>
                            <?php foreach ($availableImages as $img): ?>
                                <option value="<?= esc($img) ?>" <?= old('imagen') === $img ? 'selected' : '' ?>>
                                    <?= esc($img) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Selecciona un archivo <code>.webp</code> disponible en el repositorio.</div>
                    </div>

                    <!-- Previsualización en tiempo real -->
                    <div class="mb-4 text-center">
                        <label class="form-label fw-semibold d-block small text-muted">Vista previa de la imagen</label>
                        <div class="p-3 bg-light rounded-3 border d-inline-block" style="min-width: 220px; min-height: 180px;">
                            <img id="previewImg" src="" alt="Vista previa" class="img-fluid" style="max-height: 160px; display: none;">
                            <div id="noPreviewText" class="text-muted py-4">
                                <i class="bi bi-image fs-1 d-block mb-1"></i>
                                <small>Seleccione una imagen para verla aquí</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('musculo/elprimero') ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-danger text-white fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Guardar Músculo
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
    const baseUrl = '<?= base_url('repositorio/images/muscles') ?>/';
    const fallbackUrl = '<?= base_url('uploads/muscles') ?>/';

    function updatePreview() {
        if (select.value) {
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

    select.addEventListener('change', updatePreview);
    updatePreview();
});
</script>

<?= $this->endSection() ?>
