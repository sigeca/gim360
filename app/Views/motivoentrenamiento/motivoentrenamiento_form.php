<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-bullseye text-warning me-2"></i>Nuevo Motivo de Entrenamiento</h2>
                <p class="text-muted mb-0">Formulario para ingresar un registro en la tabla <code>motivoentrenamiento</code>.</p>
            </div>
            <a href="<?= base_url('motivoentrenamiento/elprimero') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver a Registro
            </a>
        </div>

        <div class="card card-custom bg-white border-top border-4 border-warning">
            <div class="card-body p-4">
                <form action="<?= base_url('motivoentrenamiento/save') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">Nombre del Motivo <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" id="nombre" value="<?= old('nombre') ?>" class="form-control" placeholder="Ej. Hipertrofia, Pérdida de Grasa, Salud general..." maxlength="100" required autofocus>
                        <div class="form-text">Máximo 100 caracteres. Debe ser descriptivo y único.</div>
                    </div>

                    <div class="mb-3">
                        <label for="objetivo" class="form-label fw-semibold">Objetivo del Entrenamiento</label>
                        <textarea name="objetivo" id="objetivo" class="form-control" rows="4" placeholder="Describe brevemente la meta o propósito de este motivo de entrenamiento..."><?= old('objetivo') ?></textarea>
                        <div class="form-text">Detalles y metas a lograr con este enfoque.</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('motivoentrenamiento/elprimero') ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Guardar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
