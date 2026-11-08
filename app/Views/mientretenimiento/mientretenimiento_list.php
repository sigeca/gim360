<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-11">

        <div class="card card-custom bg-white border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <h4 class="fw-bold mb-1 text-dark d-flex align-items-center">
                            <i class="bi bi-person-heart text-info me-2 fs-3"></i>Catálogo de Mi Entretenimiento
                        </h4>
                        <p class="text-muted small mb-0">Listas multimedia y juegos tradicionales personalizados por cada persona/cliente.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="<?= base_url('mientretenimiento/add') ?>" class="btn btn-info text-dark fw-bold">
                            <i class="bi bi-plus-lg me-1"></i>+ Personalizar Nuevo
                        </a>
                        <a href="<?= base_url('entretenimiento') ?>" class="btn btn-outline-primary">
                            <i class="bi bi-controller me-1"></i>Catálogo Base
                        </a>
                    </div>
                </div>

                <hr class="my-3">

                <!-- Filtros de búsqueda -->
                <form action="<?= base_url('mientretenimiento/listar') ?>" method="get" class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="q" class="form-control" placeholder="Buscar por nombre, persona, cédula..." value="<?= esc($search ?? '') ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="idpersona" class="form-select">
                            <option value="">-- Filtrar por Persona --</option>
                            <?php foreach ($personas as $p): ?>
                                <option value="<?= $p['idpersona'] ?>" <?= (!empty($idpersona) && (int)$idpersona === (int)$p['idpersona']) ? 'selected' : '' ?>>
                                    <?= esc($p['apellidos'] . ' ' . $p['nombres']) ?> (C.I. <?= esc($p['cedula']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel-fill me-1"></i>Filtrar</button>
                        <?php if (!empty($search) || !empty($idpersona)): ?>
                            <a href="<?= base_url('mientretenimiento/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-circle"></i></a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de Listado -->
        <div class="card card-custom bg-white border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Persona Propietaria</th>
                                <th>Nombre Lista</th>
                                <th>Plantilla Base</th>
                                <th class="text-center">Músicas</th>
                                <th class="text-center">Videos</th>
                                <th class="text-center">Juegos</th>
                                <th class="text-center">Podcasts</th>
                                <th class="text-end pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($misEntretenimientos)): ?>
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox display-6 d-block mb-2 text-secondary"></i>
                                        No se encontraron registros de Mi Entretenimiento.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($misEntretenimientos as $item): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-muted">#<?= $item['idmientretenimiento'] ?></td>
                                        <td>
                                            <a href="<?= base_url('persona/actual/' . $item['idpersona']) ?>" class="fw-bold text-dark text-decoration-none">
                                                <i class="bi bi-person-fill text-info me-1"></i><?= esc($item['persona_apellidos'] . ' ' . $item['persona_nombres']) ?>
                                            </a>
                                            <div class="text-muted small">C.I. <?= esc($item['persona_cedula']) ?></div>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('mientretenimiento/actual/' . $item['idmientretenimiento']) ?>" class="fw-bold text-primary text-decoration-none">
                                                <?= esc($item['nombre']) ?>
                                            </a>
                                            <?php if (!empty($item['descripcion'])): ?>
                                                <div class="text-muted small text-truncate" style="max-width: 250px;">
                                                    <?= esc($item['descripcion']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($item['identretenimiento'])): ?>
                                                <span class="badge bg-light text-dark border">
                                                    <i class="bi bi-controller me-1"></i><?= esc($item['base_entretenimiento_nombre'] ?: ('#' . $item['identretenimiento'])) ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-muted small fst-italic">Desde cero</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center"><span class="badge bg-danger-subtle text-danger border"><?= $item['total_musicas'] ?></span></td>
                                        <td class="text-center"><span class="badge bg-primary-subtle text-primary border"><?= $item['total_videos'] ?></span></td>
                                        <td class="text-center"><span class="badge bg-success-subtle text-success border"><?= $item['total_juegos'] ?></span></td>
                                        <td class="text-center"><span class="badge bg-warning-subtle text-dark border"><?= $item['total_podcasts'] ?></span></td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group btn-group-sm">
                                                <a href="<?= base_url('mientretenimiento/actual/' . $item['idmientretenimiento']) ?>" class="btn btn-outline-primary" title="Ver registro"><i class="bi bi-eye"></i></a>
                                                <a href="<?= base_url('mientretenimiento/edit/' . $item['idmientretenimiento']) ?>" class="btn btn-outline-secondary" title="Editar"><i class="bi bi-pencil"></i></a>
                                                <a href="<?= base_url('mientretenimiento/delete/' . $item['idmientretenimiento']) ?>" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar esta lista de Mi Entretenimiento?');"><i class="bi bi-trash"></i></a>
                                            </div>
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

<?= $this->endSection() ?>
