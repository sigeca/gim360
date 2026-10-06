<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-heart text-danger me-2"></i>Asignar Estado Civil a Persona</h2>
                <p class="text-muted mb-0">Agregar un nuevo registro a la tabla <code>estadocivilpersona</code>.</p>
            </div>
            <a href="<?= base_url('estadocivilpersona') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>

        <div class="card card-custom bg-white">
            <div class="card-body p-4">
                <form action="<?= base_url('estadocivilpersona/create') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="idpersona" class="form-label fw-semibold">Persona <span class="text-danger">*</span></label>
                        <select name="idpersona" id="idpersona" class="form-select" required>
                            <option value="">-- Seleccionar Persona --</option>
                            <?php foreach ($personas as $p): ?>
                                <option value="<?= $p['idpersona'] ?>" <?= (old('idpersona') == $p['idpersona'] || $idpersonaPreselected == $p['idpersona']) ? 'selected' : '' ?>>
                                    <?= esc($p['cedula']) ?> — <?= esc($p['nombres']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="idestadocivil" class="form-label fw-semibold">Estado Civil <span class="text-danger">*</span></label>
                        <select name="idestadocivil" id="idestadocivil" class="form-select" required>
                            <option value="">-- Seleccionar Estado Civil --</option>
                            <?php foreach ($estadosCiviles as $ec): ?>
                                <option value="<?= $ec['idestadocivil'] ?>" <?= old('idestadocivil') == $ec['idestadocivil'] ? 'selected' : '' ?>>
                                    <?= esc($ec['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('estadocivilpersona') ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-dark fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Guardar Asignación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
