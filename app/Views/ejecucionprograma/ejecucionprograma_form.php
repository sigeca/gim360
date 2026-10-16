<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-custom bg-white border-top border-4 border-warning">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-play-btn-fill text-warning me-2"></i>Registrar Ejecución de Programa
                    </h5>
                    <a href="<?= base_url('ejecucionprograma/listar') ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>
            <div class="card-body p-4">

                <form method="post" action="<?= base_url('ejecucionprograma/save') ?>">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="idprogramacliente" class="form-label fw-semibold">Programa Cliente <span class="text-danger">*</span></label>
                        <select name="idprogramacliente" id="idprogramacliente" class="form-select" required autofocus>
                            <option value="">-- Seleccionar Programa Asignado al Cliente --</option>
                            <?php foreach ($programasClientes as $pc): ?>
                                <option value="<?= $pc['idprogramacliente'] ?>" <?= ((string) (!empty($idProgramaClientePreselected) ? $idProgramaClientePreselected : old('idprogramacliente', '')) === (string) $pc['idprogramacliente']) ? 'selected' : '' ?>>
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
                                <option value="<?= $ej['idejercicio'] ?>" <?= ((string) (!empty($idEjercicioPreselected) ? $idEjercicioPreselected : old('idejercicio', '')) === (string) $ej['idejercicio']) ? 'selected' : '' ?>>
                                    #<?= $ej['idejercicio'] ?> — <?= esc($ej['nombreespanol']) ?> (<?= esc($ej['nombreingles']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="fecha" class="form-label fw-semibold">Fecha <span class="text-danger">*</span></label>
                            <input type="date" name="fecha" id="fecha" class="form-control" value="<?= old('fecha', date('Y-m-d')) ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="horainicio" class="form-label fw-semibold">Hora de Inicio <span class="text-danger">*</span></label>
                            <input type="time" name="horainicio" id="horainicio" class="form-control" value="<?= old('horainicio', date('H:i')) ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="horafin" class="form-label fw-semibold">Hora de Fin <small class="text-muted">(Opcional)</small></label>
                            <input type="time" name="horafin" id="horafin" class="form-control" value="<?= old('horafin') ?>">
                            <small class="text-muted">Dejar vacío si aún está en ejecución.</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3 mt-2">
                        <a href="<?= base_url('ejecucionprograma') ?>" class="btn btn-light border px-4">Cancelar</a>
                        <button type="submit" class="btn btn-warning px-4 fw-bold text-dark">
                            <i class="bi bi-save me-1"></i> Guardar Ejecución
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
