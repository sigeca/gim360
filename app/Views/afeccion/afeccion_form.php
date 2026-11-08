<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-custom bg-white border-top border-4 border-danger shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-plus-circle-fill text-danger me-2"></i>Nueva Afección Médica</h5>
                <a href="<?= base_url('afeccion') ?>" class="btn btn-sm btn-outline-secondary">Volver</a>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('afeccion/save') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre de la Afección <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej: Dolor Lumbar, Tendinitis, Asma..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Descripción Clínica</label>
                        <textarea name="descripcion" class="form-control" rows="3" placeholder="Definición o detalles de la afección..."></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Síntomas Característicos</label>
                        <textarea name="sintomas" class="form-control" rows="3" placeholder="Dolor, rigidez, inflamación, dificultad respiratoria..."></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('afeccion') ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-danger px-4"><i class="bi bi-save me-1"></i>Guardar Afección</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
