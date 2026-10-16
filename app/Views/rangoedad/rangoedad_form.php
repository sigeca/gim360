<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-person-bounding-box text-info me-2"></i>Nuevo Rango de Edad</h2>
                <p class="text-muted mb-0">Formulario para ingresar un registro en la tabla <code>rangoedad</code>.</p>
            </div>
            <a href="<?= base_url('rangoedad/elprimero') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver a Registro
            </a>
        </div>

        <div class="card card-custom bg-white border-top border-4 border-info shadow-sm">
            <div class="card-body p-4">
                <form action="<?= base_url('rangoedad/save') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">Nombre del Rango <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" id="nombre" value="<?= old('nombre') ?>" class="form-control" placeholder="Ej. Juvenil, Adulto Joven, Adulto Mayor..." maxlength="100" required autofocus>
                        <div class="form-text">Máximo 100 caracteres. Debe ser descriptivo y único.</div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="edadminima" class="form-label fw-semibold">Edad Mínima (Años) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-arrow-down-circle text-primary"></i></span>
                                <input type="number" name="edadminima" id="edadminima" value="<?= old('edadminima', 14) ?>" class="form-control" min="0" max="120" required>
                            </div>
                            <div class="form-text">Límite inferior inclusivo en años.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="edadmaxima" class="form-label fw-semibold">Edad Máxima (Años) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-arrow-up-circle text-danger"></i></span>
                                <input type="number" name="edadmaxima" id="edadmaxima" value="<?= old('edadmaxima', 25) ?>" class="form-control" min="0" max="120" required>
                            </div>
                            <div class="form-text">Límite superior inclusivo en años.</div>
                        </div>
                    </div>

                    <div class="alert alert-light border small text-muted d-flex align-items-center gap-2 mb-4">
                        <i class="bi bi-info-circle-fill text-info fs-5"></i>
                        <div>
                            Este rango de edad se vinculará como clave foránea en la tabla <code>programaentrenamiento</code> para orientar la prescripción deportiva de los usuarios.
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('rangoedad/elprimero') ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-info text-white fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Guardar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
