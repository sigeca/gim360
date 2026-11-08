<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="card card-custom bg-white border-top border-4 border-info shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <i class="bi bi-pencil-square text-info me-2 fs-4"></i>Editar Mi Entretenimiento #<?= $mientretenimiento['idmientretenimiento'] ?>
                </h5>
                <a href="<?= base_url('mientretenimiento/actual/' . $mientretenimiento['idmientretenimiento']) ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Volver
                </a>
            </div>

            <div class="card-body p-4">

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Por favor corrija los siguientes errores:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('mientretenimiento/update/' . $mientretenimiento['idmientretenimiento']) ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- 1. Persona Propietaria -->
                    <div class="mb-3">
                        <label for="idpersona" class="form-label fw-bold text-dark">
                            Persona Propietaria <span class="text-danger">*</span>
                        </label>
                        <select name="idpersona" id="idpersona" class="form-select <?= session('errors.idpersona') ? 'is-invalid' : '' ?>" required>
                            <option value="">-- Seleccionar Persona --</option>
                            <?php foreach ($personas as $p): ?>
                                <option value="<?= $p['idpersona'] ?>" <?= (old('idpersona', $mientretenimiento['idpersona']) == $p['idpersona']) ? 'selected' : '' ?>>
                                    <?= esc($p['apellidos'] . ' ' . $p['nombres']) ?> (C.I. <?= esc($p['cedula']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- 2. Plantilla Base -->
                    <div class="mb-3">
                        <label for="identretenimiento" class="form-label fw-bold text-dark">
                            Plantilla Base de Entretenimiento <span class="badge bg-light text-muted border">Opcional</span>
                        </label>
                        <select name="identretenimiento" id="identretenimiento" class="form-select">
                            <option value="">-- Sin plantilla base --</option>
                            <?php foreach ($entretenimientos as $e): ?>
                                <option value="<?= $e['identretenimiento'] ?>" <?= (old('identretenimiento', $mientretenimiento['identretenimiento']) == $e['identretenimiento']) ? 'selected' : '' ?>>
                                    <?= esc($e['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- 3. Nombre Personalizado -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold text-dark">
                            Nombre de Mi Entretenimiento <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control <?= session('errors.nombre') ? 'is-invalid' : '' ?>"
                               id="nombre"
                               name="nombre"
                               value="<?= old('nombre', $mientretenimiento['nombre']) ?>"
                               maxlength="150"
                               required>
                    </div>

                    <!-- 4. Descripción Personalizada -->
                    <div class="mb-4">
                        <label for="descripcion" class="form-label fw-bold text-dark">Descripción Personal</label>
                        <textarea class="form-control"
                                  id="descripcion"
                                  name="descripcion"
                                  rows="3"><?= old('descripcion', $mientretenimiento['descripcion']) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('mientretenimiento/actual/' . $mientretenimiento['idmientretenimiento']) ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-info text-dark fw-bold px-4">
                            <i class="bi bi-save me-1"></i>Actualizar Cambios
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
