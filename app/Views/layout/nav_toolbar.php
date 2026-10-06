<div class="nav-toolbar-card p-3 mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        
        <!-- Bloque 1: Navegación entre registros -->
        <div class="d-flex align-items-center gap-1">
            <span class="text-muted small fw-semibold text-uppercase me-2 d-none d-md-inline">
                <i class="bi bi-arrows-expand me-1"></i>Navegar:
            </span>
            <div class="btn-group btn-group-sm" role="group">
                <a href="<?= base_url($module . '/elprimero') ?>" class="btn btn-outline-primary" title="Ir al Primer Registro">
                    <i class="bi bi-chevron-bar-left"></i> Primero
                </a>
                <a href="<?= base_url($module . '/anterior/' . $currentId) ?>" class="btn btn-outline-primary" title="Registro Anterior">
                    <i class="bi bi-chevron-left"></i> Anterior
                </a>
                <a href="<?= base_url($module . '/siguiente/' . $currentId) ?>" class="btn btn-outline-primary" title="Registro Siguiente">
                    Siguiente <i class="bi bi-chevron-right"></i>
                </a>
                <a href="<?= base_url($module . '/elultimo') ?>" class="btn btn-outline-primary" title="Ir al Último Registro">
                    Último <i class="bi bi-chevron-bar-right"></i>
                </a>
            </div>
        </div>

        <!-- Bloque 2: Operaciones CRUD de gestión -->
        <div class="d-flex align-items-center gap-2">
            <div class="btn-group btn-group-sm" role="group">
                <a href="<?= base_url($module . '/add') ?>" class="btn btn-success" title="Registrar Nuevo">
                    <i class="bi bi-plus-circle me-1"></i> Nuevo
                </a>
                <a href="<?= base_url($module . '/edit/' . $currentId) ?>" class="btn btn-warning text-dark" title="Editar Registro Actual">
                    <i class="bi bi-pencil-square me-1"></i> Editar
                </a>
                <button type="button" class="btn btn-danger" title="Eliminar Registro Actual" data-bs-toggle="modal" data-bs-target="#modalDeleteRecord">
                    <i class="bi bi-trash-fill me-1"></i> Borrar
                </button>
            </div>

            <a href="<?= base_url($module . '/listar') ?>" class="btn btn-info btn-sm text-white fw-semibold" title="Ver Lista de Todos los Registros">
                <i class="bi bi-table me-1"></i> Listar
            </a>
        </div>

    </div>
</div>

<!-- Modal Universal de Confirmación de Borrado -->
<div class="modal fade text-start" id="modalDeleteRecord" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Eliminación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Está seguro de que desea eliminar el registro actual <strong>#<?= esc($currentId) ?></strong>?
                <p class="text-muted small mt-2 mb-0">Esta acción removerá el registro de la base de datos.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form method="post" action="<?= base_url($module . '/delete/' . $currentId) ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger">Sí, Eliminar Registro</button>
                </form>
            </div>
        </div>
    </div>
</div>
