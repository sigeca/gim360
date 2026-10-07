<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php $mod = $module ?? 'rutinaejecicio'; ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-calendar2-week-fill text-info me-2"></i>Nueva Rutina de Ejercicio</h2>
                <p class="text-muted mb-0">Formulario para ingresar un registro en la tabla <code>rutinaejecicio</code>.</p>
            </div>
            <a href="<?= base_url($mod . '/elprimero') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver a Registro
            </a>
        </div>

        <div class="card card-custom bg-white border-top border-4 border-info">
            <div class="card-body p-4">
                <form action="<?= base_url($mod . '/save') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">Nombre de la Rutina <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" id="nombre" value="<?= old('nombre') ?>" class="form-control" placeholder="Ej. Full Body, Torso / Pierna, Push-Pull-Legs..." maxlength="50" required autofocus>
                        <div class="form-text">Máximo 50 caracteres. Debe ser único y conciso.</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url($mod . '/elprimero') ?>" class="btn btn-outline-secondary">Cancelar</a>
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
