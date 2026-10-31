<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        
        <div class="card card-custom bg-white border-top border-4 border-success shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <i class="bi bi-bullseye text-success me-2 fs-4"></i>Registrar Objetivo Nutricional
                </h5>
                <a href="<?= base_url('objetivonutricional') ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Regresar
                </a>
            </div>

            <div class="card-body p-4">
                
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            <?php foreach (session('errors') as $err): ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('objetivonutricional/save') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-4">
                        <label for="nombre" class="form-label fw-bold">
                            <i class="bi bi-tag-fill text-success me-1"></i>Nombre del Objetivo Nutricional
                        </label>
                        <input type="text" 
                               name="nombre" 
                               id="nombre" 
                               class="form-control form-control-lg <?= session('errors.nombre') ? 'is-invalid' : '' ?>" 
                               placeholder="Ej: Pérdida de Grasa, Ganancia Muscular, Recomposición Corporal..." 
                               value="<?= old('nombre') ?>" 
                               required 
                               maxlength="500">
                        <div class="form-text text-muted">
                            Especifique la meta o propósito nutricional (máximo 500 caracteres). Este objetivo podrá ser seleccionado al crear o editar planes de alimentación.
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('objetivonutricional') ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i> Guardar Objetivo
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
