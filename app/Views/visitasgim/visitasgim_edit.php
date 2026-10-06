<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-custom bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-pencil-square text-success me-2"></i>Editar Visita #<?= $visita['idvisitasgim'] ?>
                    </h5>
                    <a href="<?= base_url('visitasgim/actual/' . $visita['idvisitasgim']) ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>
            <div class="card-body p-4">

                <form method="post" action="<?= base_url('visitasgim/update/' . $visita['idvisitasgim']) ?>">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="idcliente" class="form-label fw-semibold">Cliente <span class="text-danger">*</span></label>
                        <select name="idcliente" id="idcliente" class="form-select" required>
                            <option value="">-- Seleccionar Cliente --</option>
                            <?php foreach ($clientes as $c): ?>
                                <option value="<?= $c['idcliente'] ?>" <?= (old('idcliente', $visita['idcliente']) == $c['idcliente']) ? 'selected' : '' ?>>
                                    <?= esc($c['cedula']) ?> - <?= esc($c['persona_nombres']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="fecha" class="form-label fw-semibold">Fecha <span class="text-danger">*</span></label>
                        <input type="date" name="fecha" id="fecha" class="form-control" value="<?= old('fecha', $visita['fecha']) ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="horaingreso" class="form-label fw-semibold">Hora de Ingreso <span class="text-danger">*</span></label>
                            <input type="time" name="horaingreso" id="horaingreso" class="form-control" value="<?= old('horaingreso', substr($visita['horaingreso'], 0, 5)) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="horasalida" class="form-label fw-semibold">Hora de Salida <small class="text-muted">(Opcional)</small></label>
                            <input type="time" name="horasalida" id="horasalida" class="form-control" value="<?= old('horasalida', !empty($visita['horasalida']) ? substr($visita['horasalida'], 0, 5) : '') ?>">
                            <small class="text-muted">Dejar vacío si el cliente continúa en el gimnasio.</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="<?= base_url('visitasgim/actual/' . $visita['idvisitasgim']) ?>" class="btn btn-light border px-4">Cancelar</a>
                        <button type="submit" class="btn btn-success px-4 fw-bold">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Visita
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
