<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-person-plus-fill text-primary me-2"></i>Registrar Persona</h2>
                <p class="text-muted mb-0">Ingrese los datos para registrar una nueva persona en el sistema.</p>
            </div>
            <a href="<?= base_url('persona') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver al listado
            </a>
        </div>

        <form action="<?= base_url('persona/create') ?>" method="post">
            <?= csrf_field() ?>

            <!-- Card Datos Personales -->
            <div class="card card-custom bg-white mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-person-vcard me-2"></i>1. Datos Principales (Tabla <code>persona</code>)</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="cedula" class="form-label fw-semibold">Cédula / Documento <span class="text-danger">*</span></label>
                            <input type="text" class="form-control font-monospace" id="cedula" name="cedula" value="<?= old('cedula') ?>" placeholder="Ej. 0801234567" required>
                        </div>
                        <div class="col-md-4">
                            <label for="apellidos" class="form-label fw-semibold">Apellidos <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?= old('apellidos') ?>" placeholder="Ej. Mendoza Reyes" required>
                        </div>
                        <div class="col-md-4">
                            <label for="nombres" class="form-label fw-semibold">Nombres <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombres" name="nombres" value="<?= old('nombres') ?>" placeholder="Ej. Carlos Alberto" required>
                        </div>
                        <div class="col-md-4">
                            <label for="fechanacimiento" class="form-label fw-semibold">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fechanacimiento" name="fechanacimiento" value="<?= old('fechanacimiento') ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="idsexo" class="form-label fw-semibold">Sexo (Tabla <code>sexo</code>)</label>
                            <select class="form-select" id="idsexo" name="idsexo">
                                <option value="">-- Seleccionar Sexo --</option>
                                <?php foreach ($sexos as $s): ?>
                                    <option value="<?= $s['idsexo'] ?>" <?= old('idsexo') == $s['idsexo'] ? 'selected' : '' ?>>
                                        <?= esc($s['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-center">
                            <div class="form-check form-switch mt-3">
                                <input class="form-check-input" type="checkbox" id="es_cliente" name="es_cliente" value="1" <?= old('es_cliente') ? 'checked' : '' ?>>
                                <label class="form-check-label fw-bold text-success" for="es_cliente">
                                    <i class="bi bi-person-badge me-1"></i> Registrar como Cliente Gym (Tabla <code>cliente</code>)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Datos Opcionales de Contacto y Catálogos -->
            <div class="card card-custom bg-white mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-secondary"><i class="bi bi-link-45deg me-2"></i>2. Información Inicial Opcional (Tablas Relacionadas)</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="correo" class="form-label fw-semibold">Correo Electrónico Inicial (Tabla <code>correo</code>)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="correo" name="correo" value="<?= old('correo') ?>" placeholder="ejemplo@correo.com">
                            </div>
                            <small class="text-muted">Podrá agregar múltiples correos en la ficha de la persona.</small>
                        </div>

                        <div class="col-md-6">
                            <label for="direccion" class="form-label fw-semibold">Dirección Inicial (Tabla <code>direccion</code>)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" class="form-control" id="direccion" name="direccion" value="<?= old('direccion') ?>" placeholder="Calle, número, barrio...">
                            </div>
                            <small class="text-muted">Podrá agregar múltiples direcciones en la ficha de la persona.</small>
                        </div>

                        <div class="col-md-6">
                            <label for="idestadocivil" class="form-label fw-semibold">Estado Civil (Tabla <code>estadocivilpersona</code>)</label>
                            <select class="form-select" id="idestadocivil" name="idestadocivil">
                                <option value="">-- Sin asignar por ahora --</option>
                                <?php foreach ($estadosCiviles as $ec): ?>
                                    <option value="<?= $ec['idestadocivil'] ?>" <?= old('idestadocivil') == $ec['idestadocivil'] ? 'selected' : '' ?>>
                                        <?= esc($ec['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="idgenero" class="form-label fw-semibold">Identidad de Género (Tabla <code>generopersona</code>)</label>
                            <select class="form-select" id="idgenero" name="idgenero">
                                <option value="">-- Sin asignar por ahora --</option>
                                <?php foreach ($generos as $g): ?>
                                    <option value="<?= $g['idgenero'] ?>" <?= old('idgenero') == $g['idgenero'] ? 'selected' : '' ?>>
                                        <?= esc($g['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="d-flex justify-content-end gap-2 mb-5">
                <a href="<?= base_url('persona') ?>" class="btn btn-outline-secondary px-4">Cancelar</a>
                <button type="submit" class="btn btn-primary px-4 fw-bold">
                    <i class="bi bi-save me-1"></i> Guardar Persona
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
