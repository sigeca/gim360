<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($usuario)): ?>
            <?= view('layout/empty_record', ['module' => 'usuario']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'usuario',
                'currentId' => $usuario['idusuario']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-primary">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-person-lock text-primary me-2"></i>Ficha de Cuenta de Usuario
                    </h5>
                    <span class="badge bg-primary fs-6">ID Usuario #<?= $usuario['idusuario'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th class="table-light w-25 text-muted">ID Usuario</th>
                                    <td class="fw-bold text-muted"><?= $usuario['idusuario'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Nombre de Usuario</th>
                                    <td class="fs-5 fw-bold font-monospace text-primary">
                                        <i class="bi bi-at text-primary me-1"></i><?= esc($usuario['nombreusuario']) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Persona Asignada</th>
                                    <td>
                                        <a href="<?= base_url('persona/actual/' . $usuario['idpersona']) ?>" class="fs-6 fw-semibold text-dark text-decoration-none">
                                            <?= esc($usuario['persona_apellidos'] . ' ' . $usuario['persona_nombres']) ?> <i class="bi bi-box-arrow-up-right fs-6 text-primary"></i>
                                        </a>
                                        <span class="badge bg-light text-dark border ms-2 font-monospace">C.I: <?= esc($usuario['cedula']) ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Contraseña (Hash)</th>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-light text-success border font-monospace">
                                                <i class="bi bi-shield-lock-fill me-1"></i>Protegida con Hash
                                            </span>
                                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#hashCollapse" aria-expanded="false" aria-controls="hashCollapse">
                                                <i class="bi bi-eye me-1"></i>Ver Hash
                                            </button>
                                        </div>
                                        <div class="collapse mt-2" id="hashCollapse">
                                            <div class="card card-body bg-light small font-monospace text-break p-2 border">
                                                <?= esc($usuario['password']) ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
