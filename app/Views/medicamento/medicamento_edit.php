<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom bg-white border-top border-4 border-success shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square text-success me-2"></i>Editar Medicamento #<?= $medicamento['idmedicamento'] ?></h5>
                <a href="<?= base_url('medicamento/actual/' . $medicamento['idmedicamento']) ?>" class="btn btn-sm btn-outline-secondary">Volver</a>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('medicamento/update/' . $medicamento['idmedicamento']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nombre Comercial / Denominación <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" class="form-control" value="<?= esc($medicamento['nombre']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Principio Activo</label>
                            <input type="text" name="principioactivo" class="form-control" value="<?= esc($medicamento['principioactivo']) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Concentración</label>
                            <input type="text" name="concentracion" class="form-control" value="<?= esc($medicamento['concentracion']) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Presentación</label>
                            <input type="text" name="presentacion" class="form-control" value="<?= esc($medicamento['presentacion']) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Laboratorio</label>
                            <input type="text" name="laboratorio" class="form-control" value="<?= esc($medicamento['laboratorio']) ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Descripción Farmacológica</label>
                            <textarea name="descripcion" class="form-control" rows="2"><?= esc($medicamento['descripcion']) ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Indicaciones Principales</label>
                            <textarea name="indicaciones" class="form-control" rows="2"><?= esc($medicamento['indicaciones']) ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Contraindicaciones</label>
                            <textarea name="contraindicaciones" class="form-control" rows="2"><?= esc($medicamento['contraindicaciones']) ?></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('medicamento/actual/' . $medicamento['idmedicamento']) ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success px-4">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
