<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        
        <div class="card card-custom bg-white border-top border-4 border-warning shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <i class="bi bi-pencil-square text-warning me-2 fs-4"></i>Editar Imagen #<?= $imagen['idimagen'] ?>
                </h5>
                <a href="<?= base_url('imagen/actual/' . $imagen['idimagen']) ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Regresar a Ficha
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

                <form action="<?= base_url('imagen/update/' . $imagen['idimagen']) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <!-- Nombre de Archivo Actual -->
                    <div class="mb-3 p-3 bg-light rounded-3 border">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <?php if (!empty($archivoExiste) && !empty($urlImagen)): ?>
                                    <img src="<?= $urlImagen ?>" 
                                         onerror="this.onerror=null; this.src='<?= !empty($urlFallback) ? $urlFallback : base_url('imagen/imagen/' . esc($imagen['nombre'])) ?>';"
                                         alt="Preview" class="rounded border shadow-sm" style="width: 54px; height: 54px; object-fit: cover;">
                                <?php endif; ?>
                                <div>
                                    <span class="small text-muted d-block">Nombre de Archivo Actual:</span>
                                    <strong class="font-monospace text-dark"><?= esc($imagen['nombre'] ?: 'Sin archivo') ?></strong>
                                    <span class="d-block small text-muted font-monospace"><i class="bi bi-folder me-1"></i><?= esc($directorioRuta ?? ($imagen['directorio_ruta'] ?: 'repositorio/imagen')) ?></span>
                                </div>
                            </div>
                            <span class="badge bg-secondary">ID #<?= $imagen['idimagen'] ?></span>
                        </div>
                    </div>

                    <!-- Sección: Reemplazar Archivo Físico -->
                    <div class="p-3 mb-4 bg-light rounded-3 border border-warning-subtle">
                        <label for="archivo_imagen" class="form-label fw-bold text-dark">
                            <i class="bi bi-cloud-arrow-up text-warning me-1"></i>Reemplazar Archivo Físico (Opcional)
                        </label>
                        <input type="file" name="archivo_imagen" id="archivo_imagen" class="form-control" accept="image/*">
                        <div class="form-text text-muted">
                            Si selecciona un nuevo archivo, se guardará en su directorio configurado: <code><?= esc($directorioRuta ?? ($imagen['directorio_ruta'] ?: 'repositorio/imagen')) ?>/<?= esc($imagen['nombre']) ?></code>.
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="fechacaptura" class="form-label fw-bold">Fecha de Captura</label>
                            <input type="date" name="fechacaptura" id="fechacaptura" class="form-control" 
                                   value="<?= old('fechacaptura', !empty($imagen['fechacaptura']) ? substr($imagen['fechacaptura'], 0, 10) : date('Y-m-d')) ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="idformatoimagen" class="form-label fw-bold">Formato de Imagen</label>
                            <select name="idformatoimagen" id="idformatoimagen" class="form-select">
                                <option value="">-- Seleccione --</option>
                                <?php foreach ($formatos as $fmt): ?>
                                    <option value="<?= $fmt['idformatoimagen'] ?>" <?= old('idformatoimagen', $imagen['idformatoimagen']) == $fmt['idformatoimagen'] ? 'selected' : '' ?>>
                                        <?= strtoupper(esc($fmt['nombre'])) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label fw-bold">Descripción de la Imagen</label>
                        <textarea name="descripcion" id="descripcion" rows="3" class="form-control"><?= old('descripcion', $imagen['descripcion']) ?></textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="palabrasclave" class="form-label fw-bold">Palabras Clave (Tags)</label>
                            <input type="text" name="palabrasclave" id="palabrasclave" class="form-control" value="<?= old('palabrasclave', $imagen['palabrasclave']) ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="licencia" class="form-label fw-bold">Licencia de Uso</label>
                            <input type="text" name="licencia" id="licencia" class="form-control" value="<?= old('licencia', $imagen['licencia']) ?>">
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="idordenador" class="form-label fw-bold">Servidor / Ordenador</label>
                            <select name="idordenador" id="idordenador" class="form-select">
                                <?php foreach ($ordenadores as $ord): ?>
                                    <option value="<?= $ord['idordenador'] ?>" <?= old('idordenador', $imagen['idordenador']) == $ord['idordenador'] ? 'selected' : '' ?>>
                                        <?= esc($ord['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="iddirectorio" class="form-label fw-bold">Directorio de Almacenamiento</label>
                            <select name="iddirectorio" id="iddirectorio" class="form-select">
                                <?php foreach ($directorios as $dir): ?>
                                    <option value="<?= $dir['iddirectorio'] ?>" <?= old('iddirectorio', $imagen['iddirectorio']) == $dir['iddirectorio'] ? 'selected' : '' ?>>
                                        <?= esc($dir['nombre']) ?> (<?= esc($dir['ruta']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('imagen/actual/' . $imagen['idimagen']) ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-warning text-dark fw-semibold">
                            <i class="bi bi-check2-circle me-1"></i> Guardar Cambios
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
