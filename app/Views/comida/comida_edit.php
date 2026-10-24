<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-custom bg-white shadow-sm border-top border-4 border-warning">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <i class="bi bi-pencil-square text-warning me-2"></i>Editar Comida #<?= $comida['idcomida'] ?>
                </h5>
                <a href="<?= base_url('comida/actual/' . $comida['idcomida']) ?>" class="btn btn-outline-secondary btn-sm">
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

                <form action="<?= base_url('comida/update/' . $comida['idcomida']) ?>" method="post">
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
                                    $currPlan = old('idplanalimentacion', $comida['idplanalimentacion']);
                                    foreach ($planes as $pl): 
                                ?>
                                    <option value="<?= $pl['idplanalimentacion'] ?>" <?= ((string)$currPlan === (string)$pl['idplanalimentacion']) ? 'selected' : '' ?>>
                                        <?= esc($pl['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Tipo / Momento de Comida -->
                    <div class="mb-3">
                        <label for="idtipocomida" class="form-label fw-bold">
                            Momento / Tipo de Comida <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-clock-history text-warning"></i></span>
                            <select name="idtipocomida" id="idtipocomida" class="form-select <?= session('errors.idtipocomida') ? 'is-invalid' : '' ?>" required>
                                <option value="">-- Seleccione el momento del día --</option>
                                <?php 
                                    $currTipo = old('idtipocomida', $comida['idtipocomida']);
                                    foreach ($tipos as $tp): 
                                ?>
                                    <option value="<?= $tp['idtipocomida'] ?>" <?= ((string)$currTipo === (string)$tp['idtipocomida']) ? 'selected' : '' ?>>
                                        <?= esc($tp['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Receta Culinaria Asignada -->
                    <div class="mb-3">
                        <label for="idreceta" class="form-label fw-bold">
                            Receta Culinaria <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-book text-primary"></i></span>
                            <select name="idreceta" id="idreceta" class="form-select <?= session('errors.idreceta') ? 'is-invalid' : '' ?>" required>
                                <option value="">-- Seleccione una receta --</option>
                                <?php 
                                    $currReceta = old('idreceta', $comida['idreceta']);
                                    foreach ($recetas as $rec): 
                                ?>
                                    <option value="<?= $rec['idreceta'] ?>" <?= ((string)$currReceta === (string)$rec['idreceta']) ? 'selected' : '' ?>>
                                        <?= esc($rec['nombre']) ?> (<?= esc($rec['porciones']) ?> porc.)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Hora Recomendada -->
                    <div class="mb-4">
                        <label for="horarecomendada" class="form-label fw-semibold">
                            Hora Recomendada de Ingesta (Opcional)
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-alarm text-info"></i></span>
                            <input type="time" 
                                   class="form-control <?= session('errors.horarecomendada') ? 'is-invalid' : '' ?>" 
                                   id="horarecomendada" 
                                   name="horarecomendada" 
                                   value="<?= old('horarecomendada', !empty($comida['horarecomendada']) ? substr($comida['horarecomendada'], 0, 5) : '') ?>">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('comida/actual/' . $comida['idcomida']) ?>" class="btn btn-secondary">
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
