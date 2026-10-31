<?php

namespace App\Models;

use CodeIgniter\Model;

class ComponenteNutricionalModel extends Model
{
    use NavigableTrait;

    protected $table            = 'componentenutricional';
    protected $primaryKey       = 'idcomponentenutricional';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
        'descripcion',
    ];

    protected $validationRules = [
        'nombre'      => 'required|min_length[2]|max_length[100]|is_unique[componentenutricional.nombre,idcomponentenutricional,{idcomponentenutricional}]',
        'descripcion' => 'permit_empty',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del componente nutricional es obligatorio.',
            'min_length' => 'Debe tener al menos 2 caracteres.',
            'max_length' => 'No puede superar los 100 caracteres.',
            'is_unique'  => 'Ya existe un componente nutricional registrado con este nombre.',
        ],
    ];

    /**
     * Obtiene todos los componentes nutricionales con buscador opcional
     *
     * @param string|null $search
     * @return array
     */
    public function getComponentes(?string $search = null)
    {
        $builder = $this->orderBy('idcomponentenutricional', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('nombre', $search)
                    ->orLike('descripcion', $search);
            if (is_numeric($search)) {
                $builder->orWhere('idcomponentenutricional', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }

    /**
     * Obtiene los alimentos asociados a un componente nutricional
     */
    public function getAlimentosByComponente(int $idcomponente): array
    {
        return $this->db->table('alimentocomponentenutricional acn')
            ->select('acn.idalimentocomponentenutricional,
                      a.idalimento, 
                      a.nombre AS alimento_nombre, 
                      a.descripcion AS alimento_descripcion, 
                      a.idgrupo, 
                      ga.nombre AS grupo_nombre')
            ->join('alimento a', 'a.idalimento = acn.idalimento', 'inner')
            ->join('grupoalimento ga', 'ga.idgrupoalimento = a.idgrupo', 'left')
            ->where('acn.idcomponentenutricional', $idcomponente)
            ->orderBy('a.nombre', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Obtiene las recetas que contienen alimentos con este componente nutricional
     * o que están asociadas directamente a él
     */
    public function getRecetasByComponente(int $idcomponente): array
    {
        $sql = "SELECT 
                    r.idreceta,
                    r.nombre AS receta_nombre,
                    r.porciones,
                    r.tiempopreparacion,
                    MAX(rcn.idrecetacomponentenutricional) AS idrecetacomponentenutricional,
                    GROUP_CONCAT(DISTINCT CONCAT(a.idalimento, ':', a.nombre) ORDER BY a.nombre SEPARATOR '||') AS alimentos_info,
                    COUNT(DISTINCT a.idalimento) AS total_alimentos_con_componente
                FROM receta r
                LEFT JOIN recetacomponentenutricional rcn 
                    ON rcn.idreceta = r.idreceta AND rcn.idcomponentenutricional = ?
                LEFT JOIN (
                    alimentoreceta ar
                    JOIN alimentocomponentenutricional acn 
                        ON acn.idalimento = ar.idalimento AND acn.idcomponentenutricional = ?
                    JOIN alimento a 
                        ON a.idalimento = ar.idalimento
                ) ON ar.idreceta = r.idreceta
                WHERE rcn.idcomponentenutricional IS NOT NULL OR acn.idcomponentenutricional IS NOT NULL
                GROUP BY r.idreceta, r.nombre, r.porciones, r.tiempopreparacion
                ORDER BY r.nombre ASC";

        $results = $this->db->query($sql, [$idcomponente, $idcomponente])->getResultArray();

        foreach ($results as &$row) {
            $row['alimentos'] = [];
            if (!empty($row['alimentos_info'])) {
                $items = explode('||', $row['alimentos_info']);
                foreach ($items as $item) {
                    $parts = explode(':', $item, 2);
                    if (count($parts) === 2) {
                        $row['alimentos'][] = [
                            'idalimento' => (int)$parts[0],
                            'nombre'     => $parts[1]
                        ];
                    }
                }
            }
            $row['es_directa'] = !empty($row['idrecetacomponentenutricional']);
            $row['por_ingredientes'] = (int)$row['total_alimentos_con_componente'] > 0;
        }

        return $results;
    }

    /**
     * Obtiene las imágenes asociadas a este componente nutricional
     */
    public function getImagenesByComponente(int $idcomponente): array
    {
        try {
            $builder = $this->db->table('imagencomponentenutricional icn')
                ->select('icn.idimagencomponentenutricional,
                          i.idimagen,
                          i.nombre AS imagen_nombre,
                          i.descripcion AS imagen_descripcion,
                          i.palabrasclave,
                          i.licencia,
                          fi.nombre AS formato_nombre,
                          d.nombre AS directorio_nombre,
                          d.ruta AS directorio_ruta')
                ->join('imagen i', 'i.idimagen = icn.idimagen', 'inner')
                ->join('directorio d', 'd.iddirectorio = i.iddirectorio', 'left')
                ->join('formatoimagen fi', 'fi.idformatoimagen = i.idformatoimagen', 'left')
                ->where('icn.idcomponentenutricional', $idcomponente)
                ->orderBy('icn.idimagencomponentenutricional', 'ASC');

            $imagenes = $builder->get()->getResultArray();

            $baseDir = defined('ROOTPATH') ? rtrim(ROOTPATH, '/\\') : dirname(__DIR__, 2);

            foreach ($imagenes as &$img) {
                $dirRuta = !empty($img['directorio_ruta']) ? trim($img['directorio_ruta'], '/\\') : 'repositorio/imagen';
                $cleanName = !empty($img['imagen_nombre']) ? basename(trim($img['imagen_nombre'])) : '';
                $targetFile = $baseDir . '/' . $dirRuta . '/' . $cleanName;
                $img['archivoExiste'] = !empty($cleanName) && file_exists($targetFile);
                $img['urlImagen']     = !empty($cleanName) ? base_url($dirRuta . '/' . $cleanName) : null;
                $img['urlFallback']   = !empty($cleanName) ? base_url('imagen/imagen/' . $cleanName) : null;
            }

            return $imagenes;
        } catch (\Throwable $e) {
            return [];
        }
    }
}
