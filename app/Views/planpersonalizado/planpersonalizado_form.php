<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-person-check-fill text-primary me-2"></i>Nuevo Plan de Ejercicio Personalizado
                </h2>
                <p class="text-muted mb-0">Registrar un plan particularizado en <code>planejerciciopersonalizado</code> con fecha de inicio y duración.</p>
            </div>
            <a href="<?= base_url('planpersonalizado/listar') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver al Listado
            </a>
        </div>

        <div class="card card-custom bg-white border-top border-4 border-primary shadow-sm">
            <div class="card-body p-4">
                <form action="<?= base_url('planpersonalizado/save') ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- 1. Nombre del Plan de Ejercicio Personalizado -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">
                            <i class="bi bi-tag text-primary me-1"></i>Nombre del Plan Personalizado
                        </label>
                        <input type="text" name="nombre" id="nombre" class="form-control" maxlength="150" placeholder="Ej. Sentadilla Progresiva Cliente Juan, Press Banca 4x10..." value="<?= esc(old('nombre')) ?>" autofocus>
                        <div class="form-text">Opcional. Si se deja en blanco se generará automáticamente según el ejercicio.</div>
                    </div>

                    <!-- 2. Rutina Personalizada (Opcional) -->
                    <?php if (!empty($rutinas)): ?>
                    <div class="mb-3">
                        <label for="idrutinapersonalizada" class="form-label fw-semibold">
                            <i class="bi bi-calendar2-week text-info me-1"></i>Rutina Personalizada Destino (Opcional)
                        </label>
                        <select name="idrutinapersonalizada" id="idrutinapersonalizada" class="form-select">
                            <option value="">-- Sin vincular a rutina inmediatamente --</option>
                            <?php foreach ($rutinas as $r): ?>
                                <option value="<?= $r['idrutinapersonalizada'] ?>" <?= old('idrutinapersonalizada', $idrutinaPreselected ?? '') == $r['idrutinapersonalizada'] ? 'selected' : '' ?>>
                                    #<?= $r['idrutinapersonalizada'] ?> - <?= esc($r['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Si seleccionas una rutina, el plan se vinculará a ella automáticamente.</div>
                    </div>
                    <?php endif; ?>

                    <!-- 3. Ejercicio Asignado -->
                    <div class="mb-4">
                        <label for="idejercicio" class="form-label fw-semibold">
                            <i class="bi bi-fire text-danger me-1"></i>Ejercicio Asignado <span class="text-danger">*</span>
                        </label>
                        <select name="idejercicio" id="idejercicio" class="form-select" required>
                            <option value="">-- Seleccione un Ejercicio --</option>
                            <?php foreach ($ejercicios as $e): ?>
                                <option value="<?= $e['idejercicio'] ?>"
                                        data-imagen="<?= esc($e['imagen'] ?? '') ?>"
                                        data-nombre="<?= esc($e['nombre']) ?>"
                                        <?= old('idejercicio', $idejercicioPreselected ?? '') == $e['idejercicio'] ? 'selected' : '' ?>>
                                    <?= esc($e['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Ejercicio específico del plan de entrenamiento.</div>
                    </div>

                    <!-- NUEVOS CAMPOS: FECHA INICIO Y DURACIÓN EN SEMANAS -->
                    <div class="row bg-light rounded p-3 mb-3 border">
                        <div class="col-12 mb-2">
                            <h6 class="fw-bold text-primary mb-1">
                                <i class="bi bi-calendar-range-fill me-1"></i>Programación de Inicio y Duración
                            </h6>
                            <small class="text-muted">Parámetros requeridos para controlar la vigencia del ejercicio en semanas.</small>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="fechainicio" class="form-label fw-semibold">
                                <i class="bi bi-calendar-event text-primary me-1"></i>Fecha de Inicio <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="fechainicio" id="fechainicio" class="form-control" value="<?= old('fechainicio', date('Y-m-d')) ?>" required>
                            <div class="form-text">Fecha en la que inicia este plan de ejercicio.</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="duracionsemana" class="form-label fw-semibold">
                                <i class="bi bi-hourglass-split text-warning me-1"></i>Duración (Semanas) <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="duracionsemana" id="duracionsemana" class="form-control" min="1" max="104" step="1" placeholder="Ej. 4" value="<?= old('duracionsemana', 4) ?>" required>
                            <div class="form-text">Cuántas semanas va a durar este ejercicio (entero).</div>
                        </div>
                    </div>

                    <!-- Parámetros de Entrenamiento -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="diassemanas" class="form-label fw-semibold">
                                <i class="bi bi-calendar3 text-primary me-1"></i>Días por Semana
                            </label>
                            <input type="number" name="diassemanas" id="diassemanas" class="form-control" min="1" max="7" step="1" placeholder="Ej. 3" value="<?= esc(old('diassemanas', 3)) ?>">
                            <div class="form-text">Frecuencia semanal recomendada.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="repeticiones" class="form-label fw-semibold">
                                <i class="bi bi-repeat text-success me-1"></i>Repeticiones por Serie
                            </label>
                            <input type="number" name="repeticiones" id="repeticiones" class="form-control" min="1" step="1" placeholder="Ej. 12" value="<?= esc(old('repeticiones', 12)) ?>">
                            <div class="form-text">Número de repeticiones por cada serie.</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="series" class="form-label fw-semibold">
                                <i class="bi bi-layers text-secondary me-1"></i>Series
                            </label>
                            <input type="number" name="series" id="series" class="form-control" min="1" step="1" placeholder="Ej. 3" value="<?= esc(old('series', 3)) ?>">
                            <div class="form-text">Número de series.</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tiempodescanso" class="form-label fw-semibold">
                                <i class="bi bi-stopwatch text-warning me-1"></i>Descanso (segundos)
                            </label>
                            <input type="number" name="tiempodescanso" id="tiempodescanso" class="form-control" min="0" step="5" placeholder="Ej. 60" value="<?= esc(old('tiempodescanso', 60)) ?>">
                            <div class="form-text">Tiempo entre series (seg).</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="peso" class="form-label fw-semibold">
                                <i class="bi bi-speedometer2 text-danger me-1"></i>Peso (kg)
                            </label>
                            <input type="number" name="peso" id="peso" class="form-control" min="0" step="0.25" placeholder="Ej. 20.00" value="<?= esc(old('peso', '0.00')) ?>">
                            <div class="form-text">Carga asignada (kg).</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3 mt-3">
                        <a href="<?= base_url('planpersonalizado/listar') ?>" class="btn btn-outline-secondary px-4">Cancelar</a>
                        <button type="submit" class="btn btn-primary fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Guardar Plan Personalizado
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
