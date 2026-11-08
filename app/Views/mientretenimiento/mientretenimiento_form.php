<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="card card-custom bg-white border-top border-4 border-info shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <i class="bi bi-person-plus-fill text-info me-2 fs-4"></i>Personalizar / Crear Mi Entretenimiento
                </h5>
                <a href="<?= base_url('mientretenimiento') ?>" class="btn btn-sm btn-outline-secondary">
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

                <?php if (!empty($baseEntretenimiento)): ?>
                    <div class="alert alert-info border-info-subtle d-flex align-items-center mb-4">
                        <i class="bi bi-controller fs-2 me-3 text-primary"></i>
                        <div>
                            <strong>Plantilla seleccionada:</strong> <?= esc($baseEntretenimiento['nombre']) ?>
                            <div class="small text-muted"><?= esc($baseEntretenimiento['descripcion'] ?: 'Se copiarán automáticamente sus músicas, videos, juegos y podcasts vinculados.') ?></div>
                        </div>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('mientretenimiento/save') ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- 1. Persona Propietaria -->
                    <div class="mb-3">
                        <label for="idpersona" class="form-label fw-bold text-dark">
                            Persona Propietaria <span class="text-danger">*</span>
                        </label>
                        <select name="idpersona" id="idpersona" class="form-select <?= session('errors.idpersona') ? 'is-invalid' : '' ?>" required>
                            <option value="">-- Seleccionar Persona --</option>
                            <?php foreach ($personas as $p): ?>
                                <option value="<?= $p['idpersona'] ?>" <?= (old('idpersona', $selectedIdPersona) == $p['idpersona']) ? 'selected' : '' ?>>
                                    <?= esc($p['apellidos'] . ' ' . $p['nombres']) ?> (C.I. <?= esc($p['cedula']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Persona o cliente que disfrutará y personalizará esta lista de entretenimiento.</div>
                    </div>

                    <!-- 2. Plantilla Base de Entretenimiento (Opcional) -->
                    <div class="mb-3">
                        <label for="identretenimiento" class="form-label fw-bold text-dark">
                            Plantilla Base de Entretenimiento <span class="badge bg-light text-muted border">Opcional</span>
                        </label>
                        <select name="identretenimiento" id="identretenimiento" class="form-select">
                            <option value="">-- Sin plantilla base (Crear desde cero) --</option>
                            <?php foreach ($entretenimientos as $e): ?>
                                <option value="<?= $e['identretenimiento'] ?>" <?= (old('identretenimiento', $selectedIdEntre) == $e['identretenimiento']) ? 'selected' : '' ?>>
                                    <?= esc($e['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Si seleccionas una plantilla base, puedes clonar todo su contenido multimedia inicial.</div>
                    </div>

                    <div class="form-check form-switch mb-3" id="switchClonar">
                        <input class="form-check-input" type="checkbox" role="switch" id="clonar_contenido" name="clonar_contenido" value="1" checked>
                        <label class="form-check-label fw-bold text-primary" for="clonar_contenido">
                            <i class="bi bi-copy me-1"></i>Clonar automáticamente todas las músicas, videos, juegos y podcasts de la plantilla base
                        </label>
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
                               value="<?= old('nombre', !empty($baseEntretenimiento) ? ('Mi ' . $baseEntretenimiento['nombre'] . ' Personalizado') : '') ?>"
                               placeholder="Ej: Mi Rutina de Gimnasio con Música y Juegos Favoritos"
                               maxlength="150"
                               required>
                    </div>

                    <!-- 4. Descripción Personalizada -->
                    <div class="mb-4">
                        <label for="descripcion" class="form-label fw-bold text-dark">Descripción Personal</label>
                        <textarea class="form-control"
                                  id="descripcion"
                                  name="descripcion"
                                  rows="3"
                                  placeholder="Notas personales, objetivos o preferencias de contenido..."><?= old('descripcion', !empty($baseEntretenimiento) ? $baseEntretenimiento['descripcion'] : '') ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('mientretenimiento') ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-info text-dark fw-bold px-4">
                            <i class="bi bi-save me-1"></i>Guardar y Comenzar a Personalizar
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
