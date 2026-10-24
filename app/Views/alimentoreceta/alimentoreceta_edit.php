<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-custom bg-white shadow-sm border-top border-4 border-warning">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <i class="bi bi-pencil-square text-warning me-2"></i>Editar Ingrediente de Receta
                </h5>
                <a href="<?= base_url('alimentoreceta/actual/' . $rel['idalimentoreceta']) ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Volver a la Ficha
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

                <form action="<?= base_url('alimentoreceta/update/' . $rel['idalimentoreceta']) ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- Receta -->
                    <div class="mb-3">
                        <label for="idreceta" class="form-label fw-bold">
                            Receta <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-book text-warning"></i></span>
                            <select name="idreceta" id="idreceta" class="form-select <?= session('errors.idreceta') ? 'is-invalid' : '' ?>" required>
                                <option value="">-- Seleccione una receta --</option>
                                <?php 
                                    $currReceta = old('idreceta', $rel['idreceta']);
                                    foreach ($recetas as $rec): 
                                ?>
                                    <option value="<?= $rec['idreceta'] ?>" <?= ((string)$currReceta === (string)$rec['idreceta']) ? 'selected' : '' ?>>
                                        <?= esc($rec['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Alimento / Ingrediente -->
                    <div class="mb-3">
                        <label for="idalimento" class="form-label fw-bold">
                            Alimento / Ingrediente <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-apple text-success"></i></span>
                            <select name="idalimento" id="idalimento" class="form-select <?= session('errors.idalimento') ? 'is-invalid' : '' ?>" required>
                                <option value="">-- Seleccione un alimento --</option>
                                <?php 
                                    $currAlimento = old('idalimento', $rel['idalimento']);
                                    foreach ($alimentos as $ali): 
                                ?>
                                    <option value="<?= $ali['idalimento'] ?>" <?= ((string)$currAlimento === (string)$ali['idalimento']) ? 'selected' : '' ?>>
                                        <?= esc($ali['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Cantidad y Unidad -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="cantidad" class="form-label fw-bold">
                                Cantidad Requerida <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calculator text-primary"></i></span>
                                <input type="number" 
                                       step="any" 
                                       class="form-control <?= session('errors.cantidad') ? 'is-invalid' : '' ?>" 
                                       id="cantidad" 
                                       name="cantidad" 
                                       value="<?= old('cantidad', $rel['cantidad']) ?>" 
                                       required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="idunidadalimento" class="form-label fw-bold">
                                Unidad de Medida <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-rulers text-info"></i></span>
                                <select name="idunidadalimento" id="idunidadalimento" class="form-select <?= session('errors.idunidadalimento') ? 'is-invalid' : '' ?>" required>
                                    <option value="">-- Seleccione unidad --</option>
                                    <?php 
                                        $currUnidad = old('idunidadalimento', $rel['idunidadalimento']);
                                        foreach ($unidades as $u): 
                                    ?>
                                        <option value="<?= $u['idunidadalimento'] ?>" <?= ((string)$currUnidad === (string)$u['idunidadalimento']) ? 'selected' : '' ?>>
                                            <?= esc($u['nombre']) ?> (<?= esc($u['abreviatura']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('alimentoreceta/actual/' . $rel['idalimentoreceta']) ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Guardar Cambios
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
