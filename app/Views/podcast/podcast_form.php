<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-custom bg-white border-top border-4 border-warning shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-mic-fill text-warning me-2"></i>Registrar Podcast</h5>
                <a href="<?= base_url('podcast') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Regresar</a>
            </div>
            <div class="card-body p-4">
                <?php if (session('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session('errors') as $err): ?><li><?= esc($err) ?></li><?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('podcast/save') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">Título del Podcast <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?= old('nombre') ?>" placeholder="Ej: Nutrición Deportiva y Ganancia Muscular" required maxlength="150">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="presentador" class="form-label fw-bold">Presentador / Anfitrión</label>
                            <input type="text" name="presentador" id="presentador" class="form-control" value="<?= old('presentador') ?>" placeholder="Ej: Fitness Revolucionario" maxlength="150">
                        </div>
                        <div class="col-md-6">
                            <label for="tema" class="form-label fw-bold">Tema / Categoría</label>
                            <input type="text" name="tema" id="tema" class="form-control" value="<?= old('tema') ?>" placeholder="Ej: Nutrición y Salud" maxlength="100">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="enlace" class="form-label fw-bold">Enlace (URL del Podcast) <span class="text-danger">*</span></label>
                        <input type="url" name="enlace" id="enlace" class="form-control" value="<?= old('enlace') ?>" placeholder="https://open.spotify.com/show/... o enlace a episodio" required maxlength="500">
                    </div>
                    <div class="mb-4">
                        <label for="descripcion" class="form-label fw-bold">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="2" class="form-control"><?= old('descripcion') ?></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('podcast') ?>" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold"><i class="bi bi-save me-1"></i>Guardar Podcast</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
