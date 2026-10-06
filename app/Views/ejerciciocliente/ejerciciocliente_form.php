<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-custom bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-person-walking text-primary me-2"></i>Asignar Ejercicio a Cliente
                    </h5>
                    <a href="<?= base_url('ejerciciocliente/listar') ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>
            <div class="card-body p-4">

                <form method="post" action="<?= base_url('ejerciciocliente/save') ?>">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="idcliente" class="form-label fw-semibold">Cliente <span class="text-danger">*</span></label>
                        <select name="idcliente" id="idcliente" class="form-select" required>
                            <option value="">-- Seleccionar Cliente --</option>
                            <?php foreach ($clientes as $c): ?>
                                <option value="<?= $c['idcliente'] ?>" <?= (old('idcliente', $idclientePreselected ?? '') == $c['idcliente']) ? 'selected' : '' ?>>
                                    <?= esc($c['cedula']) ?> - <?= esc($c['persona_nombres']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="idejercicio" class="form-label fw-semibold">Ejercicio <span class="text-danger">*</span></label>
                        <select name="idejercicio" id="idejercicio" class="form-select" required>
                            <option value="">-- Seleccionar Ejercicio --</option>
                            <?php foreach ($ejercicios as $ej): ?>
                                <option value="<?= $ej['idejercicio'] ?>" <?= (old('idejercicio', $idejercicioPreselected ?? '') == $ej['idejercicio']) ? 'selected' : '' ?>>
                                    <?= esc($ej['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="fecha" class="form-label fw-semibold">Fecha <span class="text-danger">*</span></label>
                            <input type="date" name="fecha" id="fecha" class="form-control" value="<?= old('fecha', date('Y-m-d')) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="duracionminutos" class="form-label fw-semibold">Duración (minutos) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="duracionminutos" id="duracionminutos" class="form-control font-monospace" min="1" max="1440" placeholder="Ej: 30" value="<?= old('duracionminutos', '20') ?>" required>
                                <span class="input-group-text">min</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="<?= base_url('ejerciciocliente') ?>" class="btn btn-light border px-4">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <i class="bi bi-save me-1"></i> Guardar Registro
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
