<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-custom bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-pencil-square text-danger me-2"></i>Editar Ejercicio: <?= esc($ejercicio['nombreespanol']) ?>
                    </h5>
                    <a href="<?= base_url('ejercicio/actual/' . $ejercicio['idejercicio']) ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>
            <div class="card-body p-4">

                <form method="post" action="<?= base_url('ejercicio/update/' . $ejercicio['idejercicio']) ?>">
                    <?= csrf_field() ?>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="nombreespanol" class="form-label fw-semibold">Nombre en Español <span class="text-danger">*</span></label>
                            <input type="text" name="nombreespanol" id="nombreespanol" class="form-control" value="<?= old('nombreespanol', $ejercicio['nombreespanol']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nombreingles" class="form-label fw-semibold">Nombre en Inglés <span class="text-danger">*</span></label>
                            <input type="text" name="nombreingles" id="nombreingles" class="form-control" value="<?= old('nombreingles', $ejercicio['nombreingles']) ?>" required>
                        </div>
                    </div>

                    <!-- Tren Muscular -->
                    <div class="mb-3">
                        <label for="idtrenmuscular" class="form-label fw-semibold">
                            <i class="bi bi-layers-half text-info me-1"></i>Tren Muscular
                        </label>
                        <select name="idtrenmuscular" id="idtrenmuscular" class="form-select">
                            <option value="">-- Sin asignar / General --</option>
                            <?php foreach ($todosLosTrenes ?? [] as $tren): ?>
                                <option value="<?= $tren['idtrenmuscular'] ?>" <?= (old('idtrenmuscular', $ejercicio['idtrenmuscular'] ?? '') == $tren['idtrenmuscular']) ? 'selected' : '' ?>>
                                    <?= esc($tren['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Clasificación anatómica del ejercicio (Tren Superior, Tren Inferior, Core, etc.).</small>
                    </div>

                    <div class="mb-3">
                        <label for="imagen" class="form-label fw-semibold">Nombre de Archivo de Imagen Animada</label>
                        <?php if (!empty($ejercicio['imagen'])): ?>
                            <div class="d-flex align-items-center gap-3 mb-2 p-2 bg-light rounded border">
                                <img src="<?= base_url('ejercicio/imagen/' . esc($ejercicio['imagen'])) ?>" 
                                     alt="Preview" 
                                     class="rounded border bg-white" 
                                     style="width: 70px; height: 70px; object-fit: contain;">
                                <div>
                                    <div class="fw-semibold text-dark small"><?= esc($ejercicio['imagen']) ?></div>
                                    <small class="text-muted">Vista previa de la animación actual</small>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-file-earmark-image text-danger"></i></span>
                            <input type="text" name="imagen" id="imagen" class="form-control" value="<?= old('imagen', $ejercicio['imagen']) ?>" placeholder="Ej: squat.webp">
                        </div>
                        <small class="text-muted">Archivo .webp animado en <code>/repositorio/ejercicios/</code>.</small>
                    </div>

                    <div class="mb-3">
                        <label for="urlvideo" class="form-label fw-semibold">URL de Video Tutorial / Demostración</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-youtube text-danger"></i></span>
                            <input type="url" name="urlvideo" id="urlvideo" class="form-control" value="<?= old('urlvideo', $ejercicio['urlvideo']) ?>">
                        </div>
                    </div>

                    <!-- Selección de Músculos Involucrados -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold d-block">
                            <i class="bi bi-person-arms-up text-danger me-1"></i>Músculos Afectados / Involucrados
                        </label>
                        <small class="text-muted d-block mb-2">Marque los músculos que son estimulados por este ejercicio:</small>
                        <div class="p-3 bg-light rounded border" style="max-height: 260px; overflow-y: auto;">
                            <div class="row g-2">
                                <?php foreach ($todosLosMusculos as $tm): ?>
                                    <?php $checked = in_array($tm['idmusculo'], (array)old('musculos', $musculosAsignados)); ?>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-check p-2 bg-white rounded border d-flex align-items-center gap-2">
                                            <input class="form-check-input ms-0 me-2" type="checkbox" name="musculos[]" value="<?= $tm['idmusculo'] ?>" id="musc_<?= $tm['idmusculo'] ?>" <?= $checked ? 'checked' : '' ?>>
                                            <label class="form-check-label d-flex align-items-center gap-2 w-100 cursor-pointer small" for="musc_<?= $tm['idmusculo'] ?>">
                                                <img src="<?= base_url('repositorio/images/muscles/' . esc($tm['imagen'])) ?>" 
                                                     onerror="this.onerror=null; this.src='<?= base_url('uploads/muscles/' . esc($tm['imagen'])) ?>';"
                                                     alt="<?= esc($tm['nombre']) ?>" 
                                                     style="width: 24px; height: 24px; object-fit: contain;">
                                                <span class="text-truncate fw-semibold"><?= esc($tm['nombre']) ?></span>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Selección de Equipamiento / Máquinas Requeridas -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold d-block">
                            <i class="bi bi-gear-wide-connected text-primary me-1"></i>Equipamiento / Máquinas Utilizadas
                        </label>
                        <small class="text-muted d-block mb-2">Marque las máquinas, aparatos o implementos empleados en este ejercicio:</small>
                        <div class="p-3 bg-light rounded border" style="max-height: 260px; overflow-y: auto;">
                            <div class="row g-2">
                                <?php foreach ($todosLosEquipos as $te): ?>
                                    <?php $idEq = $te['idequipo'] ?? $te['id_equipo']; ?>
                                    <?php $checkedEq = in_array($idEq, (array)old('equipos', $equiposAsignados)); ?>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="form-check p-2 bg-white rounded border d-flex align-items-center gap-2">
                                            <input class="form-check-input ms-0 me-2" type="checkbox" name="equipos[]" value="<?= $idEq ?>" id="eq_<?= $idEq ?>" <?= $checkedEq ? 'checked' : '' ?>>
                                            <label class="form-check-label d-flex align-items-center gap-2 w-100 cursor-pointer small" for="eq_<?= $idEq ?>">
                                                <?php if (!empty($te['imagen'])): ?>
                                                    <img src="<?= base_url('repositorio/images/equipment/' . esc($te['imagen'])) ?>" 
                                                         onerror="this.onerror=null; this.src='<?= base_url('equipo/imagen/' . esc($te['imagen'])) ?>';"
                                                         alt="<?= esc($te['nombre']) ?>" 
                                                         style="width: 24px; height: 24px; object-fit: contain;">
                                                <?php endif; ?>
                                                <div class="text-truncate">
                                                    <span class="badge bg-secondary-subtle text-secondary border font-monospace me-1"><?= esc($te['codigo']) ?></span>
                                                    <span class="fw-semibold"><?= esc($te['nombre']) ?></span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Descripción y Ejecución Técnica (A lo último) -->
                    <div class="mb-4">
                        <label for="descripcion" class="form-label fw-semibold">Descripción y Ejecución Técnica</label>
                        <textarea name="descripcion" id="descripcion" rows="4" class="form-control"><?= old('descripcion', $ejercicio['descripcion']) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="<?= base_url('ejercicio/actual/' . $ejercicio['idejercicio']) ?>" class="btn btn-light border px-4">Cancelar</a>
                        <button type="submit" class="btn btn-danger text-white px-4 fw-bold">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Ejercicio
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
