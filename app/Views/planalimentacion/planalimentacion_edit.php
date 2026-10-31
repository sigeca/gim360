<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-custom bg-white shadow-sm border-top border-4 border-warning">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <i class="bi bi-pencil-square text-warning me-2"></i>Editar Plan de Alimentación: <?= esc($plan['nombre']) ?>
                </h5>
                <a href="<?= base_url('planalimentacion/actual/' . $plan['idplanalimentacion']) ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Volver a la Ficha
                </a>
            </div>
            <div class="card-body p-4">

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Por favor corrige los siguientes errores:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('planalimentacion/update/' . $plan['idplanalimentacion']) ?>" method="post">
                    <?= csrf_field() ?>

                    <!-- Persona asignada -->
                    <div class="mb-3">
                        <label for="idpersona" class="form-label fw-bold">
                            Persona Asignada <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill text-primary"></i></span>
                            <select name="idpersona" id="idpersona" class="form-select <?= session('errors.idpersona') ? 'is-invalid' : '' ?>" required>
                                <option value="">-- Seleccione una persona --</option>
                                <?php 
                                    $currPersona = old('idpersona', $plan['idpersona']);
                                    foreach ($personas as $p): 
                                ?>
                                    <option value="<?= $p['idpersona'] ?>" <?= ((string)$currPersona === (string)$p['idpersona']) ? 'selected' : '' ?>>
                                        <?= esc($p['apellidos']) ?>, <?= esc($p['nombres']) ?> (C.I. <?= esc($p['cedula']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Nombre del Plan -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">
                            Nombre del Plan <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-bookmark-fill text-success"></i></span>
                            <input type="text" 
                                   class="form-control <?= session('errors.nombre') ? 'is-invalid' : '' ?>" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="<?= old('nombre', $plan['nombre']) ?>" 
                                   maxlength="150" 
                                   required 
                                   autofocus>
                        </div>
                    </div>

                    <!-- Rango de Fechas -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="fechainicio" class="form-label fw-bold">
                                Fecha de Inicio <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-event text-primary"></i></span>
                                <input type="date" 
                                       class="form-control <?= session('errors.fechainicio') ? 'is-invalid' : '' ?>" 
                                       id="fechainicio" 
                                       name="fechainicio" 
                                       value="<?= old('fechainicio', $plan['fechainicio']) ?>" 
                                       required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="fechafin" class="form-label fw-semibold">
                                Fecha de Fin (Opcional)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-check text-secondary"></i></span>
                                <input type="date" 
                                       class="form-control <?= session('errors.fechafin') ? 'is-invalid' : '' ?>" 
                                       id="fechafin" 
                                       name="fechafin" 
                                       value="<?= old('fechafin', $plan['fechafin']) ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Objetivo Nutricional Catalogado -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="idobjetivonutricional" class="form-label fw-bold mb-0">
                                Objetivo Nutricional
                            </label>
                            <a href="<?= base_url('objetivonutricional/add') ?>" target="_blank" class="small text-decoration-none text-success">
                                <i class="bi bi-plus-circle me-1"></i>Gestionar Objetivos
                            </a>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-bullseye text-warning"></i></span>
                            <select name="idobjetivonutricional" id="idobjetivonutricional" class="form-select <?= session('errors.idobjetivonutricional') ? 'is-invalid' : '' ?>">
                                <option value="">-- Seleccionar objetivo predeterminado (Opcional) --</option>
                                <?php 
                                    $currObj = old('idobjetivonutricional', $plan['idobjetivonutricional'] ?? '');
                                    foreach ($objetivos as $obj): 
                                ?>
                                    <option value="<?= $obj['idobjetivonutricional'] ?>" <?= ((string)$currObj === (string)$obj['idobjetivonutricional']) ? 'selected' : '' ?>>
                                        <?= esc($obj['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-text text-muted">Objetivo catalogado vinculado al plan.</div>
                    </div>

                    <!-- Objetivo / Observaciones -->
                    <div class="mb-4">
                        <label for="objetivo" class="form-label fw-semibold">
                            Detalles / Observaciones del Objetivo
                        </label>
                        <textarea name="objetivo" 
                                  id="objetivo" 
                                  rows="3" 
                                  class="form-control <?= session('errors.objetivo') ? 'is-invalid' : '' ?>" 
                                  placeholder="Metas calóricas, recomposición corporal, reducción de grasa..."><?= old('objetivo', $plan['objetivo']) ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('planalimentacion/actual/' . $plan['idplanalimentacion']) ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Guardar Cambios
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
