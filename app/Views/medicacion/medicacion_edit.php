<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom bg-white border-top border-4 border-primary shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square text-primary me-2"></i>Editar Medicación #<?= $medicacion['idmedicacion'] ?></h5>
                <a href="<?= base_url('medicacion/actual/' . $medicacion['idmedicacion']) ?>" class="btn btn-sm btn-outline-secondary">Volver</a>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('medicacion/update/' . $medicacion['idmedicacion']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Afección Médica <span class="text-danger">*</span></label>
                        <select name="idafeccion" class="form-select" required>
                            <?php foreach ($afecciones as $a): ?>
                                <option value="<?= $a['idafeccion'] ?>" <?= ($medicacion['idafeccion'] == $a['idafeccion']) ? 'selected' : '' ?>>
                                    <?= esc($a['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre de la Medicación <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control" value="<?= esc($medicacion['nombre']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Duración</label>
                        <input type="text" name="duracion" class="form-control" value="<?= esc($medicacion['duracion']) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3"><?= esc($medicacion['descripcion']) ?></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Recomendaciones</label>
                        <textarea name="recomendaciones" class="form-control" rows="3"><?= esc($medicacion['recomendaciones']) ?></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('medicacion/actual/' . $medicacion['idmedicacion']) ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-4">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
