<?php

namespace App\DTO;

class StoreCategoriaDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly string $nombre_categoria,
        public readonly string $descripcion_categoria
    ){}

    public function toArray(): array
    {
        return [
            'nombre_categoria' => $this->nombre_categoria,
            'descripcion_categoria' => $this->descripcion_categoria,
        ];
    }

    public function fromArray(array $data): self
    {
        return new self(
            nombre_categoria: $data['nombre_categoria'],
            descripcion_categoria: $data['descripcion_categoria'],
        );
    }
}
