<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-custom bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-pencil-square text-dark me-2"></i>Editar Asignación #<?= $asignacion['idgeneropersona'] ?>
                    </h5>
                    <a href="<?= base_url('generopersona/actual/' . $asignacion['idgeneropersona']) ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>
            <div class="card-body p-4">

                <form method="post" action="<?= base_url('generopersona/update/' . $asignacion['idgeneropersona']) ?>">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="idpersona" class="form-label fw-semibold">Persona <span class="text-danger">*</span></label>
                        <select name="idpersona" id="idpersona" class="form-select" required>
                            <option value="">-- Seleccionar Persona --</option>
                            <?php foreach ($personas as $p): ?>
                                <option value="<?= $p['idpersona'] ?>" <?= (old('idpersona', $asignacion['idpersona']) == $p['idpersona']) ? 'selected' : '' ?>>
                                    <?= esc($p['cedula']) ?> - <?= esc($p['nombres']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="idgenero" class="form-label fw-semibold">Género <span class="text-danger">*</span></label>
                        <select name="idgenero" id="idgenero" class="form-select" required>
                            <option value="">-- Seleccionar Género --</option>
                            <?php foreach ($generos as $g): ?>
                                <option value="<?= $g['idgenero'] ?>" <?= (old('idgenero', $asignacion['idgenero']) == $g['idgenero']) ? 'selected' : '' ?>>
                                    <?= esc($g['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="<?= base_url('generopersona/actual/' . $asignacion['idgeneropersona']) ?>" class="btn btn-light border px-4">Cancelar</a>
                        <button type="submit" class="btn btn-dark px-4 fw-bold">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Asignación
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
