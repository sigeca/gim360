<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-custom bg-white shadow-sm border-top border-4 border-warning">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <i class="bi bi-pencil-square text-warning me-2"></i>Editar Asignación #<?= $rel['idalimentocomponentenutricional'] ?>
                </h5>
                <a href="<?= base_url('alimentocomponentenutricional/actual/' . $rel['idalimentocomponentenutricional']) ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Ver Ficha
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

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('alimentocomponentenutricional/update/' . $rel['idalimentocomponentenutricional']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="idalimento" class="form-label fw-bold">
                            Seleccionar Alimento <span class="text-danger">*</span>
                        </label>
                        <select name="idalimento" id="idalimento" class="form-select <?= session('errors.idalimento') ? 'is-invalid' : '' ?>" required>
                            <?php foreach ($alimentos as $ali): ?>
                                <option value="<?= $ali['idalimento'] ?>" <?= (old('idalimento', $rel['idalimento']) == $ali['idalimento']) ? 'selected' : '' ?>>
                                    <?= esc($ali['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="idcomponentenutricional" class="form-label fw-bold">
                            Componente Nutricional <span class="text-danger">*</span>
                        </label>
                        <select name="idcomponentenutricional" id="idcomponentenutricional" class="form-select <?= session('errors.idcomponentenutricional') ? 'is-invalid' : '' ?>" required>
                            <?php foreach ($componentes as $comp): ?>
                                <option value="<?= $comp['idcomponentenutricional'] ?>" <?= (old('idcomponentenutricional', $rel['idcomponentenutricional']) == $comp['idcomponentenutricional']) ? 'selected' : '' ?>>
                                    <?= esc($comp['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('alimentocomponentenutricional/actual/' . $rel['idalimentocomponentenutricional']) ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-warning fw-bold px-4 text-dark">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Asignación
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
