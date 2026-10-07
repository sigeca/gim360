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

        <div class="card card-custom bg-white border-top border-4 border-warning">
            <div class="card-body p-4">
                <form action="<?= base_url('motivoentrenamiento/update/' . $motivo['idmotivoentrenamiento']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">ID Motivo de Entrenamiento</label>
                        <input type="text" class="form-control bg-light" value="<?= $motivo['idmotivoentrenamiento'] ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">Nombre del Motivo <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" id="nombre" value="<?= old('nombre', $motivo['nombre']) ?>" class="form-control" maxlength="100" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="objetivo" class="form-label fw-semibold">Objetivo del Entrenamiento</label>
                        <textarea name="objetivo" id="objetivo" class="form-control" rows="4"><?= old('objetivo', $motivo['objetivo']) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('motivoentrenamiento/actual/' . $motivo['idmotivoentrenamiento']) ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
