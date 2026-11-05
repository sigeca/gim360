<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-custom bg-white border-top border-4 border-warning">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-pencil-square text-warning me-2"></i>Editar Ejecución de Programa #<?= $ejecucion['idejecucionprograma'] ?>
                    </h5>
                    <a href="<?= base_url('ejecucionprograma/actual/' . $ejecucion['idejecucionprograma']) ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>
            <div class="card-body p-4">

                <form method="post" action="<?= base_url('ejecucionprograma/update/' . $ejecucion['idejecucionprograma']) ?>">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="idprogramacliente" class="form-label fw-semibold">Programa Cliente <span class="text-danger">*</span></label>
                        <select name="idprogramacliente" id="idprogramacliente" class="form-select" required autofocus>
                            <option value="">-- Seleccionar Programa Asignado al Cliente --</option>
                            <?php foreach ($programasClientes as $pc): ?>
                                <option value="<?= $pc['idprogramacliente'] ?>" <?= (old('idprogramacliente', $ejecucion['idprogramacliente']) == $pc['idprogramacliente']) ? 'selected' : '' ?>>
                                    #<?= $pc['idprogramacliente'] ?> — <?= esc($pc['cliente_nombres']) ?> (C.I: <?= esc($pc['cliente_cedula']) ?>) — <?= esc($pc['programa_nombre']) ?> [<?= esc($pc['estado_nombre']) ?>]
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="idejercicio" class="form-label fw-semibold">Ejercicio Ejecutado <span class="text-danger">*</span></label>
                        <select name="idejercicio" id="idejercicio" class="form-select" required>
                            <option value="">-- Seleccionar Ejercicio --</option>
                            <?php foreach ($ejercicios as $ej): ?>
                                <option value="<?= $ej['idejercicio'] ?>" <?= (old('idejercicio', $ejecucion['idejercicio']) == $ej['idejercicio']) ? 'selected' : '' ?>>
                                    #<?= $ej['idejercicio'] ?> — <?= esc($ej['nombreespanol']) ?> (<?= esc($ej['nombreingles']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="fecha" class="form-label fw-semibold">Fecha <span class="text-danger">*</span></label>
                            <input type="date" name="fecha" id="fecha" class="form-control" value="<?= old('fecha', $ejecucion['fecha']) ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="horainicio" class="form-label fw-semibold">Hora de Inicio <span class="text-danger">*</span></label>
                            <input type="time" name="horainicio" id="horainicio" class="form-control" value="<?= old('horainicio', substr($ejecucion['horainicio'], 0, 5)) ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="horafin" class="form-label fw-semibold">Hora de Fin <small class="text-muted">(Opcional)</small></label>
                            <input type="time" name="horafin" id="horafin" class="form-control" value="<?= old('horafin', !empty($ejecucion['horafin']) ? substr($ejecucion['horafin'], 0, 5) : '') ?>">
                            <small class="text-muted">Dejar vacío si continúa en ejecución.</small>
                        </div>
                    </div>

                    <div class="card bg-light border-0 p-3 mb-3 rounded-3">
                        <span class="fw-bold text-dark small text-uppercase mb-2 d-block">
                            <i class="bi bi-sliders text-warning me-1"></i> Parámetros de Esfuerzo y Carga del Plan
                        </span>
                        <div class="row g-3">
                            <div class="col-6 col-md-3">
                                <label for="series" class="form-label fw-semibold small">Series</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-white"><i class="bi bi-stack"></i></span>
                                    <input type="number" name="series" id="series" class="form-control" min="0" max="999" step="1"
                                           placeholder="Ej. 4" value="<?= old('series', $ejecucion['series'] ?? '') ?>">
                                </div>
                                <div class="form-text small">Número de series</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <label for="repeticiones" class="form-label fw-semibold small">Repeticiones</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-white"><i class="bi bi-arrow-repeat"></i></span>
                                    <input type="number" name="repeticiones" id="repeticiones" class="form-control" min="0" max="999" step="1"
                                           placeholder="Ej. 12" value="<?= old('repeticiones', $ejecucion['repeticiones'] ?? '') ?>">
                                </div>
                                <div class="form-text small">Reps por serie</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <label for="tiempodescanso" class="form-label fw-semibold small">Descanso (seg)</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-white"><i class="bi bi-stopwatch"></i></span>
                                    <input type="number" name="tiempodescanso" id="tiempodescanso" class="form-control" min="0" max="3600" step="1"
                                           placeholder="Ej. 60" value="<?= old('tiempodescanso', $ejecucion['tiempodescanso'] ?? '') ?>">
                                    <span class="input-group-text bg-white text-muted">s</span>
                                </div>
                                <div class="form-text small">Segundos descanso</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <label for="peso" class="form-label fw-semibold small">Peso (kg)</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-white"><i class="bi bi-speedometer2"></i></span>
                                    <input type="number" name="peso" id="peso" class="form-control" min="0" max="999.99" step="0.25"
                                           placeholder="Ej. 20.00" value="<?= old('peso', isset($ejecucion['peso']) && $ejecucion['peso'] !== null ? number_format((float)$ejecucion['peso'], 2, '.', '') : '') ?>">
                                    <span class="input-group-text bg-white text-muted">kg</span>
                                </div>
                                <div class="form-text small">Carga utilizada</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3 mt-2">
                        <a href="<?= base_url('ejecucionprograma/actual/' . $ejecucion['idejecucionprograma']) ?>" class="btn btn-light border px-4">Cancelar</a>
                        <button type="submit" class="btn btn-warning px-4 fw-bold text-dark">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Ejecución
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
