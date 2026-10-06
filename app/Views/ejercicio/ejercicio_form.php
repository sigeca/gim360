<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-custom bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-fire text-danger me-2"></i>Registrar Nuevo Ejercicio
                    </h5>
                    <a href="<?= base_url('ejercicio/listar') ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>
            <div class="card-body p-4">

                <form method="post" action="<?= base_url('ejercicio/save') ?>">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">Nombre del Ejercicio <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Press Francés con Barra Z" value="<?= old('nombre') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="urlvideo" class="form-label fw-semibold">URL de Video Tutorial / Demostración</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-youtube text-danger"></i></span>
                            <input type="url" name="urlvideo" id="urlvideo" class="form-control" placeholder="https://www.youtube.com/watch?v=..." value="<?= old('urlvideo') ?>">
                        </div>
                        <small class="text-muted">Enlace a YouTube, Vimeo o video demostrativo.</small>
                    </div>

                    <div class="mb-3">
                        <label for="imagen" class="form-label fw-semibold">Nombre de Archivo de Imagen</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-file-earmark-image text-danger"></i></span>
                            <input type="text" name="imagen" id="imagen" class="form-control" placeholder="Ej: curl-biceps-start.webp" value="<?= old('imagen') ?>">
                        </div>
                        <small class="text-muted">Archivo .webp en el repositorio de imágenes del gimnasio.</small>
                    </div>

                    <div class="mb-4">
                        <label for="descripcion" class="form-label fw-semibold">Descripción y Ejecución Técnica</label>
                        <textarea name="descripcion" id="descripcion" rows="4" class="form-control" placeholder="Detalle la postura adecuada, músculos involucrados, rango de movimiento y precauciones..."><?= old('descripcion') ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="<?= base_url('ejercicio') ?>" class="btn btn-light border px-4">Cancelar</a>
                        <button type="submit" class="btn btn-danger text-white px-4 fw-bold">
                            <i class="bi bi-save me-1"></i> Guardar Ejercicio
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
