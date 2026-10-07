<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-pencil-square text-warning me-2"></i>Editar Programa de Entrenamiento</h2>
                <p class="text-muted mb-0">Modificar relaciones de motivo, rutina o ejercicio en <code>programaentrenamiento</code>.</p>
            </div>
            <a href="<?= base_url('programaentrenamiento/actual/' . $programa['idprogramaentrenamiento']) ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver a Registro
            </a>
        </div>

        <div class="card card-custom bg-white border-top border-4 border-warning">
            <div class="card-body p-4">
                <form action="<?= base_url('programaentrenamiento/update/' . $programa['idprogramaentrenamiento']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">ID Programa de Entrenamiento</label>
                        <input type="text" class="form-control bg-light" value="<?= $programa['idprogramaentrenamiento'] ?>" readonly>
                    </div>

                    <!-- 1. Motivo de Entrenamiento -->
                    <div class="mb-3">
                        <label for="idmotivoentrenamiento" class="form-label fw-semibold">
                            <i class="bi bi-bullseye text-warning me-1"></i>Motivo de Entrenamiento <span class="text-danger">*</span>
                        </label>
                        <select name="idmotivoentrenamiento" id="idmotivoentrenamiento" class="form-select" required autofocus>
                            <option value="">-- Seleccione un Motivo --</option>
                            <?php foreach ($motivos as $m): ?>
                                <option value="<?= $m['idmotivoentrenamiento'] ?>" <?= old('idmotivoentrenamiento', $programa['idmotivoentrenamiento']) == $m['idmotivoentrenamiento'] ? 'selected' : '' ?>>
                                    <?= esc($m['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- 2. Rutina de Ejercicio -->
                    <div class="mb-3">
                        <label for="idrutinaejercicio" class="form-label fw-semibold">
                            <i class="bi bi-calendar2-week text-info me-1"></i>Rutina de Ejercicio <span class="text-danger">*</span>
                        </label>
                        <select name="idrutinaejercicio" id="idrutinaejercicio" class="form-select" required>
                            <option value="">-- Seleccione una Rutina --</option>
                            <?php foreach ($rutinas as $r): ?>
                                <option value="<?= $r['idrutinaejercicio'] ?>" <?= old('idrutinaejercicio', $programa['idrutinaejercicio']) == $r['idrutinaejercicio'] ? 'selected' : '' ?>>
                                    <?= esc($r['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- 3. Ejercicio -->
                    <div class="mb-3">
                        <label for="idejercicio" class="form-label fw-semibold">
                            <i class="bi bi-fire text-danger me-1"></i>Ejercicio Asignado <span class="text-danger">*</span>
                        </label>
                        <select name="idejercicio" id="idejercicio" class="form-select" required>
                            <option value="">-- Seleccione un Ejercicio del Catálogo --</option>
                            <?php foreach ($ejercicios as $e): ?>
                                <option value="<?= $e['idejercicio'] ?>" <?= old('idejercicio', $programa['idejercicio']) == $e['idejercicio'] ? 'selected' : '' ?>>
                                    <?= esc($e['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('programaentrenamiento/actual/' . $programa['idprogramaentrenamiento']) ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Programa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
