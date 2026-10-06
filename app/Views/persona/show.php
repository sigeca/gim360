<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
    <div class="col-md-8">
        <div class="d-flex align-items-center gap-3">
            <div class="bg-primary text-white rounded-circle p-3 fs-2 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                <i class="bi bi-person-fill"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-0 text-dark"><?= esc($persona['nombres']) ?></h2>
                <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                    <span class="badge bg-secondary font-monospace"><i class="bi bi-card-text me-1"></i><?= esc($persona['cedula']) ?></span>
                    <?php if (!empty($persona['sexo_nombre'])): ?>
                        <span class="badge bg-info text-dark"><i class="bi bi-gender-ambiguous me-1"></i><?= esc($persona['sexo_nombre']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($persona['fechanacimiento'])): ?>
                        <span class="badge bg-light text-dark border"><i class="bi bi-cake2 me-1"></i><?= date('d/m/Y', strtotime($persona['fechanacimiento'])) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($persona['idcliente'])): ?>
                        <span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i>Cliente Gym (ID: <?= $persona['idcliente'] ?>)</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">No registrado como Cliente</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0 d-flex flex-wrap gap-2 justify-content-md-end align-items-center">
        <form method="post" action="<?= base_url('persona/toggleCliente/' . $persona['idpersona']) ?>" class="d-inline">
            <?= csrf_field() ?>
            <?php if (!empty($persona['idcliente'])): ?>
                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Desea desvincular a esta persona como cliente?')">
                    <i class="bi bi-person-dash me-1"></i> Retirar de Clientes
                </button>
            <?php else: ?>
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="bi bi-person-plus me-1"></i> Registrar como Cliente
                </button>
            <?php endif; ?>
        </form>

        <a href="<?= base_url('persona/edit/' . $persona['idpersona']) ?>" class="btn btn-warning btn-sm">
            <i class="bi bi-pencil-fill me-1"></i> Editar
        </a>
        <a href="<?= base_url('persona') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Columna Izquierda: Correos y Direcciones -->
    <div class="col-lg-6">
        <!-- 1. Correos (tabla correo) -->
        <div class="card card-custom bg-white mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-envelope-at text-info me-2"></i>Correos Electrónicos (<code>correo</code>)
                </h5>
                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#modalAddCorreo">
                    <i class="bi bi-plus-lg me-1"></i> Añadir Correo
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Correo</th>
                                <th>Fecha Obtención</th>
                                <th class="text-end pe-3">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($correos)): ?>
                                <tr>
                                    <td colspan="3" class="text-center py-3 text-muted">Sin correos registrados.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($correos as $c): ?>
                                    <tr>
                                        <td class="ps-3 font-monospace">
                                            <a href="mailto:<?= esc($c['correo']) ?>" class="text-decoration-none">
                                                <?= esc($c['correo']) ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?= !empty($c['fechaoptencion']) ? date('d/m/Y', strtotime($c['fechaoptencion'])) : '<span class="text-muted">-</span>' ?>
                                        </td>
                                        <td class="text-end pe-3">
                                            <form method="post" action="<?= base_url('correo/delete/' . $c['idcorreo']) ?>" onsubmit="return confirm('¿Eliminar este correo?')" class="d-inline">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="redirect_persona" value="<?= $persona['idpersona'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar correo">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 2. Direcciones (tabla direccion) -->
        <div class="card card-custom bg-white">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-pin-map text-warning me-2"></i>Direcciones Registradas (<code>direccion</code>)
                </h5>
                <button type="button" class="btn btn-sm btn-outline-warning text-dark" data-bs-toggle="modal" data-bs-target="#modalAddDireccion">
                    <i class="bi bi-plus-lg me-1"></i> Añadir Dirección
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Dirección</th>
                                <th class="text-end pe-3">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($direcciones)): ?>
                                <tr>
                                    <td colspan="2" class="text-center py-3 text-muted">Sin direcciones registradas.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($direcciones as $d): ?>
                                    <tr>
                                        <td class="ps-3"><?= esc($d['direccion']) ?></td>
                                        <td class="text-end pe-3">
                                            <form method="post" action="<?= base_url('direccion/delete/' . $d['iddireccion']) ?>" onsubmit="return confirm('¿Eliminar esta dirección?')" class="d-inline">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="redirect_persona" value="<?= $persona['idpersona'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar dirección">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Columna Derecha: Estado Civil y Género -->
    <div class="col-lg-6">
        <!-- 3. Estados Civiles (tabla estadocivilpersona) -->
        <div class="card card-custom bg-white mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-heart text-danger me-2"></i>Estados Civiles Asignados (<code>estadocivilpersona</code>)
                </h5>
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalAddECP">
                    <i class="bi bi-plus-lg me-1"></i> Asignar Estado Civil
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">ID Relación</th>
                                <th>Estado Civil</th>
                                <th class="text-end pe-3">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($estadosCiviles)): ?>
                                <tr>
                                    <td colspan="3" class="text-center py-3 text-muted">Sin registros de estado civil.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($estadosCiviles as $ec): ?>
                                    <tr>
                                        <td class="ps-3 text-muted fw-bold"><?= $ec['idestadocivilpersona'] ?></td>
                                        <td>
                                            <span class="badge bg-secondary"><?= esc($ec['estadocivil_nombre']) ?></span>
                                        </td>
                                        <td class="text-end pe-3">
                                            <form method="post" action="<?= base_url('estadocivilpersona/delete/' . $ec['idestadocivilpersona']) ?>" onsubmit="return confirm('¿Eliminar esta asignación?')" class="d-inline">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="redirect_persona" value="<?= $persona['idpersona'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar asignación">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 4. Géneros (tabla generopersona) -->
        <div class="card card-custom bg-white">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-person-lines-fill text-primary me-2"></i>Identidades de Género (<code>generopersona</code>)
                </h5>
                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalAddGP">
                    <i class="bi bi-plus-lg me-1"></i> Asignar Género
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">ID Relación</th>
                                <th>Género</th>
                                <th class="text-end pe-3">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($generos)): ?>
                                <tr>
                                    <td colspan="3" class="text-center py-3 text-muted">Sin registros de género.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($generos as $g): ?>
                                    <tr>
                                        <td class="ps-3 text-muted fw-bold"><?= $g['idgeneropersona'] ?></td>
                                        <td>
                                            <span class="badge bg-primary"><?= esc($g['genero_nombre']) ?></span>
                                        </td>
                                        <td class="text-end pe-3">
                                            <form method="post" action="<?= base_url('generopersona/delete/' . $g['idgeneropersona']) ?>" onsubmit="return confirm('¿Eliminar esta asignación?')" class="d-inline">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="redirect_persona" value="<?= $persona['idpersona'] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar asignación">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Añadir Correo -->
