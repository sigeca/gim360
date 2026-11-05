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
                        <select name="idprogramacliente" id="idprogramacliente" class="form-select" required autofocus autocomplete="off">
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
                        <select name="idejercicio" id="idejercicio" class="form-select" required autocomplete="off">
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

                    <div class="card bg-light border-0 p-3 mb-3 rounded-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-dark small text-uppercase">
                                <i class="bi bi-sliders text-warning me-1"></i> Parámetros de Esfuerzo y Carga del Plan
                            </span>
                            <span class="badge bg-warning-subtle text-dark border border-warning small" id="planDefaultsHint" style="display: none;">
                                <i class="bi bi-magic me-1"></i>Cargados desde el plan
                            </span>
                        </div>
                        <div class="row g-3">
                            <div class="col-6 col-md-3">
                                <label for="series" class="form-label fw-semibold small">Series</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-white"><i class="bi bi-stack"></i></span>
                                    <input type="number" name="series" id="series" class="form-control" min="0" max="999" step="1"
                                           placeholder="Ej. 4" value="<?= old('series', $seriesPreselected ?? '') ?>">
                                </div>
                                <div class="form-text small">Número de series</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <label for="repeticiones" class="form-label fw-semibold small">Repeticiones</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-white"><i class="bi bi-arrow-repeat"></i></span>
                                    <input type="number" name="repeticiones" id="repeticiones" class="form-control" min="0" max="999" step="1"
                                           placeholder="Ej. 12" value="<?= old('repeticiones', $repeticionesPreselected ?? '') ?>">
                                </div>
                                <div class="form-text small">Reps por serie</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <label for="tiempodescanso" class="form-label fw-semibold small">Descanso (seg)</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-white"><i class="bi bi-stopwatch"></i></span>
                                    <input type="number" name="tiempodescanso" id="tiempodescanso" class="form-control" min="0" max="3600" step="1"
                                           placeholder="Ej. 60" value="<?= old('tiempodescanso', $tiempodescansoPreselected ?? '') ?>">
                                    <span class="input-group-text bg-white text-muted">s</span>
                                </div>
                                <div class="form-text small">Segundos entre series</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <label for="peso" class="form-label fw-semibold small">Peso (kg)</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-white"><i class="bi bi-speedometer2"></i></span>
                                    <input type="number" name="peso" id="peso" class="form-control" min="0" max="999.99" step="0.25"
                                           placeholder="Ej. 20.00" value="<?= old('peso', $pesoPreselected ?? '') ?>">
                                    <span class="input-group-text bg-white text-muted">kg</span>
                                </div>
                                <div class="form-text small">Carga utilizada</div>
                            </div>
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

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const params = new URLSearchParams(window.location.search);
        ['idprogramacliente', 'idejercicio', 'series', 'repeticiones', 'tiempodescanso', 'peso'].forEach(function (name) {
            const val = params.get(name);
            const el = document.getElementById(name);
            if (val && el && !el.value) el.value = val;
        });

        const pcSelect = document.getElementById('idprogramacliente');
        const ejSelect = document.getElementById('idejercicio');
        const hintEl   = document.getElementById('planDefaultsHint');

        function maybeFetchPlanDefaults() {
            const pcId = pcSelect ? pcSelect.value : '';
            const ejId = ejSelect ? ejSelect.value : '';
            if (!pcId || !ejId) return;

            // Consultar los valores prescritos en el plan
            fetch('<?= base_url('ejecucionprograma/plan-defaults') ?>?idprogramacliente=' + encodeURIComponent(pcId) + '&idejercicio=' + encodeURIComponent(ejId))
                .then(r => r.json())
                .then(data => {
                    if (data && (data.series !== undefined || data.repeticiones !== undefined)) {
                        const seriesEl = document.getElementById('series');
                        const repsEl   = document.getElementById('repeticiones');
                        const restEl   = document.getElementById('tiempodescanso');
                        const pesoEl   = document.getElementById('peso');

                        let loaded = false;
                        if (seriesEl && (!seriesEl.value || seriesEl.value === '0') && data.series !== null && data.series !== undefined) {
                            seriesEl.value = data.series;
                            loaded = true;
                        }
                        if (repsEl && (!repsEl.value || repsEl.value === '0') && data.repeticiones !== null && data.repeticiones !== undefined) {
                            repsEl.value = data.repeticiones;
                            loaded = true;
                        }
                        if (restEl && (!restEl.value || restEl.value === '0') && data.tiempodescanso !== null && data.tiempodescanso !== undefined) {
                            restEl.value = data.tiempodescanso;
                            loaded = true;
                        }
                        if (pesoEl && (!pesoEl.value || pesoEl.value === '0' || pesoEl.value === '0.00') && data.peso !== null && data.peso !== undefined) {
                            pesoEl.value = parseFloat(data.peso).toFixed(2);
                            loaded = true;
                        }

                        if (loaded && hintEl) {
                            hintEl.style.display = 'inline-flex';
                        }
                    }
                })
                .catch(err => console.log('Sin plan default o error al cargar:', err));
        }

        if (pcSelect) pcSelect.addEventListener('change', maybeFetchPlanDefaults);
        if (ejSelect) ejSelect.addEventListener('change', maybeFetchPlanDefaults);

        // Si ya hay valores seleccionados al inicio pero los campos de esfuerzo están vacíos, buscar
        const sVal = document.getElementById('series')?.value;
        const rVal = document.getElementById('repeticiones')?.value;
        if (!sVal && !rVal && pcSelect?.value && ejSelect?.value) {
            maybeFetchPlanDefaults();
        }
    });
</script>
<?= $this->endSection() ?>

