<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-custom bg-white border-top border-4 border-success shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-joystick text-success me-2"></i>Registrar Juego Tradicional</h5>
                <a href="<?= base_url('juego') ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Regresar</a>
            </div>
            <div class="card-body p-4">
                <?php if (session('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session('errors') as $err): ?><li><?= esc($err) ?></li><?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('juego/save') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">Nombre del Juego Tradicional <span class="text-danger">*</span></label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?= old('nombre') ?>" placeholder="Ej: Ajedrez Clásico, Tres en Raya, Sudoku, Damas..." required maxlength="150">
                    </div>
                    <div class="mb-3">
                        <label for="categoria" class="form-label fw-bold">Categoría</label>
                        <input type="text" name="categoria" id="categoria" class="form-control" value="<?= old('categoria') ?>" placeholder="Ej: Estrategia / Tablero / Cartas / Lógica" maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label for="enlace" class="form-label fw-bold">Enlace (URL del Juego) <span class="text-danger">*</span></label>
                        <input type="url" name="enlace" id="enlace" class="form-control" value="<?= old('enlace') ?>" placeholder="https://lichess.org/ o enlace al juego" required maxlength="500">
                    </div>
                    <div class="mb-4">
                        <label for="descripcion" class="form-label fw-bold">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="2" class="form-control"><?= old('descripcion') ?></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('juego') ?>" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success"><i class="bi bi-save me-1"></i>Guardar Juego</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
