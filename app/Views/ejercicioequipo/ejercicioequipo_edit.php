<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom bg-white border-top border-4 border-primary shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Editar Asignación Ejercicio - Equipo
                </h5>
                <a href="<?= base_url('ejercicioequipo/actual/' . $rel['idejercicioequipo']) ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Volver al Detalle
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

                <form action="<?= base_url('ejercicioequipo/update/' . $rel['idejercicioequipo']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="idejercicio" class="form-label fw-semibold">Ejercicio <span class="text-danger">*</span></label>
                        <select name="idejercicio" id="idejercicio" class="form-select" required>
                            <?php foreach ($ejercicios as $ej): ?>
                                <option value="<?= $ej['idejercicio'] ?>" <?= (old('idejercicio', $rel['idejercicio']) == $ej['idejercicio']) ? 'selected' : '' ?>>
                                    #<?= $ej['idejercicio'] ?> - <?= esc($ej['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="idequipo" class="form-label fw-semibold">Equipo / Máquina Requerida <span class="text-danger">*</span></label>
                        <select name="idequipo" id="idequipo" class="form-select" required>
                            <?php foreach ($equipos as $eq): ?>
                                <option value="<?= $eq['id_equipo'] ?>" <?= (old('idequipo', $rel['idequipo']) == $eq['id_equipo']) ? 'selected' : '' ?>>
                                    <?= esc($eq['codigo']) ?> - <?= esc($eq['nombre']) ?> <?= !empty($eq['modelo']) ? '(' . esc($eq['modelo']) . ')' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('ejercicioequipo/actual/' . $rel['idejercicioequipo']) ?>" class="btn btn-outline-secondary">Cancelar</a>
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
