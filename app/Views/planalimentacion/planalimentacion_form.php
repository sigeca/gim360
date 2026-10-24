<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card card-custom bg-white shadow-sm border-top border-4 border-success">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                    <i class="bi bi-plus-circle-fill text-success me-2"></i>Registrar Plan de Alimentación
                </h5>
                <a href="<?= base_url('planalimentacion/listar') ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Volver a la Lista
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

                <form action="<?= base_url('planalimentacion/save') ?>" method="post">
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
                                    $currPersona = old('idpersona', $idpersonaPreselected ?? '');
                                    foreach ($personas as $p): 
                                ?>
                                    <option value="<?= $p['idpersona'] ?>" <?= ((string)$currPersona === (string)$p['idpersona']) ? 'selected' : '' ?>>
                                        <?= esc($p['apellidos']) ?>, <?= esc($p['nombres']) ?> (C.I. <?= esc($p['cedula']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-text text-muted">Persona titular a quien se prescribe o planifica esta dieta.</div>
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
                                   value="<?= old('nombre') ?>" 
                                   placeholder="Ej: Plan de Definición y Fuerza, Dieta Normocalórica, etc." 
                                   maxlength="150" 
                                   required 
                                   autofocus>
                        </div>
                        <div class="form-text text-muted">Título identificativo del plan de nutrición.</div>
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
                                       value="<?= old('fechainicio', date('Y-m-d')) ?>" 
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
                                       value="<?= old('fechafin') ?>">
                            </div>
                            <div class="form-text text-muted">Dejar en blanco si el plan es abierto o indefinido.</div>
                        </div>
                    </div>

                    <!-- Objetivo -->
                    <div class="mb-4">
                        <label for="objetivo" class="form-label fw-semibold">
                            Objetivo Nutricional
                        </label>
                        <textarea name="objetivo" 
                                  id="objetivo" 
                                  rows="4" 
                                  class="form-control <?= session('errors.objetivo') ? 'is-invalid' : '' ?>" 
                                  placeholder="Metas calóricas, recomposición corporal, reducción de grasa, ganancia muscular, preparación pre-competencia..."><?= old('objetivo') ?></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('planalimentacion') ?>" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-success fw-bold px-4">
                            <i class="bi bi-check-circle me-1"></i> Guardar Plan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