<div class="modal fade" id="modalAddCorreo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="<?= base_url('correo/create') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="idpersona" value="<?= $persona['idpersona'] ?>">
            <input type="hidden" name="redirect_persona" value="<?= $persona['idpersona'] ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-envelope-plus me-2"></i>Añadir Correo Electrónico</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Correo Electrónico <span class="text-danger">*</span></label>
                        <input type="email" name="correo" class="form-control" placeholder="nombre@correo.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Fecha de Obtención</label>
                        <input type="date" name="fechaoptencion" class="form-control" value="<?= date('Y-m-d') ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info text-white fw-bold">Guardar Correo</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Añadir Dirección -->
<div class="modal fade" id="modalAddDireccion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="<?= base_url('direccion/create') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="idpersona" value="<?= $persona['idpersona'] ?>">
            <input type="hidden" name="redirect_persona" value="<?= $persona['idpersona'] ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-geo-alt-fill me-2"></i>Añadir Dirección</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Dirección Completa <span class="text-danger">*</span></label>
                        <textarea name="direccion" class="form-control" rows="3" placeholder="Calle principal, secundaria, número de casa, sector..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning fw-bold">Guardar Dirección</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Añadir Estado Civil -->
<div class="modal fade" id="modalAddECP" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="<?= base_url('estadocivilpersona/create') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="idpersona" value="<?= $persona['idpersona'] ?>">
            <input type="hidden" name="redirect_persona" value="<?= $persona['idpersona'] ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-heart me-2"></i>Asignar Estado Civil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Seleccione Estado Civil <span class="text-danger">*</span></label>
                        <select name="idestadocivil" class="form-select" required>
                            <option value="">-- Seleccionar --</option>
                            <?php foreach ($catalogoEC as $ec): ?>
                                <option value="<?= $ec['idestadocivil'] ?>"><?= esc($ec['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger fw-bold">Asignar Estado</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Añadir Género -->
<div class="modal fade" id="modalAddGP" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="<?= base_url('generopersona/create') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="idpersona" value="<?= $persona['idpersona'] ?>">
            <input type="hidden" name="redirect_persona" value="<?= $persona['idpersona'] ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-person-lines-fill me-2"></i>Asignar Identidad de Género</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Seleccione Género <span class="text-danger">*</span></label>
                        <select name="idgenero" class="form-select" required>
                            <option value="">-- Seleccionar --</option>
                            <?php foreach ($catalogoGen as $g): ?>
                                <option value="<?= $g['idgenero'] ?>"><?= esc($g['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-bold">Asignar Género</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
