<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom bg-white border-top border-4 border-info shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square text-info me-2"></i>Editar Mi Medicación #<?= $mimedicacion['idmimedicacion'] ?></h5>
                <a href="<?= base_url('mimedicacion/actual/' . $mimedicacion['idmimedicacion']) ?>" class="btn btn-sm btn-outline-secondary">Volver</a>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('mimedicacion/update/' . $mimedicacion['idmimedicacion']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Persona Propietaria <span class="text-danger">*</span></label>
                        <select name="idpersona" class="form-select" required>
                            <?php foreach ($personas as $p): ?>
                                <option value="<?= $p['idpersona'] ?>" <?= ($mimedicacion['idpersona'] == $p['idpersona']) ? 'selected' : '' ?>>
                                    <?= esc($p['apellidos'] . ' ' . $p['nombres']) ?> (C.I. <?= esc($p['cedula']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Afección Médica</label>
                        <select name="idafeccion" class="form-select">
                            <option value="">-- Sin afección específica --</option>
                            <?php foreach ($afecciones as $a): ?>
                                <option value="<?= $a['idafeccion'] ?>" <?= ($mimedicacion['idafeccion'] == $a['idafeccion']) ? 'selected' : '' ?>>
                                    <?= esc($a['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Medicación Base</label>
                        <select name="idmedicacion" class="form-select">
                            <option value="">-- Sin medicación base --</option>
                            <?php foreach ($medicaciones as $m): ?>
                                <option value="<?= $m['idmedicacion'] ?>" <?= ($mimedicacion['idmedicacion'] == $m['idmedicacion']) ? 'selected' : '' ?>>
                                    <?= esc($m['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre del Tratamiento <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control" value="<?= esc($mimedicacion['nombre']) ?>" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Fecha de Inicio</label>
                            <input type="date" name="fechainicio" class="form-control" value="<?= esc($mimedicacion['fechainicio']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Fecha de Fin</label>
                            <input type="date" name="fechafin" class="form-control" value="<?= esc($mimedicacion['fechafin']) ?>">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Médico Tratante</label>
                            <input type="text" name="medicotratante" class="form-control" value="<?= esc($mimedicacion['medicotratante']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Estado</label>
                            <select name="estado" class="form-select">
                                <option value="Activa" <?= ($mimedicacion['estado'] === 'Activa') ? 'selected' : '' ?>>Activa</option>
                                <option value="Completada" <?= ($mimedicacion['estado'] === 'Completada') ? 'selected' : '' ?>>Completada</option>
                                <option value="Suspendida" <?= ($mimedicacion['estado'] === 'Suspendida') ? 'selected' : '' ?>>Suspendida</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Descripción / Notas</label>
                        <textarea name="descripcion" class="form-control" rows="3"><?= esc($mimedicacion['descripcion']) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('mimedicacion/actual/' . $mimedicacion['idmimedicacion']) ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-info text-dark fw-bold px-4">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
