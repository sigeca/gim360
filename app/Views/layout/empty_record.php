<div class="card card-custom bg-white py-5 text-center">
    <div class="card-body">
        <i class="bi bi-inbox text-muted" style="font-size: 3.5rem;"></i>
        <h4 class="fw-bold mt-3 text-dark">No existen registros disponibles</h4>
        <p class="text-muted">Aún no se ha ingresado información en la tabla <code><?= esc($module ?? '') ?></code>.</p>
        <div class="mt-4">
            <a href="<?= base_url($module . '/add') ?>" class="btn btn-primary px-4 fw-bold">
                <i class="bi bi-plus-circle me-1"></i> Crear Primer Registro
            </a>
        </div>
    </div>
</div>
