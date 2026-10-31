<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-custom bg-white shadow-sm border-top border-4 border-warning">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <i class="bi bi-pencil-square text-warning me-2"></i>Editar Cumplimiento #<?= $cumplimiento['idcumplimientoplanalimentacion'] ?>
                </h5>
                <a href="<?= base_url('cumplimientoplanalimentacion/actual/' . $cumplimiento['idcumplimientoplanalimentacion']) ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Cancelar y Volver
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

                <form action="<?= base_url('cumplimientoplanalimentacion/update/' . $cumplimiento['idcumplimientoplanalimentacion']) ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- Plan de Alimentación -->
                    <div class="mb-3">
                        <label for="idplanalimentacion" class="form-label fw-bold">
                            Plan de Alimentación <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-journal-medical text-success"></i></span>
                            <select name="idplanalimentacion" id="idplanalimentacion" class="form-select <?= session('errors.idplanalimentacion') ? 'is-invalid' : '' ?>" required>
                                <option value="">-- Seleccione un plan de alimentación --</option>
                                <?php 
                                    $currPlan = old('idplanalimentacion', $cumplimiento['idplanalimentacion']);
                                    foreach ($planes as $pl): 
                                ?>
                                    <option value="<?= $pl['idplanalimentacion'] ?>" <?= ((string)$currPlan === (string)$pl['idplanalimentacion']) ? 'selected' : '' ?>>
                                        <?= esc($pl['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Comida Programada -->
                    <div class="mb-3">
                        <label for="idcomida" class="form-label fw-bold">
                            Comida Programada <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar2-heart text-warning"></i></span>
                            <select name="idcomida" id="idcomida" class="form-select <?= session('errors.idcomida') ? 'is-invalid' : '' ?>" required>
                                <option value="">-- Seleccione la comida efectuada --</option>
                                <?php 
                                    $currComida = old('idcomida', $cumplimiento['idcomida']);
                                    foreach ($comidas as $cm): 
                                        $diaPref = !empty($cm['diasemana_nombre']) ? '[' . $cm['diasemana_nombre'] . '] ' : '';
                                ?>
                                    <option value="<?= $cm['idcomida'] ?>" <?= ((string)$currComida === (string)$cm['idcomida']) ? 'selected' : '' ?>>
                                        <?= esc($diaPref . $cm['tipocomida_nombre']) ?>: <?= esc($cm['receta_nombre']) ?> <?= !empty($cm['horarecomendada']) ? '(' . substr($cm['horarecomendada'], 0, 5) . ')' : '' ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Fecha y Hora de Cumplimiento -->
                    <div class="mb-4">
                        <label for="fechahora" class="form-label fw-bold">
                            Fecha y Hora de la Ingesta <span class="text-danger">*</span>
                        </label>
                        <?php 
                            $dtVal = old('fechahora', !empty($cumplimiento['fechahora']) ? date('Y-m-d\TH:i', strtotime($cumplimiento['fechahora'])) : date('Y-m-d\TH:i'));
                        ?>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-clock-history text-primary"></i></span>
                            <input type="datetime-local" 
                                   class="form-control <?= session('errors.fechahora') ? 'is-invalid' : '' ?>" 
                                   id="fechahora" 
                                   name="fechahora" 
                                   value="<?= $dtVal ?>" 
                                   required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('cumplimientoplanalimentacion/actual/' . $cumplimiento['idcumplimientoplanalimentacion']) ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-warning fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Cambios
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const planSelect = document.getElementById('idplanalimentacion');
    const comidaSelect = document.getElementById('idcomida');

    if (planSelect && comidaSelect) {
        planSelect.addEventListener('change', function() {
            const planId = this.value;
            comidaSelect.innerHTML = '<option value="">-- Cargando comidas del plan... --</option>';
            
            if (!planId) {
                comidaSelect.innerHTML = '<option value="">-- Seleccione primero un plan --</option>';
                return;
            }

            fetch('<?= base_url('cumplimientoplanalimentacion/comidas-plan/') ?>' + planId)
                .then(response => response.json())
                .then(data => {
                    comidaSelect.innerHTML = '<option value="">-- Seleccione la comida efectuada --</option>';
                    data.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item.idcomida;
                        const dia = item.diasemana_nombre ? '[' + item.diasemana_nombre + '] ' : '';
                        const hora = item.horarecomendada ? ' (' + item.horarecomendada.substring(0, 5) + ')' : '';
                        opt.textContent = dia + item.tipocomida_nombre + ': ' + item.receta_nombre + hora;
                        comidaSelect.appendChild(opt);
                    });
                })
                .catch(err => {
                    comidaSelect.innerHTML = '<option value="">-- Error al cargar comidas --</option>';
                });
        });
    }
});
</script>

<?= $this->endSection() ?>
