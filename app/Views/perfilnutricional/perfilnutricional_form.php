<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom bg-white shadow-sm border-top border-4 border-success">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <i class="bi bi-heart-pulse-fill text-success me-2"></i>Registrar Control Nutricional
                </h5>
                <a href="<?= base_url('perfilnutricional/listar') ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Volver a la Lista
                </a>
            </div>
            <div class="card-body p-4">

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Por favor corrige los siguientes errores:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('perfilnutricional/save') ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- 1. Selección de Persona -->
                    <div class="mb-3">
                        <label for="idpersona" class="form-label fw-bold">
                            Persona Evaluada <span class="text-danger">*</span>
                        </label>
                        <select name="idpersona" id="idpersona" class="form-select <?= session('errors.idpersona') ? 'is-invalid' : '' ?>" required>
                            <option value="">-- Seleccionar Persona --</option>
                            <?php foreach ($personas as $p): ?>
                                <option value="<?= $p['idpersona'] ?>" <?= old('idpersona', $idpersonaPreselected ?? '') == $p['idpersona'] ? 'selected' : '' ?>>
                                    <?= esc($p['apellidos'] . ' ' . $p['nombres']) ?> (C.I. <?= esc($p['cedula']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Selecciona a la persona a quien se le realiza el pesaje y medición antropométrica.</div>
                    </div>

                    <!-- 2. Fecha de Medición -->
                    <div class="mb-3">
                        <label for="fechamedicion" class="form-label fw-bold">
                            Fecha de Evaluación
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-event text-success"></i></span>
                            <input type="date" 
                                   class="form-control" 
                                   id="fechamedicion" 
                                   name="fechamedicion" 
                                   value="<?= old('fechamedicion', date('Y-m-d')) ?>">
                        </div>
                    </div>

                    <!-- 3. Peso y Estatura con cálculo en vivo -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="peso_kg" class="form-label fw-bold">
                                Peso Corporal (kg) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-speedometer2 text-primary"></i></span>
                                <input type="number" 
                                       step="0.01" 
                                       min="20" 
                                       max="350" 
                                       class="form-control <?= session('errors.peso_kg') ? 'is-invalid' : '' ?>" 
                                       id="peso_kg" 
                                       name="peso_kg" 
                                       value="<?= old('peso_kg') ?>" 
                                       placeholder="Ej: 72.50" 
                                       required>
                                <span class="input-group-text">kg</span>
                            </div>
                            <div class="form-text">Peso corporal en kilogramos.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="estatura_cm" class="form-label fw-bold">
                                Estatura (cm) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-rulers text-info"></i></span>
                                <input type="number" 
                                       step="0.1" 
                                       min="50" 
                                       max="250" 
                                       class="form-control <?= session('errors.estatura_cm') ? 'is-invalid' : '' ?>" 
                                       id="estatura_cm" 
                                       name="estatura_cm" 
                                       value="<?= old('estatura_cm') ?>" 
                                       placeholder="Ej: 175.0" 
                                       required>
                                <span class="input-group-text">cm</span>
                            </div>
                            <div class="form-text">Estatura de pie en centímetros (ej: 175 cm = 1.75 m).</div>
                        </div>
                    </div>

                    <!-- Panel de Cálculo Automático de IMC en Tiempo Real -->
                    <div id="liveImcCard" class="card border border-success bg-light rounded-4 p-3 mb-4 text-center" style="display: none;">
                        <span class="text-muted small fw-semibold text-uppercase">
                            <i class="bi bi-calculator text-success me-1"></i>Índice de Masa Corporal Calculado
                        </span>
                        <div class="d-flex justify-content-center align-items-center gap-3 my-2">
                            <h2 class="fw-bold text-success mb-0" id="liveImcVal">--</h2>
                            <span class="badge bg-success fs-6" id="liveImcBadge">Normal</span>
                        </div>
                        <p class="small text-secondary mb-1" id="liveImcDesc"></p>
                        <small class="text-muted" id="liveIdealRange"></small>
                    </div>

                    <!-- 4. Composición Corporal Opcional (% Grasa y % Músculo) -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="porcentajegrasa" class="form-label fw-semibold">
                                <i class="bi bi-pie-chart text-warning me-1"></i>% Grasa Corporal (Opcional)
                            </label>
                            <div class="input-group">
                                <input type="number" 
                                       step="0.1" 
                                       min="1" 
                                       max="70" 
                                       class="form-control" 
                                       id="porcentajegrasa" 
                                       name="porcentajegrasa" 
                                       value="<?= old('porcentajegrasa') ?>" 
                                       placeholder="Ej: 18.5">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="porcentajemusculo" class="form-label fw-semibold">
                                <i class="bi bi-person-arms-up text-danger me-1"></i>% Masa Muscular (Opcional)
                            </label>
                            <div class="input-group">
                                <input type="number" 
                                       step="0.1" 
                                       min="5" 
                                       max="80" 
                                       class="form-control" 
                                       id="porcentajemusculo" 
                                       name="porcentajemusculo" 
                                       value="<?= old('porcentajemusculo') ?>" 
                                       placeholder="Ej: 36.2">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Observaciones -->
                    <div class="mb-4">
                        <label for="observaciones" class="form-label fw-semibold">
                            Observaciones / Diagnóstico Nutricional
                        </label>
                        <textarea name="observaciones" 
                                  id="observaciones" 
                                  rows="3" 
                                  class="form-control" 
                                  placeholder="Notas dietarias, evolución de peso, recomendaciones, hábitos alimenticios..."><?= old('observaciones') ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('perfilnutricional') ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-success fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Guardar Evaluación
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pesoInput = document.getElementById('peso_kg');
    const estInput = document.getElementById('estatura_cm');
    const card = document.getElementById('liveImcCard');
    const val = document.getElementById('liveImcVal');
    const badge = document.getElementById('liveImcBadge');
    const desc = document.getElementById('liveImcDesc');
    const ideal = document.getElementById('liveIdealRange');

    function actualizarIMC() {
        const p = parseFloat(pesoInput.value);
        const e = parseFloat(estInput.value);

        if (p > 20 && e > 50) {
            const h = e / 100.0;
            const imc = (p / (h * h)).toFixed(2);
            val.textContent = imc;
            card.style.display = 'block';

            const minIdeal = (18.5 * (h * h)).toFixed(1);
            const maxIdeal = (24.9 * (h * h)).toFixed(1);
            ideal.textContent = `Rango de peso saludable para ${e} cm: ${minIdeal} kg - ${maxIdeal} kg`;

            if (imc < 18.5) {
                badge.className = 'badge bg-warning text-dark fs-6';
                badge.textContent = 'Bajo Peso';
                desc.textContent = 'Peso inferior al rango saludable recomendado.';
            } else if (imc <= 24.9) {
                badge.className = 'badge bg-success fs-6';
                badge.textContent = 'Peso Normal / Saludable';
                desc.textContent = 'Rango de peso adecuado para la estatura.';
            } else if (imc <= 29.9) {
                badge.className = 'badge bg-warning text-dark fs-6';
                badge.textContent = 'Sobrepeso';
                desc.textContent = 'Ligero exceso de peso respecto a la estatura.';
            } else if (imc <= 34.9) {
                badge.className = 'badge bg-danger fs-6';
                badge.textContent = 'Obesidad Grado I';
                desc.textContent = 'Obesidad moderada con riesgo cardiovascular.';
            } else if (imc <= 39.9) {
                badge.className = 'badge bg-danger fs-6';
                badge.textContent = 'Obesidad Grado II';
                desc.textContent = 'Obesidad severa que requiere seguimiento nutricional.';
            } else {
                badge.className = 'badge bg-danger fs-6';
                badge.textContent = 'Obesidad Grado III (Mórbida)';
                desc.textContent = 'Riesgo elevado. Control médico prioritario.';
            }
        } else {
            card.style.display = 'none';
        }
    }

    pesoInput.addEventListener('input', actualizarIMC);
    estInput.addEventListener('input', actualizarIMC);
    actualizarIMC();
});
</script>

<?= $this->endSection() ?>
