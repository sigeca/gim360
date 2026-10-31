<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        
        <div class="card card-custom bg-white border-top border-4 border-success shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <i class="bi bi-images text-success me-2 fs-4"></i>Asignar Imagen a Componente Nutricional
                </h5>
                <a href="<?= base_url('imagencomponentenutricional') ?>" class="btn btn-sm btn-outline-secondary">
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

                <form action="<?= base_url('imagencomponentenutricional/save') ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- Selección de Componente Nutricional -->
                    <div class="mb-4">
                        <label for="idcomponentenutricional" class="form-label fw-bold">
                            <i class="bi bi-pie-chart-fill text-info me-1"></i>Componente Nutricional
                        </label>
                        <select name="idcomponentenutricional" id="idcomponentenutricional" class="form-select" required>
                            <option value="">-- Seleccione un componente --</option>
                            <?php foreach ($componentes as $comp): ?>
                                <option value="<?= $comp['idcomponentenutricional'] ?>" 
                                    <?= (old('idcomponentenutricional', $preselectedComponente) == $comp['idcomponentenutricional']) ? 'selected' : '' ?>>
                                    <?= esc($comp['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text text-muted">Seleccione el componente nutricional al cual se le asociará la imagen.</div>
                    </div>

                    <!-- Selección de Imagen -->
                    <div class="mb-4">
                        <label for="idimagen" class="form-label fw-bold">
                            <i class="bi bi-image text-primary me-1"></i>Imagen del Repositorio
                        </label>
                        <select name="idimagen" id="idimagen" class="form-select" required>
                            <option value="">-- Seleccione una imagen --</option>
                            <?php foreach ($imagenes as $img): ?>
                                <option value="<?= $img['idimagen'] ?>" 
                                    <?= (old('idimagen', $preselectedImagen) == $img['idimagen']) ? 'selected' : '' ?>>
                                    #<?= $img['idimagen'] ?> - <?= esc($img['nombre']) ?> 
                                    <?= !empty($img['directorio_ruta']) ? ' (' . esc($img['directorio_ruta']) . ')' : '' ?>
                                    <?= !empty($img['descripcion']) ? ' - ' . esc(mb_strimwidth($img['descripcion'], 0, 40, '...')) : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text text-muted">
                            Seleccione la imagen registrada en el catálogo multimedia. Si la imagen no está creada, puede registrarla primero en <a href="<?= base_url('imagen/add') ?>" target="_blank">Imágenes / Multimedia</a>.
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('imagencomponentenutricional') ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i> Guardar Asignación
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
