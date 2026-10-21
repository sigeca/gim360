<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-custom bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-pencil-square text-warning me-2"></i>Editar Estado de Disponibilidad #<?= $disponibilidad['iddisponibilidadequipo'] ?>
                    </h5>
                    <a href="<?= base_url('disponibilidadequipo/actual/' . $disponibilidad['iddisponibilidadequipo']) ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>
            <div class="card-body p-4">

                <form method="post" action="<?= base_url('disponibilidadequipo/update/' . $disponibilidad['iddisponibilidadequipo']) ?>">
                    <?= csrf_field() ?>

                    <div class="mb-4">
                        <label for="nombre" class="form-label fw-semibold">Nombre del Estado de Disponibilidad <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?= old('nombre', $disponibilidad['nombre']) ?>" required autofocus>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="<?= base_url('disponibilidadequipo/actual/' . $disponibilidad['iddisponibilidadequipo']) ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Estado
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
