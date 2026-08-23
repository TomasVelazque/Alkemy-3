<?php

namespace App\DTO;

class ProductoDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $nombre_producto,
        public readonly ?string $descripcion_producto,
        public readonly float $precio_producto,
        public readonly int $stock_producto,
        public readonly int $categoria_id,
    )
    {
        //
    }

    public function toArray(): array
    {
        return [
            'nombre_producto' => $this->nombre_producto,
            'descripcion_producto' => $this->descripcion_producto,
            'precio_producto' => $this->precio_producto,
            'stock_producto' => $this->stock_producto,
            'categoria_id' => $this->categoria_id,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            nombre_producto: $data['nombre_producto'],
            descripcion_producto: $data['descripcion_producto'] ?? null,
            precio_producto: (float) $data['precio_producto'],
            stock_producto: (int) $data['stock_producto'],
            categoria_id: (int) $data['categoria_id'],
        );
    }
}
