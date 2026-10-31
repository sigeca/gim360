<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-custom bg-white shadow-sm border-top border-4 border-warning">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <i class="bi bi-pencil-square text-warning me-2"></i>Editar Asignación Imagen-Receta #<?= $rel['idimagenreceta'] ?>
                </h5>
                <a href="<?= base_url('imagenreceta/actual/' . $rel['idimagenreceta']) ?>" class="btn btn-outline-secondary btn-sm">
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

                <form action="<?= base_url('imagenreceta/update/' . $rel['idimagenreceta']) ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- Selección de Receta -->
                    <div class="mb-4">
                        <label for="idreceta" class="form-label fw-bold">
                            Receta Nutricional <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-book-half text-warning"></i></span>
                            <select name="idreceta" id="idreceta" class="form-select <?= session('errors.idreceta') ? 'is-invalid' : '' ?>" required>
                                <option value="">-- Seleccionar Receta --</option>
                                <?php 
                                    $currReceta = old('idreceta', $rel['idreceta']);
                                    foreach ($recetas as $rec): 
                                ?>
                                    <option value="<?= $rec['idreceta'] ?>" <?= ((string)$currReceta === (string)$rec['idreceta']) ? 'selected' : '' ?>>
                                        <?= esc($rec['nombre']) ?> (<?= esc($rec['porciones'] ?? 1) ?> porción/es)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Selección de Imagen -->
                    <div class="mb-4">
                        <label for="idimagen" class="form-label fw-bold">
                            Imagen del Repositorio <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-image text-primary"></i></span>
                            <select name="idimagen" id="idimagen" class="form-select font-monospace <?= session('errors.idimagen') ? 'is-invalid' : '' ?>" required>
                                <option value="">-- Seleccionar Imagen --</option>
                                <?php 
                                    $currImg = old('idimagen', $rel['idimagen']);
                                    foreach ($imagenes as $img): 
                                ?>
                                    <option value="<?= $img['idimagen'] ?>" <?= ((string)$currImg === (string)$img['idimagen']) ? 'selected' : '' ?>>
                                        #<?= $img['idimagen'] ?> - <?= esc($img['nombre']) ?> <?= !empty($img['descripcion']) ? ' (' . esc(mb_strimwidth($img['descripcion'], 0, 40, '...')) . ')' : '' ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('imagenreceta/actual/' . $rel['idimagenreceta']) ?>" class="btn btn-secondary">
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
