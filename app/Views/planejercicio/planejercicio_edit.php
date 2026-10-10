<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-pencil-square text-info me-2"></i>Editar Plan de Ejercicio</h2>
                <p class="text-muted mb-0">Modificar parámetros del plan en <code>planejercicio</code>.</p>
            </div>
            <a href="<?= base_url('planejercicio/actual/' . $plan['idplanejercicio']) ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver a Registro
            </a>
        </div>

        <div class="card card-custom bg-white border-top border-4 border-info">
            <div class="card-body p-4">
                <form action="<?= base_url('planejercicio/update/' . $plan['idplanejercicio']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">ID Plan de Ejercicio</label>
                        <input type="text" class="form-control bg-light" value="<?= $plan['idplanejercicio'] ?>" readonly>
                    </div>

                    <!-- 1. Ejercicio Asignado -->
                    <div class="mb-3">
                        <label for="idejercicio" class="form-label fw-semibold">
                            <i class="bi bi-fire text-danger me-1"></i>Ejercicio Asignado <span class="text-danger">*</span>
                        </label>
                        <select name="idejercicio" id="idejercicio" class="form-select" required autofocus>
                            <option value="">-- Seleccione un Ejercicio del Catálogo --</option>
                            <?php foreach ($ejercicios as $e): ?>
                                <option value="<?= $e['idejercicio'] ?>" <?= old('idejercicio', $plan['idejercicio']) == $e['idejercicio'] ? 'selected' : '' ?>>
                                    <?= esc($e['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- 2. Días y Repeticiones -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="diassemanas" class="form-label fw-semibold">
                                <i class="bi bi-calendar3 text-primary me-1"></i>Días por Semana
                            </label>
                            <input type="number" name="diassemanas" id="diassemanas" class="form-control" min="1" step="1" placeholder="Ej. 3" value="<?= esc(old('diassemanas', $plan['diassemanas'] ?? $plan['dias'] ?? '')) ?>">
                            <div class="form-text">Días de entrenamiento por semana (entero).</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="repeticiones" class="form-label fw-semibold">
                                <i class="bi bi-repeat text-success me-1"></i>Repeticiones por Serie
                            </label>
                            <input type="number" name="repeticiones" id="repeticiones" class="form-control" min="1" step="1" placeholder="Ej. 12" value="<?= esc(old('repeticiones', $plan['repeticiones'] ?? '')) ?>">
                            <div class="form-text">Número de repeticiones (entero).</div>
                        </div>
                    </div>

                    <!-- 3. Series, Descanso y Peso -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="series" class="form-label fw-semibold">
                                <i class="bi bi-layers text-secondary me-1"></i>Series
                            </label>
                            <input type="number" name="series" id="series" class="form-control" min="1" step="1" placeholder="Ej. 4" value="<?= esc(old('series', $plan['series'] ?? '')) ?>">
                            <div class="form-text">Número de series (entero).</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tiempodescanso" class="form-label fw-semibold">
                                <i class="bi bi-stopwatch text-warning me-1"></i>Tiempo Descanso (seg)
                            </label>
                            <input type="number" name="tiempodescanso" id="tiempodescanso" class="form-control" min="0" step="1" placeholder="Ej. 60 o 90" value="<?= esc(old('tiempodescanso', $plan['tiempodescanso'] ?? '')) ?>">
                            <div class="form-text">Descanso en segundos (entero).</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="peso" class="form-label fw-semibold">
                                <i class="bi bi-speedometer2 text-danger me-1"></i>Peso (kg)
                            </label>
                            <input type="number" name="peso" id="peso" class="form-control" min="0" step="0.25" placeholder="Ej. 50.00" value="<?= esc(old('peso', $plan['peso'] ?? '')) ?>">
                            <div class="form-text">Carga/peso en kg (decimal).</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('planejercicio/actual/' . $plan['idplanejercicio']) ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-info text-white fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Plan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
