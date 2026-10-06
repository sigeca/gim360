<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-pencil-square text-warning me-2"></i>Editar Persona</h2>
                <p class="text-muted mb-0">Actualización de datos generales en la tabla <code>persona</code>.</p>
            </div>
            <a href="<?= base_url('persona/show/' . $persona['idpersona']) ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Ver Perfil
            </a>
        </div>

        <div class="card card-custom bg-white">
            <div class="card-body p-4">
                <form action="<?= base_url('persona/update/' . $persona['idpersona']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="cedula" class="form-label fw-semibold">Cédula / Documento <span class="text-danger">*</span></label>
                            <input type="text" class="form-control font-monospace" id="cedula" name="cedula" value="<?= old('cedula', $persona['cedula']) ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="apellidos" class="form-label fw-semibold">Apellidos <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?= old('apellidos', $persona['apellidos']) ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="nombres" class="form-label fw-semibold">Nombres <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombres" name="nombres" value="<?= old('nombres', $persona['nombres']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fechanacimiento" class="form-label fw-semibold">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fechanacimiento" name="fechanacimiento" value="<?= old('fechanacimiento', $persona['fechanacimiento']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="idsexo" class="form-label fw-semibold">Sexo (Tabla <code>sexo</code>)</label>
                            <select class="form-select" id="idsexo" name="idsexo">
                                <option value="">-- Seleccionar Sexo --</option>
                                <?php foreach ($sexos as $s): ?>
                                    <option value="<?= $s['idsexo'] ?>" <?= old('idsexo', $persona['idsexo']) == $s['idsexo'] ? 'selected' : '' ?>>
                                        <?= esc($s['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('persona/show/' . $persona['idpersona']) ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning fw-bold px-4">
                            <i class="bi bi-check2-circle me-1"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
