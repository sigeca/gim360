<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-pencil-square text-warning me-2"></i>Editar Correo Electrónico</h2>
                <p class="text-muted mb-0">Modificar registro en la tabla <code>correo</code>.</p>
            </div>
            <a href="<?= base_url('correo') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>

        <div class="card card-custom bg-white">
            <div class="card-body p-4">
                <form action="<?= base_url('correo/update/' . $correo['idcorreo']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="idpersona" class="form-label fw-semibold">Persona <span class="text-danger">*</span></label>
                        <select name="idpersona" id="idpersona" class="form-select" required>
                            <option value="">-- Seleccionar Persona --</option>
                            <?php foreach ($personas as $p): ?>
                                <option value="<?= $p['idpersona'] ?>" <?= old('idpersona', $correo['idpersona']) == $p['idpersona'] ? 'selected' : '' ?>>
                                    <?= esc($p['cedula']) ?> — <?= esc($p['nombres']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="correo" class="form-label fw-semibold">Correo Electrónico <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="correo" id="correo" value="<?= old('correo', $correo['correo']) ?>" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="fechaoptencion" class="form-label fw-semibold">Fecha de Obtención (<code>fechaoptencion</code>)</label>
                        <input type="date" name="fechaoptencion" id="fechaoptencion" value="<?= old('fechaoptencion', $correo['fechaoptencion']) ?>" class="form-control">
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('correo') ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Correo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
