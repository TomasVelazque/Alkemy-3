<?php

namespace App\DTO;

class UpdateProductoDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public ?string $nombre_producto = null,
        public ?string $descripcion_producto = null,
        public ?float $precio_producto = null,
        public ?int $stock_producto = null,
        public ?int $categoria_id = null,
        public array $providedFields = []
    ){}

    public function hasChanges()
    {
        return $this->providedFields !== [];
    }

    public function toArray(): array
    {
        $values = [
            'nombre_producto' => $this->nombre_producto,
            'descripcion_producto' => $this->descripcion_producto,
            'precio_producto' => $this->precio_producto,
            'stock_producto' => $this->stock_producto,
            'categoria_id' => $this->categoria_id,
        ];

        return array_intersect_key($values, array_flip($this->providedFields));
    }
}
