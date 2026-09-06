<?php

namespace App\DTO;

class UpdateCategoriaDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public ?string $nombre_categoria = null,
        public ?string $descripcion_categoria = null,
        public array $providedFields = []
    ){}

    #FUNCION PARA VALIDAR SI HUBO CAMBIOS
    public function hasChanges(){
        return $this->providedFields !== [];
    }

    public function toArray(): array
    {
        $values = [
            'nombre_categoria' => $this->nombre_categoria,
            'descripcion_categoria' => $this->descripcion_categoria,
        ];

        return array_intersect_key($values, array_flip($this->providedFields));
    }
}
