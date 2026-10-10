<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($musculo)): ?>
            <?= view('layout/empty_record', ['module' => 'musculo']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'musculo',
                'currentId' => $musculo['idmusculo']
            ]) ?>

            <!-- Ficha Principal del Músculo -->
            <div class="card card-custom bg-white border-top border-4 border-danger shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-person-arms-up text-danger me-2 fs-4"></i>Ficha de Músculo: <?= esc($musculo['nombre']) ?>
                    </h5>
                    <span class="badge bg-danger text-white fs-6">ID #<?= $musculo['idmusculo'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        
                        <!-- Panel de Presentación de la Imagen del Músculo -->
                        <div class="col-md-6 text-center">
                            <div class="p-3 bg-light rounded-4 border shadow-sm position-relative">
                                <?php if (!empty($musculo['imagen'])): ?>
                                    <img src="<?= base_url('repositorio/images/muscles/' . esc($musculo['imagen'])) ?>" 
                                         onerror="this.onerror=null; this.src='<?= base_url('uploads/muscles/' . esc($musculo['imagen'])) ?>';"
                                         alt="<?= esc($musculo['nombre']) ?>" 
                                         class="img-fluid rounded-3" 
                                         style="max-height: 320px; object-fit: contain; filter: drop-shadow(0 6px 12px rgba(0,0,0,0.12));">
                                    <div class="mt-2 text-muted small fst-italic">
                                        <i class="bi bi-file-earmark-image me-1"></i><?= esc($musculo['imagen']) ?>
                                    </div>
                                <?php else: ?>
                                    <div class="py-5 text-muted">
                                        <i class="bi bi-image fs-1 d-block mb-2"></i>
                                        <span>Sin imagen registrada</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Detalles e Información -->
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-40 text-muted">ID Músculo</th>
                                            <td class="fw-bold text-secondary">#<?= $musculo['idmusculo'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Nombre del Músculo</th>
                                            <td>
                                                <span class="fs-5 fw-bold text-dark">
                                                    <?= esc($musculo['nombre']) ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Archivo de Imagen</th>
                                            <td>
                                                <span class="badge bg-secondary-subtle text-secondary border px-2 py-1">
                                                    <i class="bi bi-image me-1"></i><?= esc($musculo['imagen'] ?? 'Sin asignar') ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Origen del Repositorio</th>
                                            <td>
                                                <span class="small text-muted font-monospace">repositorio/images/muscles/</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <a href="<?= base_url('musculo/galeria') ?>" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-grid-3x3-gap-fill me-1"></i>Ver en Galería Visual
                                </a>
                                <a href="<?= base_url('musculo/listar') ?>" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-list-task me-1"></i>Ver Catálogo Completo
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
