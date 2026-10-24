<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-custom bg-white shadow-sm border-top border-4 border-warning">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <i class="bi bi-pencil-square text-warning me-2"></i>Editar Alimento: <?= esc($alimento['nombre']) ?>
                </h5>
                <a href="<?= base_url('alimento/actual/' . $alimento['idalimento']) ?>" class="btn btn-outline-secondary btn-sm">
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

                <form action="<?= base_url('alimento/update/' . $alimento['idalimento']) ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- Grupo de Alimento -->
                    <div class="mb-3">
                        <label for="idgrupo" class="form-label fw-bold">
                            Grupo Nutricional <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-diagram-3 text-success"></i></span>
                            <select name="idgrupo" id="idgrupo" class="form-select <?= session('errors.idgrupo') ? 'is-invalid' : '' ?>" required>
                                <option value="">-- Seleccione un grupo de alimento --</option>
                                <?php 
                                    $currGrupo = old('idgrupo', $alimento['idgrupo']);
                                    foreach ($grupos as $g): 
                                ?>
                                    <option value="<?= $g['idgrupoalimento'] ?>" <?= ((string)$currGrupo === (string)$g['idgrupoalimento']) ? 'selected' : '' ?>>
                                        <?= esc($g['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-text text-muted">Clasificación a la que pertenece el alimento.</div>
                    </div>

                    <!-- Nombre del Alimento -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">
                            Nombre del Alimento <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-apple text-success"></i></span>
                            <input type="text" 
                                   class="form-control <?= session('errors.nombre') ? 'is-invalid' : '' ?>" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="<?= old('nombre', $alimento['nombre']) ?>" 
                                   maxlength="150" 
                                   required 
                                   autofocus>
                        </div>
                    </div>

                    <!-- Descripción / Propiedades -->
                    <div class="mb-4">
                        <label for="descripcion" class="form-label fw-semibold">
                            Descripción / Propiedades Nutricionales
                        </label>
                        <textarea name="descripcion" 
                                  id="descripcion" 
                                  rows="4" 
                                  class="form-control" 
                                  placeholder="Detalles sobre porción sugerida, macronutrientes aproximados..."><?= old('descripcion', $alimento['descripcion']) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('alimento/actual/' . $alimento['idalimento']) ?>" class="btn btn-secondary">
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
