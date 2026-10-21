<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-custom bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-pencil-square text-warning me-2"></i>Editar Asignación Equipo - Músculo #<?= $rel['idequipomusculo'] ?>
                    </h5>
                    <a href="<?= base_url('equipomusculo/actual/' . $rel['idequipomusculo']) ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Volver
                    </a>
                </div>
            </div>
            <div class="card-body p-4">

                <form method="post" action="<?= base_url('equipomusculo/update/' . $rel['idequipomusculo']) ?>">
                    <?= csrf_field() ?>

                    <div class="mb-4">
                        <label for="idequipo" class="form-label fw-semibold">Equipo o Máquina <span class="text-danger">*</span></label>
                        <select name="idequipo" id="idequipo" class="form-select" required>
                            <?php foreach ($equipos as $eq): ?>
                                <option value="<?= $eq['idequipo'] ?>" <?= (old('idequipo', $rel['idequipo']) == $eq['idequipo']) ? 'selected' : '' ?>>
                                    <?= esc($eq['codigo']) ?> - <?= esc($eq['nombre']) ?> <?= !empty($eq['modelo']) ? '(' . esc($eq['modelo']) . ')' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="idmusculo" class="form-label fw-semibold">Músculo Ejercitado <span class="text-danger">*</span></label>
                        <select name="idmusculo" id="idmusculo" class="form-select" required>
                            <?php foreach ($musculos as $m): ?>
                                <option value="<?= $m['idmusculo'] ?>" <?= (old('idmusculo', $rel['idmusculo']) == $m['idmusculo']) ? 'selected' : '' ?>>
                                    <?= esc($m['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="<?= base_url('equipomusculo/actual/' . $rel['idequipomusculo']) ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Relación
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
