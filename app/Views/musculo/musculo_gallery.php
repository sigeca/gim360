<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h2 class="fw-bold mb-1 text-dark">
            <i class="bi bi-grid-3x3-gap-fill text-danger me-2"></i>Galería Visual de Músculos
        </h2>
        <p class="text-muted mb-0">Colección anatómica completa de músculos del sistema (27 grupos musculares cargados).</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('musculo/listar') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver a Lista
        </a>
        <a href="<?= base_url('musculo/add') ?>" class="btn btn-danger text-white">
            <i class="bi bi-plus-circle me-1"></i> + Nuevo Músculo
        </a>
    </div>
</div>

<!-- Filtro rápido en cliente con JavaScript -->
<div class="card card-custom bg-white mb-4 shadow-sm">
    <div class="card-body p-3">
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0"><i class="bi bi-funnel text-muted"></i></span>
            <input type="text" id="filterInput" class="form-control border-start-0" placeholder="Filtrar en tiempo real (ej. deltoides, bíceps, glúteo, dorsal)...">
            <span class="input-group-text bg-light" id="filterCounter"><?= count($musculos) ?> músculos</span>
        </div>
    </div>
</div>

<div class="row g-4" id="galleryContainer">
    <?php foreach ($musculos as $m): ?>
        <div class="col-6 col-md-4 col-lg-3 col-xl-2 muscle-item" data-name="<?= strtolower(esc($m['nombre'])) ?>">
            <div class="card h-100 bg-white border-0 shadow-sm rounded-4 overflow-hidden text-center muscle-card hover-lift">
                <a href="<?= base_url('musculo/actual/' . $m['idmusculo']) ?>" class="text-decoration-none">
                    <div class="p-3 bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                        <?php if (!empty($m['imagen'])): ?>
                            <img src="<?= base_url('repositorio/images/muscles/' . esc($m['imagen'])) ?>" 
                                 onerror="this.onerror=null; this.src='<?= base_url('uploads/muscles/' . esc($m['imagen'])) ?>';"
                                 alt="<?= esc($m['nombre']) ?>" 
                                 class="img-fluid" 
                                 style="max-height: 150px; object-fit: contain; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.08));"
                                 loading="lazy">
                        <?php else: ?>
                            <i class="bi bi-image text-muted fs-1"></i>
                        <?php endif; ?>
                    </div>
                </a>
                <div class="card-body p-2 d-flex flex-column justify-content-between">
                    <h6 class="fw-bold text-dark mb-0 fs-6 text-truncate" title="<?= esc($m['nombre']) ?>">
                        <?= esc($m['nombre']) ?>
                    </h6>
                    <small class="text-muted d-block text-truncate" style="font-size: 0.75rem;">
                        #<?= $m['idmusculo'] ?> · <?= esc($m['imagen']) ?>
                    </small>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0 pb-2 px-2">
                    <a href="<?= base_url('musculo/actual/' . $m['idmusculo']) ?>" class="btn btn-outline-danger btn-sm w-100 py-1" style="font-size: 0.8rem;">
                        <i class="bi bi-eye me-1"></i>Ver Ficha
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<style>
.hover-lift {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(220, 53, 69, 0.15) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterInput = document.getElementById('filterInput');
    const items = document.querySelectorAll('.muscle-item');
    const counter = document.getElementById('filterCounter');

    if (filterInput) {
        filterInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            let visible = 0;

            items.forEach(item => {
                const name = item.getAttribute('data-name');
                if (name.includes(query)) {
                    item.style.display = '';
                    visible++;
                } else {
                    item.style.display = 'none';
                }
            });

            counter.textContent = visible + ' ' + (visible === 1 ? 'músculo' : 'músculos');
        });
    }
});
</script>

<?= $this->endSection() ?>
