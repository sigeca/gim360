<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Editar Plan de Ejercicio Personalizado
                </h2>
                <p class="text-muted mb-0">Modificar plan personalizado #<?= $plan['idplanpersonalizado'] ?> en <code>planejerciciopersonalizado</code>.</p>
            </div>
            <a href="<?= base_url('planpersonalizado/actual/' . $plan['idplanpersonalizado']) ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver a la Ficha
            </a>
        </div>

        <div class="card card-custom bg-white border-top border-4 border-primary shadow-sm">
            <div class="card-body p-4">
                <form action="<?= base_url('planpersonalizado/update/' . $plan['idplanpersonalizado']) ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- Información de contexto si está vinculado -->
                    <?php if (!empty($plan['cliente_nombres']) || !empty($plan['rutina_nombre'])): ?>
                        <div class="alert alert-info py-2 px-3 small d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-info-circle-fill fs-5"></i>
                            <div>
                                <?php if (!empty($plan['cliente_nombres'])): ?>
                                    Asignado a: <strong><?= esc($plan['cliente_nombres']) ?></strong>
                                <?php endif; ?>
                                <?php if (!empty($plan['rutina_nombre'])): ?>
                                    &bull; Rutina: <strong><?= esc($plan['rutina_nombre']) ?></strong>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- 1. Nombre del Plan de Ejercicio Personalizado -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">
                            <i class="bi bi-tag text-primary me-1"></i>Nombre del Plan Personalizado
                        </label>
                        <input type="text" name="nombre" id="nombre" class="form-control" maxlength="150" value="<?= esc(old('nombre', $plan['nombre'] ?? '')) ?>" required>
                        <div class="form-text">Nombre descriptivo del plan (máx. 150 caracteres).</div>
                    </div>

                    <!-- 2. Ejercicio Asignado -->
                    <div class="mb-4">
                        <label for="idejercicio" class="form-label fw-semibold">
                            <i class="bi bi-fire text-danger me-1"></i>Ejercicio Asignado <span class="text-danger">*</span>
                        </label>
                        <select name="idejercicio" id="idejercicio" class="form-select" required>
                            <option value="">-- Seleccione un Ejercicio --</option>
                            <?php foreach ($ejercicios as $e): ?>
                                <option value="<?= $e['idejercicio'] ?>" <?= old('idejercicio', $plan['idejercicio']) == $e['idejercicio'] ? 'selected' : '' ?>>
                                    <?= esc($e['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- NUEVOS CAMPOS: FECHA INICIO Y DURACIÓN EN SEMANAS -->
                    <div class="row bg-light rounded p-3 mb-3 border">
                        <div class="col-12 mb-2">
                            <h6 class="fw-bold text-primary mb-1">
                                <i class="bi bi-calendar-range-fill me-1"></i>Vigencia y Programación
                            </h6>
                            <small class="text-muted">Fecha en la que inicia este ejercicio y duración total en semanas.</small>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="fechainicio" class="form-label fw-semibold">
                                <i class="bi bi-calendar-event text-primary me-1"></i>Fecha de Inicio <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="fechainicio" id="fechainicio" class="form-control" value="<?= esc(old('fechainicio', $plan['fechainicio'] ?? date('Y-m-d'))) ?>" required>
                            <div class="form-text">Día en que inicia el plan del ejercicio.</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="duracionsemana" class="form-label fw-semibold">
                                <i class="bi bi-hourglass-split text-warning me-1"></i>Duración (Semanas) <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="duracionsemana" id="duracionsemana" class="form-control" min="1" max="104" step="1" value="<?= esc(old('duracionsemana', $plan['duracionsemana'] ?? 4)) ?>" required>
                            <div class="form-text">Cuántas semanas va a durar ese ejercicio (entero).</div>
                        </div>
                    </div>

                    <!-- Parámetros de Entrenamiento -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="diassemanas" class="form-label fw-semibold">
                                <i class="bi bi-calendar3 text-primary me-1"></i>Días por Semana
                            </label>
                            <input type="number" name="diassemanas" id="diassemanas" class="form-control" min="1" max="7" step="1" value="<?= esc(old('diassemanas', $plan['diassemanas'] ?? 3)) ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="repeticiones" class="form-label fw-semibold">
                                <i class="bi bi-repeat text-success me-1"></i>Repeticiones por Serie
                            </label>
                            <input type="number" name="repeticiones" id="repeticiones" class="form-control" min="1" step="1" value="<?= esc(old('repeticiones', $plan['repeticiones'] ?? 12)) ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="series" class="form-label fw-semibold">
                                <i class="bi bi-layers text-secondary me-1"></i>Series
                            </label>
                            <input type="number" name="series" id="series" class="form-control" min="1" step="1" value="<?= esc(old('series', $plan['series'] ?? 3)) ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tiempodescanso" class="form-label fw-semibold">
                                <i class="bi bi-stopwatch text-warning me-1"></i>Descanso (segundos)
                            </label>
                            <input type="number" name="tiempodescanso" id="tiempodescanso" class="form-control" min="0" step="5" value="<?= esc(old('tiempodescanso', $plan['tiempodescanso'] ?? 60)) ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="peso" class="form-label fw-semibold">
                                <i class="bi bi-speedometer2 text-danger me-1"></i>Peso (kg)
                            </label>
                            <input type="number" name="peso" id="peso" class="form-control" min="0" step="0.25" value="<?= esc(old('peso', $plan['peso'] ?? 0.00)) ?>">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3 mt-3">
                        <a href="<?= base_url('planpersonalizado/actual/' . $plan['idplanpersonalizado']) ?>" class="btn btn-outline-secondary px-4">Cancelar</a>
                        <button type="submit" class="btn btn-primary fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Plan Personalizado
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
