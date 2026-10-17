<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Iniciar Sesión | GIM360') ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('gim360.png') ?>">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0369a1 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            padding: 1.5rem;
            margin: 0;
        }
        .auth-card {
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .auth-header {
            background-color: #0b1120;
            padding: 2rem 1.5rem 1.5rem 1.5rem;
            text-align: center;
            color: #ffffff;
            border-bottom: 3px solid #0284c7;
        }
        .form-control:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 0.25rem rgba(2, 132, 199, 0.2);
        }
        .btn-gym {
            background-color: #0284c7;
            border-color: #0284c7;
            color: #ffffff;
            font-weight: 600;
            padding: 0.65rem 1.25rem;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .btn-gym:hover {
            background-color: #0369a1;
            border-color: #0369a1;
            color: #ffffff;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="auth-header">
        <a href="<?= base_url() ?>" class="d-inline-flex align-items-center gap-2 text-decoration-none text-white mb-2">
            <img src="<?= base_url('gim360.png') ?>" alt="Logo GIM360" class="rounded-3 shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
            <div class="text-start lh-1">
                <span class="fs-3 fw-bold tracking-tight">GIM<span class="text-info">360</span></span>
                <span class="d-block text-secondary small" style="font-size: 0.70rem;">GESTIÓN INTEGRAL DE GIMNASIOS</span>
            </div>
        </a>
        <h5 class="fw-bold mt-2 mb-0 text-light">Iniciar Sesión</h5>
        <p class="text-muted small mb-0">Accede con tu usuario o cédula registrada</p>
    </div>

    <div class="p-4">
        <!-- Alertas Flash -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show small py-2 mb-3" role="alert">
                <i class="bi bi-check-circle-fill me-1"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show small py-2 mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('info')): ?>
            <div class="alert alert-info alert-dismissible fade show small py-2 mb-3" role="alert">
                <i class="bi bi-info-circle-fill me-1"></i> <?= session()->getFlashdata('info') ?>
                <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger small py-2 mb-3" role="alert">
                <ul class="mb-0 ps-3">
                    <?php foreach (session()->getFlashdata('errors') as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('login') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="nombreusuario" class="form-label fw-semibold text-secondary small">Nombre de Usuario o Cédula</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-person-fill"></i></span>
                    <input type="text" name="nombreusuario" id="nombreusuario" value="<?= old('nombreusuario') ?>" class="form-control border-start-0" placeholder="ej. carlos123 o 0801234567" required autofocus autocomplete="username">
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label fw-semibold text-secondary small">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password" id="password" class="form-control border-start-0 border-end-0" placeholder="••••••••" required autocomplete="current-password">
                    <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePasswordVisibility('password', this)" title="Ver contraseña">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-gym shadow-sm">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Ingresar al Sistema
                </button>
            </div>
        </form>

        <div class="text-center pt-2 border-top">
            <p class="text-muted small mb-1">¿Aún no tienes una cuenta?</p>
            <a href="<?= base_url('registro') ?>" class="btn btn-outline-primary btn-sm w-100 fw-semibold">
                <i class="bi bi-person-plus-fill me-1"></i> Registrarse como Persona y Usuario
            </a>
            <div class="mt-3">
                <a href="<?= base_url('/') ?>" class="text-muted small text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i> Volver al Panel Principal
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5.3 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>
