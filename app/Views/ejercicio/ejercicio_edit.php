<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-custom bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-pencil-square text-danger me-2"></i>Editar Ejercicio: <?= esc($ejercicio['nombre']) ?>
                    </h5>
                    <a href="<?= base_url('ejercicio/actual/' . $ejercicio['idejercicio']) ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>
            <div class="card-body p-4">

                <form method="post" action="<?= base_url('ejercicio/update/' . $ejercicio['idejercicio']) ?>">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">Nombre del Ejercicio <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?= old('nombre', $ejercicio['nombre']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="urlvideo" class="form-label fw-semibold">URL de Video Tutorial / Demostración</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-youtube text-danger"></i></span>
                            <input type="url" name="urlvideo" id="urlvideo" class="form-control" value="<?= old('urlvideo', $ejercicio['urlvideo']) ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="imagen" class="form-label fw-semibold">Nombre de Archivo de Imagen</label>
                        <?php if (!empty($ejercicio['imagen'])): ?>
                            <div class="d-flex align-items-center gap-3 mb-2 p-2 bg-light rounded border">
                                <img src="<?= base_url('ejercicio/imagen/' . esc($ejercicio['imagen'])) ?>" 
                                     alt="Preview" 
                                     class="rounded border bg-white" 
                                     style="width: 70px; height: 70px; object-fit: contain;">
                                <div>
                                    <div class="fw-semibold text-dark small"><?= esc($ejercicio['imagen']) ?></div>
                                    <small class="text-muted">Vista previa de la ilustración actual</small>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-file-earmark-image text-danger"></i></span>
                            <input type="text" name="imagen" id="imagen" class="form-control" value="<?= old('imagen', $ejercicio['imagen']) ?>" placeholder="Ej: squat-start.webp">
                        </div>
                        <small class="text-muted">Archivo .webp en el repositorio del gimnasio.</small>
                    </div>

                    <div class="mb-4">
                        <label for="descripcion" class="form-label fw-semibold">Descripción y Ejecución Técnica</label>
                        <textarea name="descripcion" id="descripcion" rows="4" class="form-control"><?= old('descripcion', $ejercicio['descripcion']) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="<?= base_url('ejercicio/actual/' . $ejercicio['idejercicio']) ?>" class="btn btn-light border px-4">Cancelar</a>
                        <button type="submit" class="btn btn-danger text-white px-4 fw-bold">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Ejercicio
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
