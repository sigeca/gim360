<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom bg-white border-top border-4 border-primary shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-plus-circle-fill text-primary me-2"></i>Registrar Nueva Medicación</h5>
                <a href="<?= base_url('medicacion') ?>" class="btn btn-sm btn-outline-secondary">Volver</a>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('medicacion/save') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Afección Médica a Aliviar <span class="text-danger">*</span></label>
                        <select name="idafeccion" class="form-select" required>
                            <option value="">-- Seleccionar Afección --</option>
                            <?php foreach ($afecciones as $a): ?>
                                <option value="<?= $a['idafeccion'] ?>" <?= (old('idafeccion', $selectedIdAfeccion) == $a['idafeccion']) ? 'selected' : '' ?>>
                                    <?= esc($a['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Condición física o patología que este protocolo busca tratar o aliviar.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre de la Medicación / Tratamiento <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej: Tratamiento para Espasmos y Contracturas..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Duración Recomendada</label>
                        <input type="text" name="duracion" class="form-control" placeholder="Ej: 5 a 7 días, 2 semanas...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Descripción del Protocolo</label>
                        <textarea name="descripcion" class="form-control" rows="3" placeholder="Objetivos y mecanismo del tratamiento..."></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Recomendaciones y Cuidados</label>
                        <textarea name="recomendaciones" class="form-control" rows="3" placeholder="Tomar tras alimentos, reposo deportivo, hidratación..."></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('medicacion') ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i>Guardar Medicación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
