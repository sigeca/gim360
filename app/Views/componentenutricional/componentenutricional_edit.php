<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-custom bg-white shadow-sm border-top border-4 border-warning">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <i class="bi bi-pencil-square text-warning me-2"></i>Editar Componente Nutricional #<?= $componente['idcomponentenutricional'] ?>
                </h5>
                <a href="<?= base_url('componentenutricional/actual/' . $componente['idcomponentenutricional']) ?>" class="btn btn-outline-secondary btn-sm">
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

                <form action="<?= base_url('componentenutricional/update/' . $componente['idcomponentenutricional']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">
                            Nombre del Componente <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-pie-chart-fill text-info"></i></span>
                            <input type="text" 
                                   class="form-control <?= session('errors.nombre') ? 'is-invalid' : '' ?>" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="<?= old('nombre', $componente['nombre']) ?>" 
                                   maxlength="100" 
                                   required 
                                   autofocus>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="descripcion" class="form-label fw-semibold">
                            Descripción / Función Biológica
                        </label>
                        <textarea name="descripcion" 
                                  id="descripcion" 
                                  rows="4" 
                                  class="form-control"><?= old('descripcion', $componente['descripcion']) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('componentenutricional/actual/' . $componente['idcomponentenutricional']) ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-warning fw-bold px-4 text-dark">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Componente
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
