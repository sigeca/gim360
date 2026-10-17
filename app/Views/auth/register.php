<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Registro al Sistema | GIM360') ?></title>
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
            padding: 2rem 1rem;
            margin: 0;
        }
        .auth-card {
            width: 100%;
            max-width: 650px;
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
        .section-badge {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0284c7;
            background-color: #e0f2fe;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 0.25rem rgba(2, 132, 199, 0.2);
        }
        .btn-gym {
            background-color: #0284c7;
            border-color: #0284c7;
            color: #ffffff;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
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
        <h5 class="fw-bold mt-2 mb-0 text-light">Registro Integral al Sistema</h5>
        <p class="text-muted small mb-0">Crea tu registro como persona y tus credenciales de usuario</p>
    </div>

    <div class="p-4 p-md-5">
        <!-- Alertas Flash -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show small py-2 mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger small py-2 mb-3" role="alert">
                <strong><i class="bi bi-exclamation-circle me-1"></i>Por favor corrija los siguientes errores:</strong>
                <ul class="mb-0 ps-3 mt-1">
                    <?php foreach (session()->getFlashdata('errors') as $err): ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('registro') ?>" method="post">
            <?= csrf_field() ?>

            <!-- BLOQUE 1: DATOS PERSONALES -->
            <div class="section-badge">
                <i class="bi bi-person-vcard-fill me-1"></i> 1. Información Personal (Tabla Persona)
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label for="cedula" class="form-label fw-semibold text-secondary small">Cédula de Identidad <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-card-heading"></i></span>
                        <input type="text" name="cedula" id="cedula" value="<?= old('cedula') ?>" class="form-control" placeholder="0801234567" maxlength="20" required autofocus>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="nombres" class="form-label fw-semibold text-secondary small">Nombres <span class="text-danger">*</span></label>
                    <input type="text" name="nombres" id="nombres" value="<?= old('nombres') ?>" class="form-control" placeholder="Carlos Alberto" maxlength="100" required>
                </div>
                <div class="col-md-4">
                    <label for="apellidos" class="form-label fw-semibold text-secondary small">Apellidos <span class="text-danger">*</span></label>
                    <input type="text" name="apellidos" id="apellidos" value="<?= old('apellidos') ?>" class="form-control" placeholder="Mendoza Reyes" maxlength="100" required>
                </div>

                <div class="col-md-6">
                    <label for="fechanacimiento" class="form-label fw-semibold text-secondary small">Fecha de Nacimiento</label>
                    <input type="date" name="fechanacimiento" id="fechanacimiento" value="<?= old('fechanacimiento') ?>" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="idsexo" class="form-label fw-semibold text-secondary small">Sexo</label>
                    <select name="idsexo" id="idsexo" class="form-select">
                        <option value="">-- Seleccionar Sexo --</option>
                        <?php if (!empty($sexos)): ?>
                            <?php foreach ($sexos as $s): ?>
                                <option value="<?= $s['idsexo'] ?>" <?= old('idsexo') == $s['idsexo'] ? 'selected' : '' ?>>
                                    <?= esc($s['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <!-- BLOQUE 2: CREDENCIALES DE ACCESO -->
            <div class="section-badge bg-primary-subtle text-primary">
                <i class="bi bi-shield-lock-fill me-1"></i> 2. Credenciales de Acceso (Tabla Usuario)
            </div>

            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label for="nombreusuario" class="form-label fw-semibold text-secondary small">Nombre de Usuario (<code>nombreusuario</code>) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-at"></i></span>
                        <input type="text" name="nombreusuario" id="nombreusuario" value="<?= old('nombreusuario') ?>" class="form-control font-monospace" placeholder="ej. cmendoza o carlos123" maxlength="50" required autocomplete="username">
                    </div>
                    <div class="form-text">Mínimo 3 caracteres. Será tu identificador único de inicio de sesión.</div>
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label fw-semibold text-secondary small">Contraseña <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-key-fill"></i></span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" maxlength="200" required autocomplete="new-password">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password', this)" title="Ver contraseña">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="form-text">Mínimo 4 caracteres.</div>
                </div>

                <div class="col-md-6">
                    <label for="password_confirm" class="form-label fw-semibold text-secondary small">Confirmar Contraseña <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-check-circle-fill"></i></span>
                        <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="••••••••" maxlength="200" required autocomplete="new-password">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password_confirm', this)" title="Ver contraseña">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-gym shadow-sm">
                    <i class="bi bi-check-circle-fill me-1"></i> Registrarse e Ingresar al Sistema
                </button>
            </div>
        </form>

        <div class="text-center pt-2 border-top">
            <p class="text-muted small mb-1">¿Ya tienes una cuenta registrada?</p>
            <a href="<?= base_url('login') ?>" class="btn btn-outline-secondary btn-sm fw-semibold">
                <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión con mi Cuenta
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
