<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-custom bg-white border-top border-4 border-danger shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square text-danger me-2"></i>Editar Afección #<?= $afeccion['idafeccion'] ?></h5>
                <a href="<?= base_url('afeccion/actual/' . $afeccion['idafeccion']) ?>" class="btn btn-sm btn-outline-secondary">Volver</a>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('afeccion/update/' . $afeccion['idafeccion']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre de la Afección <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control" value="<?= esc($afeccion['nombre']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Descripción Clínica</label>
                        <textarea name="descripcion" class="form-control" rows="3"><?= esc($afeccion['descripcion']) ?></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Síntomas Característicos</label>
                        <textarea name="sintomas" class="form-control" rows="3"><?= esc($afeccion['sintomas']) ?></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('afeccion/actual/' . $afeccion['idafeccion']) ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-danger px-4">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
