<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-pencil-square text-warning me-2"></i>Editar Estado Civil</h2>
                <p class="text-muted mb-0">Modificar información del registro en la tabla <code>estadocivil</code>.</p>
            </div>
            <a href="<?= base_url('estadocivil/actual/' . $estadoCivil['idestadocivil']) ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver a Registro
            </a>
        </div>

        <div class="card card-custom bg-white border-top border-4 border-warning">
            <div class="card-body p-4">
                <form action="<?= base_url('estadocivil/update/' . $estadoCivil['idestadocivil']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">ID Estado Civil</label>
                        <input type="text" class="form-control bg-light" value="<?= $estadoCivil['idestadocivil'] ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">Nombre del Estado Civil <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" id="nombre" value="<?= old('nombre', $estadoCivil['nombre']) ?>" class="form-control" required autofocus>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('estadocivil/actual/' . $estadoCivil['idestadocivil']) ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
