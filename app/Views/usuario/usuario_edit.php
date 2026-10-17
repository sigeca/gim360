<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-pencil-square text-warning me-2"></i>Editar Usuario</h2>
                <p class="text-muted mb-0">Modificar datos en la tabla <code>usuario</code>.</p>
            </div>
            <a href="<?= base_url('usuario/actual/' . $usuario['idusuario']) ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver a Registro
            </a>
        </div>

        <div class="card card-custom bg-white border-top border-4 border-warning">
            <div class="card-body p-4">
                <form action="<?= base_url('usuario/update/' . $usuario['idusuario']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold">ID Usuario</label>
                        <input type="text" class="form-control bg-light" value="<?= $usuario['idusuario'] ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="idpersona" class="form-label fw-semibold">Persona Asignada <span class="text-danger">*</span></label>
                        <select name="idpersona" id="idpersona" class="form-select" required>
                            <?php foreach ($personas as $p): ?>
                                <option value="<?= $p['idpersona'] ?>" <?= old('idpersona', $usuario['idpersona']) == $p['idpersona'] ? 'selected' : '' ?>>
                                    <?= esc($p['apellidos'] . ' ' . $p['nombres']) ?> (C.I: <?= esc($p['cedula']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nombreusuario" class="form-label fw-semibold">Nombre de Usuario (<code>nombreusuario</code>) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-at"></i></span>
                            <input type="text" name="nombreusuario" id="nombreusuario" value="<?= old('nombreusuario', $usuario['nombreusuario']) ?>" class="form-control" maxlength="50" required autofocus>
                        </div>
                        <div class="form-text">Máximo 50 caracteres. Debe ser único en el sistema.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Nueva Contraseña (<code>password</code>)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Dejar en blanco para mantener la contraseña actual" maxlength="200">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div class="form-text text-muted">
                            <i class="bi bi-info-circle me-1"></i>Si no desea modificar la contraseña actual, deje este campo vacío.
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('usuario/actual/' . $usuario['idusuario']) ?>" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Actualizar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>

<?= $this->endSection() ?>
