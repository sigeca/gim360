<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-pencil-square text-warning me-2"></i>Editar Asignación de Cliente</h2>
                <p class="text-muted mb-0">Modificar la persona vinculada en la tabla <code>cliente</code>.</p>
            </div>
            <a href="<?= base_url('cliente/actual/' . $cliente['idcliente']) ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver a Registro
            </a>
        </div>

        <div class="card card-custom bg-white border-top border-4 border-warning">
            <div class="card-body p-4">
                <form action="<?= base_url('cliente/update/' . $cliente['idcliente']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">ID Cliente</label>
                        <input type="text" class="form-control bg-light" value="<?= $cliente['idcliente'] ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="idpersona" class="form-label fw-semibold">Persona Asignada <span class="text-danger">*</span></label>
                        <select name="idpersona" id="idpersona" class="form-select" required autofocus>
                            <?php foreach ($personas as $p): ?>
                                <option value="<?= $p['idpersona'] ?>" <?= old('idpersona', $cliente['idpersona']) == $p['idpersona'] ? 'selected' : '' ?>>
                                    <?= esc($p['cedula']) ?> — <?= esc($p['nombres']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('cliente/actual/' . $cliente['idcliente']) ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
