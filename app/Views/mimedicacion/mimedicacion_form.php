<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom bg-white border-top border-4 border-info shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-person-plus-fill text-info me-2"></i>Personalizar / Crear Mi Medicación</h5>
                <a href="<?= base_url('mimedicacion') ?>" class="btn btn-sm btn-outline-secondary">Volver</a>
            </div>
            <div class="card-body p-4">

                <?php if (!empty($baseMedicacion)): ?>
                    <div class="alert alert-info border-info-subtle d-flex align-items-center mb-4">
                        <i class="bi bi-prescription2 fs-2 me-3 text-primary"></i>
                        <div>
                            <strong>Medicación base seleccionada:</strong> <?= esc($baseMedicacion['nombre']) ?>
                            <div class="small text-muted">Afección: <?= esc($baseMedicacion['afeccion_nombre']) ?> | Se copiarán automáticamente sus medicamentos prescritos.</div>
                        </div>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('mimedicacion/save') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Persona Propietaria <span class="text-danger">*</span></label>
                        <select name="idpersona" class="form-select" required>
                            <option value="">-- Seleccionar Persona --</option>
                            <?php foreach ($personas as $p): ?>
                                <option value="<?= $p['idpersona'] ?>" <?= (old('idpersona', $selectedIdPersona) == $p['idpersona']) ? 'selected' : '' ?>>
                                    <?= esc($p['apellidos'] . ' ' . $p['nombres']) ?> (C.I. <?= esc($p['cedula']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Afección Médica a Tratar</label>
                        <select name="idafeccion" class="form-select">
                            <option value="">-- Seleccionar Afección --</option>
                            <?php foreach ($afecciones as $a): ?>
                                <option value="<?= $a['idafeccion'] ?>" <?= (old('idafeccion', $selectedIdAfeccion) == $a['idafeccion']) ? 'selected' : '' ?>>
                                    <?= esc($a['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Medicación Base / Plantilla Protocolar <span class="badge bg-light text-muted border">Opcional</span></label>
                        <select name="idmedicacion" class="form-select">
                            <option value="">-- Sin medicación base (Desde cero) --</option>
                            <?php foreach ($medicaciones as $m): ?>
                                <option value="<?= $m['idmedicacion'] ?>" <?= (old('idmedicacion', $selectedIdMedicacion) == $m['idmedicacion']) ? 'selected' : '' ?>>
                                    <?= esc($m['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="clonar_medicamentos" name="clonar_medicamentos" value="1" checked>
                        <label class="form-check-label fw-bold text-primary" for="clonar_medicamentos">
                            <i class="bi bi-copy me-1"></i>Clonar automáticamente todos los medicamentos y dosis de la medicación base
                        </label>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre del Tratamiento Personal <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control" value="<?= old('nombre', !empty($baseMedicacion) ? ('Mi ' . $baseMedicacion['nombre'] . ' Personalizada') : '') ?>" placeholder="Ej: Mi Tratamiento para Desinflamación Muscular..." required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Fecha de Inicio</label>
                            <input type="date" name="fechainicio" class="form-control" value="<?= old('fechainicio', date('Y-m-d')) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Fecha de Fin (Opcional)</label>
                            <input type="date" name="fechafin" class="form-control" value="<?= old('fechafin') ?>">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Médico / Especialista Tratante</label>
                            <input type="text" name="medicotratante" class="form-control" value="<?= old('medicotratante', 'Dr. Médico GIM360') ?>" placeholder="Nombre del médico...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Estado del Tratamiento</label>
                            <select name="estado" class="form-select">
                                <option value="Activa" selected>Activa</option>
                                <option value="Completada">Completada</option>
                                <option value="Suspendida">Suspendida</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Descripción / Notas Personales</label>
                        <textarea name="descripcion" class="form-control" rows="3" placeholder="Observaciones particulares..."><?= old('descripcion', !empty($baseMedicacion) ? $baseMedicacion['descripcion'] : '') ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('mimedicacion') ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-info text-dark fw-bold px-4"><i class="bi bi-save me-1"></i>Guardar y Personalizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
