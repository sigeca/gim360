<?php

namespace App\Models;

trait NavigableTrait
{
    /**
     * Obtener el primer registro ordenado por clave primaria ascendente
     */
    public function elprimero()
    {
        return $this->orderBy($this->primaryKey, 'ASC')->first();
    }

    /**
     * Obtener el último registro ordenado por clave primaria descendente
     */
    public function elultimo()
    {
        return $this->orderBy($this->primaryKey, 'DESC')->first();
    }

    /**
     * Obtener el registro siguiente al ID especificado
     */
    public function siguiente($id)
    {
        $next = $this->where($this->primaryKey . ' >', $id)
                     ->orderBy($this->primaryKey, 'ASC')
                     ->first();

        return $next ?: $this->find($id) ?: $this->elultimo();
    }

    /**
     * Obtener el registro anterior al ID especificado
     */
    public function anterior($id)
    {
        $prev = $this->where($this->primaryKey . ' <', $id)
                     ->orderBy($this->primaryKey, 'DESC')
                     ->first();

        return $prev ?: $this->find($id) ?: $this->elprimero();
    }
}
