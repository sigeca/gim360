<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-custom bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-collection-play text-info me-2"></i>Vincular Rutina a Programa de Entrenamiento
                    </h5>
                    <a href="<?= base_url('rutinaprograma/listar') ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>
            <div class="card-body p-4">

                <form method="post" action="<?= base_url('rutinaprograma/save') ?>">
                    <?= csrf_field() ?>

                    <!-- 1. Selección del Programa de Entrenamiento -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="idprogramaentrenamiento" class="form-label fw-semibold mb-0">
                                Programa de Entrenamiento <span class="text-danger">*</span>
                            </label>
                            <a href="<?= base_url('programaentrenamiento/add') ?>" target="_blank" class="small text-decoration-none text-success">
                                <i class="bi bi-plus-circle me-1"></i>Crear nuevo programa
                            </a>
                        </div>
                        <select name="idprogramaentrenamiento" id="idprogramaentrenamiento" class="form-select" required>
                            <option value="">-- Seleccione un Programa de Entrenamiento --</option>
                            <?php foreach ($programas as $p): ?>
                                <option value="<?= $p['idprogramaentrenamiento'] ?>" <?= old('idprogramaentrenamiento', $idProgPreselected ?? '') == $p['idprogramaentrenamiento'] ? 'selected' : '' ?>>
                                    #<?= $p['idprogramaentrenamiento'] ?> - <?= esc($p['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">El programa al cual se le agregará la rutina.</div>
                    </div>

                    <!-- 2. Selección de la Rutina de Ejercicio -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="idrutinaejercicio" class="form-label fw-semibold mb-0">
                                Rutina de Ejercicio <span class="text-danger">*</span>
                            </label>
                            <a href="<?= base_url('rutinaejecicio/add') ?>" target="_blank" class="small text-decoration-none text-info">
                                <i class="bi bi-plus-circle me-1"></i>Crear nueva rutina
                            </a>
                        </div>
                        <select name="idrutinaejercicio" id="idrutinaejercicio" class="form-select" required>
                            <option value="">-- Seleccione una Rutina de Ejercicio --</option>
                            <?php foreach ($rutinas as $r): ?>
                                <option value="<?= $r['idrutinaejercicio'] ?>" <?= old('idrutinaejercicio', $idRutinaPreselected ?? '') == $r['idrutinaejercicio'] ? 'selected' : '' ?>>
                                    #<?= $r['idrutinaejercicio'] ?> - <?= esc($r['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Rutina que formará parte del programa de entrenamiento seleccionado.</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3 mt-4">
                        <a href="<?= base_url('rutinaprograma/elprimero') ?>" class="btn btn-outline-secondary px-4">Cancelar</a>
                        <button type="submit" class="btn btn-primary fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Guardar Vínculo
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
