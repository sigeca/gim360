<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-pencil-square text-warning me-2"></i>Editar Programa de Entrenamiento</h2>
                <p class="text-muted mb-0">Modificar relaciones de motivo, rutina o plan de ejercicio en <code>programaentrenamiento</code>.</p>
            </div>
            <a href="<?= base_url('programaentrenamiento/actual/' . $programa['idprogramaentrenamiento']) ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver a Registro
            </a>
        </div>

        <div class="card card-custom bg-white border-top border-4 border-warning">
            <div class="card-body p-4">
                <form action="<?= base_url('programaentrenamiento/update/' . $programa['idprogramaentrenamiento']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">ID Programa de Entrenamiento</label>
                        <input type="text" class="form-control bg-light" value="<?= $programa['idprogramaentrenamiento'] ?>" readonly>
                    </div>

                    <!-- Nombre del Programa -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">
                            <i class="bi bi-tag-fill text-success me-1"></i>Nombre del Programa <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej: Hipertrofia Principiante - Sentadilla" maxlength="100" value="<?= old('nombre', $programa['nombre'] ?? '') ?>" required autofocus>
                        <div class="form-text">Nombre descriptivo e identificativo del programa de entrenamiento.</div>
                    </div>

                    <!-- 1. Motivo de Entrenamiento -->
                    <div class="mb-3">
                        <label for="idmotivoentrenamiento" class="form-label fw-semibold">
                            <i class="bi bi-bullseye text-warning me-1"></i>Motivo de Entrenamiento <span class="text-danger">*</span>
                        </label>
                        <select name="idmotivoentrenamiento" id="idmotivoentrenamiento" class="form-select" required>
                            <option value="">-- Seleccione un Motivo --</option>
                            <?php foreach ($motivos as $m): ?>
                                <option value="<?= $m['idmotivoentrenamiento'] ?>" <?= old('idmotivoentrenamiento', $programa['idmotivoentrenamiento']) == $m['idmotivoentrenamiento'] ? 'selected' : '' ?>>
                                    <?= esc($m['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="alert alert-light border small text-muted d-flex align-items-center gap-2 mb-4">
                        <i class="bi bi-info-circle-fill text-info fs-5"></i>
                        <div>
                            <strong>Nota:</strong> Un programa de entrenamiento puede tener múltiples rutinas de ejercicio. Las rutinas se gestionan en el módulo <a href="<?= base_url('rutinaprograma') ?>" target="_blank" class="fw-semibold text-info">Rutinas en Programas</a>.
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('programaentrenamiento/actual/' . $programa['idprogramaentrenamiento']) ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Programa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
