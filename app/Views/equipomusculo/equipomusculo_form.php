<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-custom bg-white">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-plus-circle text-success me-2"></i>Asignar Músculo a Equipo
                    </h5>
                    <a href="<?= base_url('equipomusculo/listar') ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Volver al Listado
                    </a>
                </div>
            </div>
            <div class="card-body p-4">

                <form method="post" action="<?= base_url('equipomusculo/save') ?>">
                    <?= csrf_field() ?>

                    <div class="mb-4">
                        <label for="idequipo" class="form-label fw-semibold">Equipo o Máquina <span class="text-danger">*</span></label>
                        <select name="idequipo" id="idequipo" class="form-select" required>
                            <option value="">-- Seleccionar Equipo --</option>
                            <?php foreach ($equipos as $eq): ?>
                                <option value="<?= $eq['idequipo'] ?>" <?= (old('idequipo', $selectedEquipo) == $eq['idequipo']) ? 'selected' : '' ?>>
                                    <?= esc($eq['codigo']) ?> - <?= esc($eq['nombre']) ?> <?= !empty($eq['modelo']) ? '(' . esc($eq['modelo']) . ')' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Aparato, máquina o implemento de gimnasio.</div>
                    </div>

                    <div class="mb-4">
                        <label for="idmusculo" class="form-label fw-semibold">Músculo Ejercitado <span class="text-danger">*</span></label>
                        <select name="idmusculo" id="idmusculo" class="form-select" required>
                            <option value="">-- Seleccionar Músculo --</option>
                            <?php foreach ($musculos as $m): ?>
                                <option value="<?= $m['idmusculo'] ?>" <?= (old('idmusculo') == $m['idmusculo']) ? 'selected' : '' ?>>
                                    <?= esc($m['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Grupo o músculo que se trabaja directamente con este equipo.</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="<?= base_url('equipomusculo') ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Guardar Relación
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
