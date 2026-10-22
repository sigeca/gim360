<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-gear-wide-connected text-primary me-2"></i>Registrar Nuevo Equipo
                    </h5>
                    <a href="<?= base_url('equipo/listar') ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>
            <div class="card-body p-4">

                <form method="post" action="<?= base_url('equipo/save') ?>">
                    <?= csrf_field() ?>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="codigo" class="form-label fw-semibold">Código <span class="text-danger">*</span></label>
                            <input type="text" name="codigo" id="codigo" class="form-control font-monospace" placeholder="Ej: EQ-004" value="<?= old('codigo') ?>" required>
                        </div>
                        <div class="col-md-8">
                            <label for="nombre" class="form-label fw-semibold">Nombre del Equipo <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Banco Plano Olímpico" value="<?= old('nombre') ?>" required>
                        </div>
                    </div>

                    <!-- Archivo de Imagen del Repositorio -->
                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-7">
                            <label for="imagenSelect" class="form-label fw-semibold">
                                <i class="bi bi-image me-1"></i>Imagen en <code>repositorio/images/equipment</code>
                            </label>
                            <select name="imagen" id="imagenSelect" class="form-select">
                                <option value="">-- Sin imagen asignada --</option>
                                <?php if (!empty($availableImages)): ?>
                                    <?php foreach ($availableImages as $img): ?>
                                        <option value="<?= esc($img) ?>" <?= (old('imagen') === $img) ? 'selected' : '' ?>>
                                            <?= esc($img) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="form-text">Selecciona la foto del equipo desde el repositorio multimedia.</div>
                        </div>
                        <div class="col-md-5 text-center">
                            <div class="border rounded p-2 bg-light d-flex align-items-center justify-content-center" style="height: 140px;">
                                <img id="previewImg" src="" alt="Previsualización" class="img-fluid rounded" style="max-height: 120px; display: none; object-fit: contain;">
                                <span id="noPreviewText" class="text-muted small"><i class="bi bi-image fs-3 d-block"></i>Previsualización</span>
                            </div>
                        </div>
                    </div>

                    <!-- Video Demostrativo (YouTube) -->
                    <div class="mb-3">
                        <label for="video" class="form-label fw-semibold">
                            <i class="bi bi-youtube text-danger me-1"></i>URL de Video de YouTube (Uso y Guía del Equipo)
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-danger"><i class="bi bi-play-btn-fill"></i></span>
                            <input type="url" name="video" id="video" class="form-control" placeholder="https://www.youtube.com/watch?v=... o https://youtu.be/..." value="<?= old('video') ?>" maxlength="300">
                        </div>
                        <div class="form-text">Enlace web de YouTube que muestra el funcionamiento, postura y uso correcto de este equipo.</div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="id_tipo" class="form-label fw-semibold">Tipo / Categoría</label>
                            <select name="id_tipo" id="id_tipo" class="form-select">
                                <option value="">-- Seleccionar --</option>
                                <?php foreach ($tipos as $id => $name): ?>
                                    <option value="<?= $id ?>" <?= (old('id_tipo') == $id) ? 'selected' : '' ?>><?= esc($name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="id_marca" class="form-label fw-semibold">Marca Fabricante</label>
                            <select name="id_marca" id="id_marca" class="form-select">
                                <option value="">-- Seleccionar --</option>
                                <?php foreach ($marcas as $id => $name): ?>
                                    <option value="<?= $id ?>" <?= (old('id_marca') == $id) ? 'selected' : '' ?>><?= esc($name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="modelo" class="form-label fw-semibold">Modelo</label>
                            <input type="text" name="modelo" id="modelo" class="form-control" placeholder="Ej: Signature Series" value="<?= old('modelo') ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="numero_serie" class="form-label fw-semibold">Número de Serie</label>
                            <input type="text" name="numero_serie" id="numero_serie" class="form-control font-monospace" placeholder="Ej: SN-987654321" value="<?= old('numero_serie') ?>">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="id_ubicacion" class="form-label fw-semibold">Ubicación en el Gimnasio</label>
                            <select name="id_ubicacion" id="id_ubicacion" class="form-select">
                                <option value="">-- Seleccionar --</option>
                                <?php foreach ($ubicaciones as $id => $name): ?>
                                    <option value="<?= $id ?>" <?= (old('id_ubicacion') == $id) ? 'selected' : '' ?>><?= esc($name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="id_estado" class="form-label fw-semibold">Estado Físico / Desgaste</label>
                            <select name="id_estado" id="id_estado" class="form-select">
                                <?php foreach ($estados as $id => $name): ?>
                                    <option value="<?= $id ?>" <?= (old('id_estado', 1) == $id) ? 'selected' : '' ?>><?= esc($name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="iddisponibilidadequipo" class="form-label fw-semibold">
                                <i class="bi bi-clock-history text-info me-1"></i>Disponibilidad
                            </label>
                            <select name="iddisponibilidadequipo" id="iddisponibilidadequipo" class="form-select">
                                <?php foreach ($disponibilidades as $disp): ?>
                                    <option value="<?= $disp['iddisponibilidadequipo'] ?>" <?= (old('iddisponibilidadequipo', 1) == $disp['iddisponibilidadequipo']) ? 'selected' : '' ?>>
                                        <?= esc($disp['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="fecha_adquisicion" class="form-label fw-semibold">Fecha de Adquisición</label>
                            <input type="date" name="fecha_adquisicion" id="fecha_adquisicion" class="form-control" value="<?= old('fecha_adquisicion') ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="valor_adquisicion" class="form-label fw-semibold">Valor Adquisición ($)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" name="valor_adquisicion" id="valor_adquisicion" class="form-control" placeholder="0.00" value="<?= old('valor_adquisicion') ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="activo" class="form-label fw-semibold">Estado de Inventario</label>
                            <select name="activo" id="activo" class="form-select">
                                <option value="1" <?= (old('activo', '1') === '1') ? 'selected' : '' ?>>Activo</option>
                                <option value="0" <?= (old('activo') === '0') ? 'selected' : '' ?>>Inactivo / Retirado</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label fw-semibold">Descripción Técnica</label>
                        <textarea name="descripcion" id="descripcion" rows="2" class="form-control" placeholder="Características, dimensiones, capacidad máxima..."><?= old('descripcion') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="observaciones" class="form-label fw-semibold">Observaciones / Mantenimiento</label>
                        <textarea name="observaciones" id="observaciones" rows="2" class="form-control" placeholder="Frecuencia de mantenimiento, repuestos necesarios..."><?= old('observaciones') ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="<?= base_url('equipo') ?>" class="btn btn-light border px-4">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <i class="bi bi-save me-1"></i> Guardar Equipo
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
    const baseUrl = '<?= base_url('repositorio/images/equipment/placeholder.webp') ?>'.replace('placeholder.webp', '');
    const fallbackUrl = '<?= base_url('equipo/imagen') ?>/';

    function updatePreview() {
        if (select && select.value) {
            preview.onerror = function() {
                this.onerror = null;
                this.src = fallbackUrl + encodeURIComponent(select.value);
            };
            preview.src = baseUrl + encodeURIComponent(select.value);
            preview.style.display = 'block';
            if (noPreview) noPreview.style.display = 'none';
        } else {
            if (preview) preview.style.display = 'none';
            if (noPreview) noPreview.style.display = 'block';
        }
    }

    if (select) {
        select.addEventListener('change', updatePreview);
        updatePreview();
    }
});
</script>

<?= $this->endSection() ?>
