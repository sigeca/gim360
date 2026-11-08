<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-custom bg-white border-top border-4 border-success shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-plus-circle text-success me-2"></i>Vincular Medicamento a Medicación</h5>
                <a href="<?= base_url('medicacion') ?>" class="btn btn-sm btn-outline-secondary">Volver</a>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('medicacionmedicamento/save') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Medicación / Tratamiento <span class="text-danger">*</span></label>
                        <select name="idmedicacion" class="form-select" required>
                            <option value="">-- Seleccionar Medicación --</option>
                            <?php foreach ($medicaciones as $m): ?>
                                <option value="<?= $m['idmedicacion'] ?>" <?= (old('idmedicacion', $selectedIdMedicacion) == $m['idmedicacion']) ? 'selected' : '' ?>><?= esc($m['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Medicamento <span class="text-danger">*</span></label>
                        <select name="idmedicamento" class="form-select" required>
                            <option value="">-- Seleccionar Medicamento --</option>
                            <?php foreach ($medicamentos as $med): ?>
                                <option value="<?= $med['idmedicamento'] ?>" <?= (old('idmedicamento', $selectedIdMedicamento) == $med['idmedicamento']) ? 'selected' : '' ?>><?= esc($med['nombre']) ?> [<?= esc($med['concentracion'] ?: 'N/A') ?>]</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Dosis Prescrita</label>
                        <input type="text" name="dosis" class="form-control" placeholder="Ej: 1 tableta (400 mg), 5 ml...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Frecuencia</label>
                        <input type="text" name="frecuencia" class="form-control" placeholder="Ej: Cada 8 horas tras las comidas...">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Instrucciones</label>
                        <textarea name="instrucciones" class="form-control" rows="2" placeholder="Indicaciones específicas..."></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-success px-4"><i class="bi bi-save me-1"></i>Vincular</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
