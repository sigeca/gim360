<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-custom bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-pencil-square text-warning me-2"></i>Editar Asignación de Programa #<?= $programaCliente['idprogramacliente'] ?>
                    </h5>
                    <a href="<?= base_url('programacliente/actual/' . $programaCliente['idprogramacliente']) ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>
            <div class="card-body p-4">

                <form method="post" action="<?= base_url('programacliente/update/' . $programaCliente['idprogramacliente']) ?>">
                    <?= csrf_field() ?>

                    <!-- 1. Selección del Cliente -->
                    <div class="mb-3">
                        <label for="idcliente" class="form-label fw-semibold">
                            Cliente <span class="text-danger">*</span>
                        </label>
                        <select name="idcliente" id="idcliente" class="form-select" required>
                            <option value="">-- Seleccione un Cliente --</option>
                            <?php foreach ($clientes as $c): ?>
                                <option value="<?= $c['idcliente'] ?>" <?= old('idcliente', $programaCliente['idcliente']) == $c['idcliente'] ? 'selected' : '' ?>>
                                    #<?= $c['idcliente'] ?> - <?= esc($c['persona_nombres']) ?> (C.I: <?= esc($c['cedula']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- 2. Selección del Programa de Entrenamiento -->
                    <div class="mb-3">
                        <label for="idprogramaentrenamiento" class="form-label fw-semibold">
                            Programa de Entrenamiento <span class="text-danger">*</span>
                        </label>
                        <select name="idprogramaentrenamiento" id="idprogramaentrenamiento" class="form-select" required>
                            <option value="">-- Seleccione un Programa de Entrenamiento --</option>
                            <?php foreach ($programas as $p): ?>
                                <option value="<?= $p['idprogramaentrenamiento'] ?>" <?= old('idprogramaentrenamiento', $programaCliente['idprogramaentrenamiento']) == $p['idprogramaentrenamiento'] ? 'selected' : '' ?>>
                                    #<?= $p['idprogramaentrenamiento'] ?> - <?= esc($p['nombre'] ?? 'Sin nombre') ?> &bull; <?= esc($p['motivo_nombre']) ?> (<?= $p['total_rutinas'] ?? 0 ?> rutinas, <?= $p['total_planes'] ?? 0 ?> planes)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <!-- 3. Fecha de Inicio -->
                        <div class="col-md-6 mb-3">
                            <label for="fechainicio" class="form-label fw-semibold">
                                <i class="bi bi-calendar-event text-primary me-1"></i>Fecha de Inicio <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="fechainicio" id="fechainicio" class="form-control" value="<?= old('fechainicio', $programaCliente['fechainicio']) ?>" required>
                        </div>

                        <!-- 4. Estado del Programa -->
                        <div class="col-md-6 mb-3">
                            <label for="idestadoprogramacliente" class="form-label fw-semibold">
                                <i class="bi bi-flag text-info me-1"></i>Estado del Programa <span class="text-danger">*</span>
                            </label>
                            <select name="idestadoprogramacliente" id="idestadoprogramacliente" class="form-select" required>
                                <option value="">-- Seleccione Estado --</option>
                                <?php foreach ($estados as $est): ?>
                                    <option value="<?= $est['idestadoprogramacliente'] ?>" <?= old('idestadoprogramacliente', $programaCliente['idestadoprogramacliente']) == $est['idestadoprogramacliente'] ? 'selected' : '' ?>>
                                        <?= esc($est['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3 mt-3">
                        <a href="<?= base_url('programacliente/actual/' . $programaCliente['idprogramacliente']) ?>" class="btn btn-outline-secondary px-4">Cancelar</a>
                        <button type="submit" class="btn btn-warning fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Cambios
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
