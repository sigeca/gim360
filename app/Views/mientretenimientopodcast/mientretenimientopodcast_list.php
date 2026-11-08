<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card card-custom bg-white border-0 shadow-sm mb-4">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-1 text-dark"><i class="bi bi-mic-fill text-warning me-2"></i>Relaciones Mi Entretenimiento - Podcasts</h4>
                    <p class="text-muted small mb-0">Listado de podcasts vinculados a listas personales.</p>
                </div>
                <a href="<?= base_url('mientretenimientopodcast/add') ?>" class="btn btn-warning text-dark fw-bold"><i class="bi bi-plus-lg me-1"></i>+ Vincular Podcast</a>
            </div>
        </div>
        <div class="card card-custom bg-white border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">ID</th>
                            <th>Mi Entretenimiento</th>
                            <th>Persona</th>
                            <th>Podcast</th>
                            <th>Enlace</th>
                            <th class="text-end pe-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($relaciones)): ?>
                            <tr><td colspan="6" class="text-center py-4 text-muted">No hay registros</td></tr>
                        <?php else: ?>
                            <?php foreach ($relaciones as $r): ?>
                                <tr>
                                    <td class="ps-3 fw-bold text-muted">#<?= $r['idmientretenimientopodcast'] ?></td>
                                    <td><a href="<?= base_url('mientretenimiento/actual/' . $r['idmientretenimiento']) ?>" class="fw-bold"><?= esc($r['mientretenimiento_nombre']) ?></a></td>
                                    <td><?= esc($r['persona_apellidos'] . ' ' . $r['persona_nombres']) ?></td>
                                    <td><a href="<?= base_url('podcast/actual/' . $r['idpodcast']) ?>"><?= esc($r['podcast_nombre']) ?></a></td>
                                    <td><a href="<?= esc($r['podcast_enlace']) ?>" target="_blank" class="btn btn-sm btn-outline-warning text-dark"><i class="bi bi-headphones me-1"></i>Oír</a></td>
                                    <td class="text-end pe-3">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('mientretenimientopodcast/actual/' . $r['idmientretenimientopodcast']) ?>" class="btn btn-outline-primary"><i class="bi bi-eye"></i></a>
                                            <a href="<?= base_url('mientretenimientopodcast/delete/' . $r['idmientretenimientopodcast']) ?>" class="btn btn-outline-danger" onclick="return confirm('¿Desvincular?');"><i class="bi bi-trash"></i></a>
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
<?= $this->endSection() ?>
