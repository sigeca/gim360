<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-custom bg-white shadow-sm border-top border-4 border-warning">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <i class="bi bi-pencil-square text-warning me-2"></i>Editar Receta: <?= esc($receta['nombre']) ?>
                </h5>
                <a href="<?= base_url('receta/actual/' . $receta['idreceta']) ?>" class="btn btn-outline-secondary btn-sm">
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

                <form action="<?= base_url('receta/update/' . $receta['idreceta']) ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- Nombre de la Receta -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">
                            Nombre del Platillo / Receta <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-book-half text-warning"></i></span>
                            <input type="text" 
                                   class="form-control <?= session('errors.nombre') ? 'is-invalid' : '' ?>" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="<?= old('nombre', $receta['nombre']) ?>" 
                                   maxlength="150" 
                                   required 
                                   autofocus>
                        </div>
                    </div>

                    <!-- Porciones y Tiempo de Preparación -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="porciones" class="form-label fw-bold">
                                Porciones / Rendimiento
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-people-fill text-primary"></i></span>
                                <input type="number" 
                                       class="form-control <?= session('errors.porciones') ? 'is-invalid' : '' ?>" 
                                       id="porciones" 
                                       name="porciones" 
                                       value="<?= old('porciones', $receta['porciones'] ?? 1) ?>" 
                                       min="1" 
                                       max="99">
                                <span class="input-group-text small">personas</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="tiempopreparacion" class="form-label fw-bold">
                                Tiempo de Preparación
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-stopwatch text-danger"></i></span>
                                <input type="number" 
                                       class="form-control <?= session('errors.tiempopreparacion') ? 'is-invalid' : '' ?>" 
                                       id="tiempopreparacion" 
                                       name="tiempopreparacion" 
                                       value="<?= old('tiempopreparacion', $receta['tiempopreparacion']) ?>" 
                                       min="0">
                                <span class="input-group-text small">minutos</span>
                            </div>
                        </div>
                    </div>

                    <!-- Instrucciones -->
                    <div class="mb-4">
                        <label for="instrucciones" class="form-label fw-semibold">
                            Instrucciones / Modo de Preparación
                        </label>
                        <textarea name="instrucciones" 
                                  id="instrucciones" 
                                  rows="6" 
                                  class="form-control <?= session('errors.instrucciones') ? 'is-invalid' : '' ?>" 
                                  placeholder="Describe detalladamente los pasos para elaborar la receta..."><?= old('instrucciones', $receta['instrucciones']) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('receta/actual/' . $receta['idreceta']) ?>" class="btn btn-secondary">
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
