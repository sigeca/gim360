<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom bg-white border-top border-4 border-danger shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-plus-circle text-danger me-2"></i>Asignar Músculo a Ejercicio
                </h5>
                <a href="<?= base_url('musculoejercicio/listar') ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Volver al Catálogo
                </a>
            </div>
            <div class="card-body p-4">

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $err): ?>
                                <li><?= esc($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('musculoejercicio/save') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="idejercicio" class="form-label fw-semibold">Ejercicio <span class="text-danger">*</span></label>
                        <select name="idejercicio" id="idejercicio" class="form-select select2" required>
                            <option value="">-- Seleccionar Ejercicio --</option>
                            <?php foreach ($ejercicios as $ej): ?>
                                <option value="<?= $ej['idejercicio'] ?>" <?= (old('idejercicio', $selectedEjercicio) == $ej['idejercicio']) ? 'selected' : '' ?>>
                                    #<?= $ej['idejercicio'] ?> - <?= esc($ej['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="idmusculo" class="form-label fw-semibold">Músculo Afectado <span class="text-danger">*</span></label>
                        <select name="idmusculo" id="idmusculo" class="form-select select2" required>
                            <option value="">-- Seleccionar Músculo --</option>
                            <?php foreach ($musculos as $m): ?>
                                <option value="<?= $m['idmusculo'] ?>" <?= (old('idmusculo') == $m['idmusculo']) ? 'selected' : '' ?>>
                                    #<?= $m['idmusculo'] ?> - <?= esc($m['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('musculoejercicio') ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-danger text-white fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Guardar Relación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
