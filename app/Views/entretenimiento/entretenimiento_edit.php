<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-custom bg-white border-top border-4 border-warning shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <i class="bi bi-pencil-square text-warning me-2 fs-4"></i>Editar Entretenimiento #<?= $entretenimiento['identretenimiento'] ?>
                </h5>
                <a href="<?= base_url('entretenimiento/actual/' . $entretenimiento['identretenimiento']) ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Regresar
                </a>
            </div>
            <div class="card-body p-4">
                <?php if (session('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session('errors') as $err): ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('entretenimiento/update/' . $entretenimiento['identretenimiento']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">Nombre del Entretenimiento <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?= old('nombre', $entretenimiento['nombre']) ?>" required maxlength="150">
                    </div>
                    <div class="mb-4">
                        <label for="descripcion" class="form-label fw-bold">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="3" class="form-control"><?= old('descripcion', $entretenimiento['descripcion'] ?? '') ?></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('entretenimiento/actual/' . $entretenimiento['identretenimiento']) ?>" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold"><i class="bi bi-check-circle me-1"></i>Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
