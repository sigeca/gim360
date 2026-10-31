<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        
        <div class="card card-custom bg-white border-top border-4 border-success shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <i class="bi bi-cloud-plus-fill text-success me-2 fs-4"></i>Registrar Nueva Imagen
                </h5>
                <a href="<?= base_url('imagen') ?>" class="btn btn-sm btn-outline-secondary">
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

                <form action="<?= base_url('imagen/save') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <!-- Sección: Archivo Físico -->
                    <div class="p-3 mb-4 bg-light rounded-3 border border-success-subtle">
                        <label for="archivo_imagen" class="form-label fw-bold text-success">
                            <i class="bi bi-file-earmark-arrow-up me-1"></i>Archivo de Imagen a Subir
                        </label>
                        <input type="file" name="archivo_imagen" id="archivo_imagen" class="form-control" accept="image/*">
                        <div class="form-text text-muted">
                            Se guardará físicamente en <code>repositorio/imagen/</code> con el formato de nombre automático SICA: <code>YYYYmmdd_HHiiss-00000.ext</code>.
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="fechacaptura" class="form-label fw-bold">Fecha de Captura</label>
                            <input type="date" name="fechacaptura" id="fechacaptura" class="form-control" value="<?= old('fechacaptura', date('Y-m-d')) ?>">
                            <div class="form-text text-muted">Momento en que fue tomada o creada la imagen.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="idformatoimagen" class="form-label fw-bold">Formato de Imagen</label>
                            <select name="idformatoimagen" id="idformatoimagen" class="form-select">
                                <option value="">-- Automático según archivo --</option>
                                <?php foreach ($formatos as $fmt): ?>
                                    <option value="<?= $fmt['idformatoimagen'] ?>" <?= old('idformatoimagen') == $fmt['idformatoimagen'] ? 'selected' : '' ?>>
                                        <?= strtoupper(esc($fmt['nombre'])) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text text-muted">Extensión esperada (.jpg, .png, .webp...).</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label fw-bold">Descripción de la Imagen</label>
                        <textarea name="descripcion" id="descripcion" rows="3" class="form-control" placeholder="Detalle sobre el contenido o uso de la imagen..."><?= old('descripcion') ?></textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="palabrasclave" class="form-label fw-bold">Palabras Clave (Tags)</label>
                            <input type="text" name="palabrasclave" id="palabrasclave" class="form-control" placeholder="gimnasio, ejercicio, nutricion, etc." value="<?= old('palabrasclave') ?>">
                            <div class="form-text text-muted">Separadas por comas.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="licencia" class="form-label fw-bold">Licencia de Uso</label>
                            <input type="text" name="licencia" id="licencia" class="form-control" placeholder="Propietaria / Creative Commons / Libre" value="<?= old('licencia', 'Propietaria') ?>">
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="idordenador" class="form-label fw-bold">Servidor / Ordenador</label>
                            <select name="idordenador" id="idordenador" class="form-select">
                                <?php foreach ($ordenadores as $ord): ?>
                                    <option value="<?= $ord['idordenador'] ?>" <?= old('idordenador') == $ord['idordenador'] ? 'selected' : '' ?>>
                                        <?= esc($ord['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="iddirectorio" class="form-label fw-bold">Directorio de Almacenamiento</label>
                            <select name="iddirectorio" id="iddirectorio" class="form-select">
                                <?php foreach ($directorios as $dir): ?>
                                    <option value="<?= $dir['iddirectorio'] ?>" <?= old('iddirectorio') == $dir['iddirectorio'] ? 'selected' : '' ?>>
                                        <?= esc($dir['nombre']) ?> (<?= esc($dir['ruta']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('imagen') ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i> Guardar Imagen
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
