<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-diagram-3 text-warning me-2"></i>Asignar Plan a Rutina</h2>
                <p class="text-muted mb-0">Formulario para asociar una rutina con un plan de ejercicio en <code>rutinaplan</code>.</p>
            </div>
            <a href="<?= base_url('rutinaplan/elprimero') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver a Registro
            </a>
        </div>

        <div class="card card-custom bg-white border-top border-4 border-warning">
            <div class="card-body p-4">
                <form action="<?= base_url('rutinaplan/save') ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- 1. Rutina de Ejercicio -->
                    <div class="mb-3">
                        <label for="idrutinaejercicio" class="form-label fw-semibold">
                            <i class="bi bi-calendar2-week text-info me-1"></i>Rutina de Ejercicio <span class="text-danger">*</span>
                        </label>
                        <select name="idrutinaejercicio" id="idrutinaejercicio" class="form-select" required autofocus>
                            <option value="">-- Seleccione una Rutina --</option>
                            <?php foreach ($rutinas as $r): ?>
                                <option value="<?= $r['idrutinaejercicio'] ?>" <?= old('idrutinaejercicio', $idrutinaPreselected ?? '') == $r['idrutinaejercicio'] ? 'selected' : '' ?>>
                                    <?= esc($r['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Estructura o split de entrenamiento al que pertenecerá el plan.</div>
                    </div>

                    <!-- 2. Plan de Ejercicio -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="idplanejercicio" class="form-label fw-semibold mb-0">
                                <i class="bi bi-card-checklist text-primary me-1"></i>Plan de Ejercicio <span class="text-danger">*</span>
                            </label>
                            <a href="<?= base_url('planejercicio/add') ?>" target="_blank" class="small text-decoration-none text-primary">
                                <i class="bi bi-plus-circle me-1"></i>Crear nuevo plan
                            </a>
                        </div>
                        <select name="idplanejercicio" id="idplanejercicio" class="form-select" required>
                            <option value="">-- Seleccione un Plan de Ejercicio --</option>
                            <?php foreach ($planes as $p): ?>
                                <option value="<?= $p['idplanejercicio'] ?>" <?= old('idplanejercicio', $idplanPreselected ?? '') == $p['idplanejercicio'] ? 'selected' : '' ?>>
                                    #<?= $p['idplanejercicio'] ?> - <?= esc($p['ejercicio_nombre']) ?> 
                                    (<?= $p['series'] ?? 0 ?>s × <?= $p['repeticiones'] ?? 0 ?>r, <?= $p['diassemanas'] ?? $p['dias'] ?? 0 ?>d, <?= number_format((float)($p['peso'] ?? 0), 2) ?> kg)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Contiene el ejercicio con sus series, repeticiones, descanso y peso.</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('rutinaplan/elprimero') ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Guardar Rutina-Plan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
