<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-person-badge text-success me-2"></i>Asignar Nuevo Cliente</h2>
                <p class="text-muted mb-0">Seleccione una persona existente para registrarla en la tabla <code>cliente</code>.</p>
            </div>
            <a href="<?= base_url('cliente') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>

        <div class="card card-custom bg-white">
            <div class="card-body p-4">
                <?php if (empty($personasDisponibles)): ?>
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle me-1"></i> Todas las personas registradas en el sistema ya son clientes, o no hay personas creadas aún.
                        <div class="mt-3">
                            <a href="<?= base_url('persona/new') ?>" class="btn btn-primary btn-sm">
                                <i class="bi bi-person-plus me-1"></i> Crear Nueva Persona
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <form action="<?= base_url('cliente/create') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="idpersona" class="form-label fw-semibold">Seleccionar Persona <span class="text-danger">*</span></label>
                            <select name="idpersona" id="idpersona" class="form-select" required>
                                <option value="">-- Seleccionar Persona --</option>
                                <?php foreach ($personasDisponibles as $p): ?>
                                    <option value="<?= $p['idpersona'] ?>" <?= old('idpersona') == $p['idpersona'] ? 'selected' : '' ?>>
                                        <?= esc($p['cedula']) ?> — <?= esc($p['nombres']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text">Solo se listan personas que aún no son clientes.</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="<?= base_url('cliente') ?>" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success fw-bold px-4">
                                <i class="bi bi-check-circle me-1"></i> Guardar Cliente
                            </button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
