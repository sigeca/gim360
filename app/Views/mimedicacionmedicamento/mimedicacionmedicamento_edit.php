<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-custom bg-white border-top border-4 border-info shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square text-info me-2"></i>Editar Mi Medicación - Medicamento #<?= $relacion['idmimedicacionmedicamento'] ?></h5>
                <a href="<?= base_url('mimedicacionmedicamento/actual/' . $relacion['idmimedicacionmedicamento']) ?>" class="btn btn-sm btn-outline-secondary">Volver</a>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('mimedicacionmedicamento/update/' . $relacion['idmimedicacionmedicamento']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mi Medicación <span class="text-danger">*</span></label>
                        <select name="idmimedicacion" class="form-select" required>
                            <?php foreach ($misMedicaciones as $mm): ?>
                                <option value="<?= $mm['idmimedicacion'] ?>" <?= ($relacion['idmimedicacion'] == $mm['idmimedicacion']) ? 'selected' : '' ?>><?= esc($mm['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Medicamento <span class="text-danger">*</span></label>
                        <select name="idmedicamento" class="form-select" required>
                            <?php foreach ($medicamentos as $med): ?>
                                <option value="<?= $med['idmedicamento'] ?>" <?= ($relacion['idmedicamento'] == $med['idmedicamento']) ? 'selected' : '' ?>><?= esc($med['nombre']) ?> [<?= esc($med['concentracion'] ?: 'N/A') ?>]</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Dosis</label>
                        <input type="text" name="dosis" class="form-control" value="<?= esc($relacion['dosis']) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Frecuencia</label>
                        <input type="text" name="frecuencia" class="form-control" value="<?= esc($relacion['frecuencia']) ?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Instrucciones</label>
                        <textarea name="instrucciones" class="form-control" rows="2"><?= esc($relacion['instrucciones']) ?></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-info text-dark fw-bold px-4">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
