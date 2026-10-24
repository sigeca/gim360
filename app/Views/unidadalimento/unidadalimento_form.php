<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-custom bg-white shadow-sm border-top border-4 border-info">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <i class="bi bi-plus-circle-fill text-info me-2"></i>Registrar Unidad de Medida
                </h5>
                <a href="<?= base_url('unidadalimento/listar') ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Volver a la Lista
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

                <form action="<?= base_url('unidadalimento/save') ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- Nombre de la Unidad -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">
                            Nombre de la Unidad <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-tag text-info"></i></span>
                            <input type="text" 
                                   class="form-control <?= session('errors.nombre') ? 'is-invalid' : '' ?>" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="<?= old('nombre') ?>" 
                                   placeholder="Ej: Gramo, Mililitro, Cucharada, Taza..." 
                                   maxlength="50" 
                                   required 
                                   autofocus>
                        </div>
                    </div>

                    <!-- Abreviatura -->
                    <div class="mb-4">
                        <label for="abreviatura" class="form-label fw-bold">
                            Abreviatura / Símbolo <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-rulers text-info"></i></span>
                            <input type="text" 
                                   class="form-control font-monospace <?= session('errors.abreviatura') ? 'is-invalid' : '' ?>" 
                                   id="abreviatura" 
                                   name="abreviatura" 
                                   value="<?= old('abreviatura') ?>" 
                                   placeholder="Ej: g, ml, cda, tz, unid..." 
                                   maxlength="15" 
                                   required>
                        </div>
                        <div class="form-text text-muted">Símbolo corto que aparecerá junto a las cantidades en las recetas.</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('unidadalimento') ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-info text-white fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Guardar Unidad
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
