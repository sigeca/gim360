<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-pencil-square text-primary me-2"></i>Editar Equipo: <?= esc($equipo['nombre']) ?>
                    </h5>
                    <a href="<?= base_url('equipos/actual/' . $equipo['id_equipo']) ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>
            <div class="card-body p-4">

                <form method="post" action="<?= base_url('equipos/update/' . $equipo['id_equipo']) ?>">
                    <?= csrf_field() ?>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="codigo" class="form-label fw-semibold">Código <span class="text-danger">*</span></label>
                            <input type="text" name="codigo" id="codigo" class="form-control font-monospace" value="<?= old('codigo', $equipo['codigo']) ?>" required>
                        </div>
                        <div class="col-md-8">
                            <label for="nombre" class="form-label fw-semibold">Nombre del Equipo <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="<?= old('nombre', $equipo['nombre']) ?>" required>
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
                                        <option value="<?= esc($img) ?>" <?= (old('imagen', $equipo['imagen']) === $img) ? 'selected' : '' ?>>
                                            <?= esc($img) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="form-text">Selecciona o cambia la foto del equipo desde el repositorio multimedia.</div>
                        </div>
                        <div class="col-md-5 text-center">
                            <label class="form-label fw-semibold small text-muted d-block mb-1">Vista previa</label>
                            <div class="p-2 bg-light rounded border d-flex align-items-center justify-content-center" style="min-height: 120px;">
                                <img id="previewImg" src="" alt="Vista previa" class="img-fluid rounded" style="max-height: 105px; display: none;">
                                <div id="noPreviewText" class="text-muted small">
                                    <i class="bi bi-image fs-3 d-block mb-1"></i>
                                    <span>Sin previsualización</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="id_tipo" class="form-label fw-semibold">Tipo / Categoría</label>
                            <select name="id_tipo" id="id_tipo" class="form-select">
                                <option value="">-- Seleccionar Tipo --</option>
                                <?php foreach ($tipos as $idT => $tipoNombre): ?>
                                    <option value="<?= $idT ?>" <?= (old('id_tipo', $equipo['id_tipo']) == $idT) ? 'selected' : '' ?>>
                                        <?= esc($tipoNombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="id_marca" class="form-label fw-semibold">Marca</label>
                            <select name="id_marca" id="id_marca" class="form-select">
                                <option value="">-- Seleccionar Marca --</option>
                                <?php foreach ($marcas as $idM => $marcaNombre): ?>
                                    <option value="<?= $idM ?>" <?= (old('id_marca', $equipo['id_marca']) == $idM) ? 'selected' : '' ?>>
                                        <?= esc($marcaNombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="modelo" class="form-label fw-semibold">Modelo</label>
                            <input type="text" name="modelo" id="modelo" class="form-control" value="<?= old('modelo', $equipo['modelo']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="numero_serie" class="form-label fw-semibold">Número de Serie</label>
                            <input type="text" name="numero_serie" id="numero_serie" class="form-control font-monospace" value="<?= old('numero_serie', $equipo['numero_serie']) ?>">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="id_ubicacion" class="form-label fw-semibold">Ubicación en Gimnasio</label>
                            <select name="id_ubicacion" id="id_ubicacion" class="form-select">
                                <option value="">-- Seleccionar Ubicación --</option>
                                <?php foreach ($ubicaciones as $idU => $ubiNombre): ?>
                                    <option value="<?= $idU ?>" <?= (old('id_ubicacion', $equipo['id_ubicacion']) == $idU) ? 'selected' : '' ?>>
                                        <?= esc($ubiNombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="id_estado" class="form-label fw-semibold">Estado del Equipo</label>
                            <select name="id_estado" id="id_estado" class="form-select">
                                <?php foreach ($estados as $idE => $estNombre): ?>
                                    <option value="<?= $idE ?>" <?= (old('id_estado', $equipo['id_estado']) == $idE) ? 'selected' : '' ?>>
                                        <?= esc($estNombre) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="fecha_adquisicion" class="form-label fw-semibold">Fecha de Adquisición</label>
                            <input type="date" name="fecha_adquisicion" id="fecha_adquisicion" class="form-control" value="<?= old('fecha_adquisicion', $equipo['fecha_adquisicion']) ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="valor_adquisicion" class="form-label fw-semibold">Valor de Adquisición ($)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" name="valor_adquisicion" id="valor_adquisicion" class="form-control" value="<?= old('valor_adquisicion', $equipo['valor_adquisicion']) ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="activo" class="form-label fw-semibold">Disponibilidad</label>
                            <select name="activo" id="activo" class="form-select">
                                <option value="1" <?= (old('activo', $equipo['activo']) == 1) ? 'selected' : '' ?>>Activo / En Servicio</option>
                                <option value="0" <?= (old('activo', $equipo['activo']) == 0) ? 'selected' : '' ?>>Inactivo / Retirado</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label fw-semibold">Descripción Técnica</label>
                        <textarea name="descripcion" id="descripcion" rows="2" class="form-control"><?= old('descripcion', $equipo['descripcion']) ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="observaciones" class="form-label fw-semibold">Observaciones / Mantenimiento</label>
                        <textarea name="observaciones" id="observaciones" rows="2" class="form-control"><?= old('observaciones', $equipo['observaciones']) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="<?= base_url('equipos/actual/' . $equipo['id_equipo']) ?>" class="btn btn-light border px-4">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Equipo
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
    const fallbackUrl = '<?= base_url('equipos/imagen') ?>/';

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
